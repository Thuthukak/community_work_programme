
<div class="container-fluid">
    <h4 class="page-title">{{ __('theme.count_info_setting') }}</h4>
    <div class="card mb-4">
        <div class="card-body">
            @include('tickets.flash')
            <form action="#" method="post">
                @csrf
                @method('PUT')
                <div class="row  container-fluid">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="departure_currier text-uppercase"><strong>{{ __('theme.tickets') }}</strong></label>
                            <input class="form-control form-control-lg mb-3 {{ $errors->has('ticket_counter') ? ' is-invalid' : '' }}" name="ticket_counter" value="" type="text" required>
                            @if ($errors->has('ticket_counter'))
                                <span class="invalid-feedback d-block">
                                    <strong>{{ $errors->first('ticket_counter') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div> 
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="upcoming_currier text-uppercase"><strong>{{ __('theme.ticket_solved') }}</strong></label>
                            <input class="form-control form-control-lg mb-3 {{ $errors->has('ticket_solved') ? ' is-invalid' : '' }}" name="ticket_solved" value=""  type="text" required>
                            @if ($errors->has('ticket_solved'))
                                <span class="invalid-feedback d-block">
                                    <strong>{{ $errors->first('ticket_solved') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div> 
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="kb_counter text-uppercase"><strong>{{ __('theme.knowledge_base') }}</strong></label>
                            <input id="kb_counter" class="form-control form-control-lg mb-3 {{ $errors->has('kb_counter') ? ' is-invalid' : '' }}" name="kb_counter" value="" type="text" required>
                            @if ($errors->has('kb_counter'))
                                <span class="invalid-feedback d-block">
                                    <strong>{{ $errors->first('kb_counter') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="client_counter text-uppercase"><strong>{{ __('theme.happy_client') }}</strong></label>
                            <input id="client_counter" class="form-control form-control-lg mb-3 {{ $errors->has('client_counter') ? ' is-invalid' : '' }}" name="client_counter" value="" type="text" required>
                            @if ($errors->has('client_counter'))
                                <span class="invalid-feedback d-block">
                                    <strong>{{ $errors->first('client_counter') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div> 
                </div>
                <br>
                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary btn-block btn-lg">{{ __('theme.update') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
