@extends('app')

@section('content')

<img id="SingleAuthorProfilePicture" class="img-responsive img-circle" src="{{ $author->image_path }}"></img>
<div id="SingleAuthor">

	<div id="SingleAuthorInnerText">

		<div id="SingleAuthorName">{{ $user->name}}</div>

		<div id="SingleAuthorProfile">{{ $author->profile }}</div>

	@if(isset($isAuthor))
	@if($isAuthor === true)
<!-- Article Controls -->
	<div id="SingleAuthorButtons">
	@include('partials.AuthorAuthUserButtonsPartial')
	</div>
@endif

@endif


</div>
</div>


@endsection