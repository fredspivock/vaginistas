<!-- Page Title -->
<div id="EditCreateArticleTitle">Edit Article</div>

<!--Edit Form -->
{!! Form::model($article, ['method' => 'PATCH', 'action' =>['ArticlesController@update', $article->id] , 'files' => true ]) !!}

@include('partials.ArticleFormPartial')

{!! Form::close() !!}

@include('partials.ArticleErrorFormPartial')