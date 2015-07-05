<?php namespace App\Http\Controllers;

use App\Http\Requests;
use Request;
use App\Http\Controllers\Controller;
use App\User;
use App\article;
use App\Http\Requests\ArticleRequest;
Use Auth;
Use Flash;
Use Input;
Use Carbon\Carbon;
Use Image;
Use App\Http\Requests\imageSaveRequest;
Use App\Tag;
Use App\Author;


//Experimental


class ArticlesController extends Controller {

	/**
	 *
	 *	Make sure you are authentgicated to create, edit and add articles
	 *	
	 */
	public function __construct()
	{
		$this->middleware('auth', ['only' => ['create', 'edit'] ]);
	}


	/**
	 * Display a list of all the articles starting with the most recent
	 *
	 * @return Response
	 */
	public function index()
	{
		//Get by newest published
		$articles = article::PublishedAtDesc()->Published()->simplePaginate(10);

		//
		$indexedBy = 'Newest Articles';

		foreach($articles as $article)
		{

			$article->diff = $article->published_at->diffForHumans();
		}



		//renders index view with artcles
		return view('index', compact('articles', 'indexedBy'));
	}

	/**
	 * Display a list of all the articles containing a chosen tag
	 *
	 * @return Response
	 */
	public function indexTags($tagId)
	{

		$articles = Tag::find($tagId)->article()->paginate(10);
		$tag = Tag::find($tagId);

		$indexedBy = 'Articles with ' . $tag->name ;

		return view('index', compact('articles', 'indexedBy'));

		
		//renders index view with artcles
		return redirect('articles');
	}

	/**
	 * Display a list of all the articles with an Autor
	 *
	 * @return Response
	 */
	public function indexAuthor()
	{
		$user = Auth::user();

		$articles = Article::where('user_id', '=', $user->id)->simplePaginate(10);

		$indexedBy = 'Articles by '. $user->name;

		return view('index', compact('articles', 'indexedBy'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
		$tags = Tag::lists('name', 'id');



		$tags = addHashTag($tags);

		return view('CreateArticle', compact('tags'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(ArticleRequest $request)
	{
		
		$article = new article($request->all());


		//Check if thumbnail is there
		if(Input::file('thumbnail'))
		{
			//get thumbnail
			$file = Input::file('thumbnail');

			

			//Checked if the file exists
			file_exists( article_photo_path() ) or mkdir( article_photo_path(), 0777, true );
			
			$fileName = $file->getClientOriginalName();
			//move from temp to new location
			$file = $file->move( article_photo_path() , $fileName );

			//save the path
			$article->image_path = article_photo_path_short() . $fileName ;
		}

		//save user and save the whole shabang
		Auth::user()->articles()->save($article);

		//Tag Ids set Tags

		$tagIds = $request->input('tag_list');

		if($tagIds !== null)
		{
			//check for new tags and save them here
			$newTags = isNewTag($tagIds);

			//creates New tags and returns their database id
		
			$enteredNewTags = $this->createNewTags($newTags);

			//removes new tags
			$tagIds = removeNewTags($tagIds, $enteredNewTags);


			//attaches tags
			$article->tags()->attach($tagIds);

			$article->tags()->attach($enteredNewTags);

		}
		//flash message
		Flash::success('Article Saved');

		
		return redirect('articles/imageEditor/'. $article->id);

	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//make sure
		$article = article::findorfail($id);

		$currentUser = Auth::user();

		$User = User::findorfail($article->user_id);
		
		$isAuthor = $this->isAuthor($currentUser, $article->user_id);

		if($authorId = Author::where('user_id', $User->id )->first())
		{
			$authorId = $authorId->id;
		}

		


		
		return view( 'ShowSingleArticle', compact('article', 'isAuthor', 'User', 'authorId') );
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//

		$article = article::findorfail($id);
		$currentUser = Auth::user()->id;
		$tags = Tag::lists('name', 'id');

		//if User is authenticated, display form to edit
		if( $currentUser === $article['user_id'])
		{

			return view('EditArticle', compact('article', 'tags'));
		}
		Flash::error('You can only edit articles associated with your account ');
		//otherwise redirect
		return redirect('articles');
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, ArticleRequest $request )
	{
		//find article by its id
		$article = Article::findOrFail($id);

		$article->update($request->all());

		//upload new image

			//get thumbnail
			$file = Input::file('thumbnail');

			

			//Checked if the file exists
			file_exists( article_photo_path() ) or mkdir( article_photo_path(), 0777, true );
			
			$fileName = $file->getClientOriginalName();
			//move from temp to new location
			$file = $file->move( article_photo_path() , $fileName );

			//save the path
			$article->image_path = article_photo_path_short() . $fileName ;


		//syncs the tags

		$tags= (array) Input::get('tag_list');

		$this->syncTags($article, $tags);

		//save user and save the whole shabang
		Auth::user()->articles()->save($article);

		//flash message

		Flash::success('Article Updated');

		return redirect('articles/imageEditor/'. $article->id);

	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{

		//Deletes Article
		$article = Article::findOrFail($id);

		$article->delete();
		
		//redirect to articles
		return redirect('articles');
	}

	/**
	*
	*
	*/
	public function imageEditor($articleId)
	{
		$article = Article::findorfail($articleId);

		$articleImagePath = $article->image_path;

		return view('CreateArticleImageEdit', compact('articleImagePath'));
	}

	/**
	*Saves edited image
	*Request includes Path of FIle, cropx, crop y and uses contants for image size.
	*/
	public function imageSave(imageSaveRequest $request)
	{
		$imageCrop = $request->all();

		$img = Image::make(public_path() . $imageCrop['path']);

		$img->resize($imageCrop['image_width'], $imageCrop['image_height'] )->crop(960,400, $imageCrop['crop_x'], $imageCrop['crop_y']);

		$img->save(public_path() . $imageCrop['path']);

		return redirect('articles');

	}


	//sync tags
	private function syncTags(Article $article, array $tags)
	{
		$article->tags()->sync($tags);
	}

	//Create New Tags, returns ids
	private function createNewTags($tags)
	{

		//array of new tags
		$newTagsIds = [];

		$index = 0;

		foreach($tags as $tag)
		{


			$newTag = new Tag;

			$newTag->name = $tag;

			$newTag->save();

			$newTagsIds[$index] = $newTag->id;

			$index++;
		}

		return $newTagsIds;
	}

	//checks if user that is logged in wrote the current article
	private function isAuthor($currentUser, $articleUserId)
	{	
		//if current user is not logged in and object is null
		if($currentUser === null)
		{
			return false;
		}

		//
		if($currentUser->id === $articleUserId)
		{
			return true;
		}
		else
		{
			return false;
		}
	}






}
