<div id="ArticleControls">
		{!! Form::open(['method' => 'get','url' => 'authors/'. $author->id. '/edit', 'id' => 'editButton']) !!}
			{!! Form::submit('Edit', ['class' => 'btn btn-default']) !!}
		{!! Form::close() !!}
</div>