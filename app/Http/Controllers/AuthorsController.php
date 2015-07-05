<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\AuthorRequest;
use App\Author;
Use Input;
Use Auth;
Use Flash;
Use App\Http\Requests\imageSaveRequest;
Use Image;
use App\User;
use App\Like;

use Illuminate\Http\Request;

class AuthorsController extends Controller {



	/*
	*
	*	Make sure users are authenticated on the following pages
	*/
		public function __construct()
	{
		$this->middleware('auth', ['only' => ['create', 'edit', 'index'] ]);
	}


	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$user = Auth::user()->id;

		//Check to see if author has created profile, if not redirect them to create a profile.
		if($author = Author::where('user_id', '=', $user)->first())
		{
			return redirect('authors/'. $author->id);
		}
		else
		{
			return redirect('authors/create');
		}

		

	}
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$user = Auth::User();

		$author =Author::where('user_id', '=', $user->id)->first();

		if(is_null($author))
		{
			return view('CreateAuthorsProfile');
		}
		else
		{

			return redirect('authors/'.$author->id.'/edit');
		}

		
	}
	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(AuthorRequest $request)
	{
		//
		$author = new author($request->all());

		//Check if thumbnail is there
		if(Input::file('profilePicture'))
		{
			//get thumbnail
			$file = Input::file('profilePicture');

			

			//Checked if the file exists
			if(file_exists( article_photo_path() ))
			{}
			else
			{
				mkdir( article_photo_path(), 0777, true );
			}
			
			$fileName = $file->getClientOriginalName();
			//move from temp to new location
			$file = $file->move( article_photo_path() , 'Author'. $fileName );

			//save the path
			$author->image_path = article_photo_path_short() . 'Author' . $fileName ;
		}


		Auth::user()->authors()->save($author);

		Flash::success('Article Saved');

		return redirect('authors/imageEditor/' . $author->id);


	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show(Author $author)
	{

		$user = User::findorfail($author->user_id);



		
		if(Auth::user())
		{
			$currentUser = Auth::user()->id;
			$isAuthor = $this->AuthAuthor($currentUser ,$author->user_id);
		}

		


		return view( 'ShowSingleAuthor' , compact('author', 'user', 'isAuthor'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{

		$user = Auth::user()->id;
		$author = $id;

		if($user === $author->user_id)
		{
			return view('EditAuthorsProfile', compact('author'));
		}
		else
		{
			return view('articles');
		}

	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, AuthorRequest $request)
	{

		$author = $id;

		$author->update($request->all());

		//Check if thumbnail is there
		if(Input::file('profilePicture'))
		{
			//get thumbnail
			$file = Input::file('profilePicture');

			

			//Checked if the file exists
			file_exists( article_photo_path() ) or mkdir( article_photo_path(), 0777, true ) ;
			
			$fileName = $file->getClientOriginalName();
			//move from temp to new location
			$file = $file->move( article_photo_path() , 'Author'. $fileName );

			//save the path
			$author->image_path = article_photo_path_short() . 'Author' . $fileName ;
		}

		//dd($author);

		$author->save();


		//flash message

		Flash::success('Profile Updated');

		return redirect('authors/imageEditor/'. $author->id);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

	/*
	*
	*	Controls the image editing procress
	*/
	public function imageEditor($authorId)
	{
		$author = Author::findorfail($authorId);

		$authorImagePath = $author->image_path;

		return view('CreateAuthorImageEdit', compact('authorImagePath'));

	}

	public function imageSave(imageSaveRequest $request)
	{

		$imageCrop = $request->all();

		$img = Image::make(public_path() . $imageCrop['path']);

		$img->resize($imageCrop['image_width'], $imageCrop['image_height'] )->crop(200,200, $imageCrop['crop_x'], $imageCrop['crop_y']);

		$img->save(public_path() . $imageCrop['path']);

		return redirect('articles');

	}



	private function AuthAuthor($currentUser, $articleUserId)
	{	
		//if current user is not logged in and object is null
		if($currentUser === null)
		{
			return false;
		}

		//
		if($currentUser === $articleUserId)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

}
