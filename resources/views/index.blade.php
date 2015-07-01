@extends('app')

@section('content')
	
<!-- <div id="indexAll"> -->
	
	@foreach ($articles as $article)
	
	<div id="indexArticle">
			<a  href="{{ action('ArticlesController@show', [$article->id]) }}"><img class="img img-responsive indexArticleImage"src="{{ $article->image_path }}"></img></a>
			<p class="indexArticleTitle">{{ $article->title }}</p>
			<p class="indexArticleTime">{{ $article->diff }}</p>

		
	</div>
	@endforeach

	{!! $articles->render() !!}

<!-- </div> -->
@endsection