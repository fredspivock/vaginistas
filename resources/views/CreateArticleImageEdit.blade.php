@extends('app')

@section('content')
<div id="editImageTitle" class="titles">Edit Your Article's Image:</div>
<div class ="pane clearfix">

	<img id='imageEdit'src="{{ $articleImagePath }}"></img>
	<table class="coords">
		{!! Form::open(['action' => array('ArticlesController@imageSave', 'path' => $articleImagePath), 'onsubmit'=>'multiplierfunc()']) !!}
        	<tr><td>crop x: </td><td>{!! Form::text('crop x', null, ['class'=> 'form-control', 'readonly'] ) !!}</td></tr>
       		<tr><td>crop y: </td><td>{!! Form::text('crop y', null, ['class'=> 'form-control', 'readonly'] ) !!}</td></tr>
        	<tr><td>image width: </td><td>{!! Form::text('image width', null, ['class'=> 'form-control', 'readonly'] ) !!}</td></tr>
        	<tr><td>image height: </td><td>{!! Form::text('image height', null, ['class'=> 'form-control', 'readonly'] ) !!}</td></tr>
        	<tr><td>image width: </td><td>{!! Form::text('image width', null, ['class'=> 'form-control', 'readonly', 'id' => 'imageWidth']) !!}</td></tr>
        	<tr><td>image height: </td><td>{!! Form::text('image height', null, ['class'=> 'form-control', 'readonly', 'id' => 'imageHeight'] ) !!}</td></tr>
    </table>
       		<td>{!! Form::submit('Save Image', ['class' => 'btn btn-primary form-control']) !!}</td>
       	{!! Form::close() !!}


</div>


	




@endsection