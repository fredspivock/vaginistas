<!-- Page Title -->
<div id="CreateAuthorsTitle">Create Author Profile</div>

<!--Create Form title -->
{!! Form::open(['url' => 'authors', 'files' => true]) !!}

@include('partials.AuthorsFormPartial')

{!! Form::close() !!}

@include('partials.ArticleErrorFormPartial')