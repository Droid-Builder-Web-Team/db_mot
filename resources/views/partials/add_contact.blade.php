<div class="modal fade" id="addContactModal" tabindex="-1" role="dialog" aria-
            labelledby="addContactModalLabel" aria-hidden="true">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="addContactModalLabel">{{ __('Add Contact') }}</h5>
								<button type="button" class="close" data-dismiss="modal" aria-
                                label="Close" id=close-button>
									<span aria-hidden="true">&times;</span>
								</button>
						</div>
                        <div>
                            <form action="{{ route('admin.contacts.link') }}" method="POST">
                                @csrf
                                <select class="form-control" name="contact_id">
                                    @foreach($contacts as $contact)
                                        <option value="{{ $contact->id }}">{{ $contact->name }}</option>
                                    @endforeach
                                </select>
                                <input type="hidden" name="model_id" value="{{ $model_id }}">
                                <input type="hidden" name="model_type" value="{{ $model_type }}">
                        </div>
						<div class="modal-footer">
							<input type="submit" class="btn btn-primary" value="Link Contact">
                            <a class="btn btn-info" href="{{ route('admin.contacts.create') }}">{{ __('Create New Contact') }}</a>
						</div>
					</div>
				</div>
			</div>
