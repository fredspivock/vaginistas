<!-- Page Title -->
<div id="EditCreateArticleTitle">Create Article</div>

<!--Create Form title -->
{!! Form::open(['url' => 'articles', 'files' => true]) !!}

@include('partials.ArticleFormPartial')

{!! Form::close() !!}
