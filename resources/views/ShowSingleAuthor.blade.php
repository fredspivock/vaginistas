@extends('app')

@section('content')

<img id="SingleAuthorProfilePicture" class="img-responsive img-circle" src="{{ $author->image_path }}"></img>
<div id="SingleAuthor">

	<div id="SingleAuthorInnerText">

		<div id="SingleAuthorName">{{ $user->name}}</div>

		<div id="SingleAuthorProfile">{{ $author->profile }}</div>
	@if($isAuthor === true)
<!-- Article Controls -->
	<div id="SingleAuthorButtons">
	@include('partials.AuthorAuthUserButtonsPartial')
	</div>
@endif


</div>
</div>


@endsection