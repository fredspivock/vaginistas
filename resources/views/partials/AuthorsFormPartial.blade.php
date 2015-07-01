	<div id="authorsForm" class="form-group">


		{!! Form::label('profile', 'Profile') !!}
		{!! Form::textarea('profile', null, ['class' => 'form-control'])!!}


		<!-- Upload images-->
		<div id="fileupload">
		{!! Form::label('profilePicture', 'Upload A Picture') !!}
		{!! Form::file('profilePicture', ['class' => 'uploadto']) !!}
		</div>



		{!! Form::submit('Add Article', ['class'=> 'btn btn-primary form-control']) !!}

	</div>