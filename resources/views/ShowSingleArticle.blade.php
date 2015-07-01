@extends('app')

@section('content')



<div id= "SingleArticle">
	<img src="{{ $article->image_path }}" class="img-responsive"></img>
	<div id="SingleArticleText">
		<div id="SingleArticleTitle">{{ $article->title }}</div>
		<div id="SingleArticleAuthor">Written by <a href="{{ url('authors/'. $authorId) }}">{{ $User->name }}</a></div>
		<div id="SingleArticleBody">{{  $article->body }}</div>
		<div id="SingleArticleTag">
		
		@unless($article->tags->isEmpty())
			<h5>Tags:</h5>
			<ul>
				@foreach($article->tags as $tag)

					<a href="{{ URL::action('ArticlesController@indexTags', [$tag->id]) }}"><li class="articleTags">{{$tag->name}}</li></a>	

				@endforeach
			</ul>
		</div>

		@endunless

		@if($isAuthor === true)
	<!-- Article Controls -->
	<div id="SingleArticleButtons">
		@include('partials.ArticleAuthUserButtonsPartial')
		@include('partials.DeleteModal')
	</div>
@endif
	</div>

	
</div>


@endsection