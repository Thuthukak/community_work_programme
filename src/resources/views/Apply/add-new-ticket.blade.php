<div class="modal fade" id="AddTicketModal" tabindex="-1" role="dialog" aria-labelledby="AddTicketModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="AddTicketModalLabel">Submit Ticket</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="add-ticket-form" method="POST" action="{{ route('new-ticket-store.store') }}">
                    @csrf
                    <div class="card-body">
                        <div class="text-center">
                            <i class="fa fa-question fa-2x"></i>
                            <h2 class="card-title">{{ __('theme.whats_happening_write_us') }}</h2>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-8 {{ $errors->has('title') ? ' has-error' : '' }}">
                                <label for="title">Title</label>
                                <input id="title" type="text" class="form-control" name="title" value="{{ old('title') }}" placeholder="{{ __('theme.enter_problem_title') }}" required>
                                @if ($errors->has('title'))
                                    <span class="text-danger">{{ $errors->first('title') }}</span>
                                @endif
                            </div>
                            <div class="form-group col-md-6">
                                <label for="priority">{{ __('theme.priority') }}</label>
                                <select id="priority" class="form-control {{ $errors->has('priority') ? ' has-error' : '' }}" name="priority">
                                    <option value="">{{ __('theme.select_priority') }}</option>
                                    <option value="low">{{ __('theme.low') }}</option>
                                    <option value="medium">{{ __('theme.medium') }}</option>
                                    <option value="high">{{ __('theme.high') }}</option>
                                </select>
                                @if ($errors->has('priority'))
                                    <span class="text-danger">{{ $errors->first('priority') }}</span>
                                @endif
                            </div>
                            <div class="form-group col-md-12">
                                <label for="message">{{ __('theme.message') }}</label>
                                <textarea rows="6" id="message" class="form-control my-editor {{ $errors->has('message') ? ' has-error' : '' }}" name="message">{{ old('message') }}</textarea>
                                @if ($errors->has('message'))
                                    <span class="text-danger">{{ $errors->first('message') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
