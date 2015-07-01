	<div id="articleForm" class="form-group">

		{!! Form::label('title', 'Title') !!}
		{!! Form::text('title', null, ['class' =>'form-control']) !!}

		{!! Form::label('body', 'Body') !!}
		{!! Form::textarea('body', null, ['class' => 'form-control'])!!}


		{!! Form::label('published_at', "Publish On") !!}
		{!! Form::text('published_at', date('Y-m-d'), ['id'=> 'datepicker', 'class' => 'form-control'])!!}
		
		<!-- tags -->
		{!! Form::label('tag_list', 'Tags') !!}
		{!! Form::select('tag_list[]', $tags, null, ['class' => 'form-control', 'multiple']) !!}


		<!-- Upload images-->
		<div id="fileupload">
		{!! Form::label('thumbnail', 'Upload A Picture') !!}
		{!! Form::file('thumbnail', ['class' => 'uploadto']) !!}
		</div>



		{!! Form::submit('Add Article', ['class'=> 'btn btn-primary form-control']) !!}

	</div>