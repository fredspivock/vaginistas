<div id="ArticleControls">
		{!! Form::open(['method' => 'get','url' => 'articles/'. $article->id. '/edit', 'id' => 'editButton']) !!}
			{!! Form::submit('Edit', ['class' => 'btn btn-default']) !!}
		{!! Form::close() !!}

	<div id="deleteButton">
		{!! Form::open(['onsubmit'=> 'return false']) !!}
			{!! Form::submit('Delete', ['class' => 'btn btn-danger', 'data-toggle' => 'modal', 'data-target' => '#deleteModal', 'id' => 'deleteButton']) !!}
		{!! Form::close()!!}
	</div>
</div>