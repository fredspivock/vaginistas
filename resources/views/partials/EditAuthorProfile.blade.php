<!-- Page Title -->
<div id="EditAuthorsTitle">Edit Author Profile</div>

<!--Create Form title -->
{!! Form::model($author, ['method' => 'PATCH', 'action' =>['AuthorsController@update', $author->id] , 'files' => true ]) !!}


@include('partials.AuthorsFormPartial')

{!! Form::close() !!}

@include('partials.ArticleErrorFormPartial')