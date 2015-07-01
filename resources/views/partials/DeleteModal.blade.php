<!-- Modal -->
<div id="deleteModal" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Delete?</h4>
			</div>
			<div class="modal-body">
				<p>Are you sure you want to delete this article? This action cannot be undone.</p>
			</div>
			<div class="modal-footer">

					<button id="modalCancelButton" type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>


				{!! Form::open(['method' => 'delete', 'url' => 'articles/' . $article->id, 'id' => 'modalDeleteButton']) !!}
					{!! Form::submit('Delete', ['class' => 'btn btn-danger'])!!}
				{!! Form::close() !!}

			</div>
		</div>
	</div>
</div>