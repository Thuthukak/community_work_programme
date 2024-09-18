<form id="customerform" role="form" method="POST" action="{{ route('new-ticket-store.store') }}" enctype="multipart/form-data">
    {!! csrf_field() !!}
    <div class="card-body">
        <div class="text-center">                
            <i class="fa fa-question fa-2x"></i>
            <h2 class="card-title">{{ __('theme.whats_happening_write_us') }}</h2>
        </div>
        <div class="row">
            <div class="form-group col-md-8 {{ $errors->has('title') ? ' has-error' : '' }}">
                <label for="department">Title</label>
                <input id="title" type="text" class="form-control" name="title" value="{{ old('title') }}" placeholder="{{ __('theme.enter_problem_title') }}" required>
                @if ($errors->has('title'))
                    <span class="text-danger">
                        {{ $errors->first('title') }}
                    </span>
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
                    <span class="text-danger">
                        {{ $errors->first('priority') }}
                    </span>
                @endif
            </div>

            <div class="form-group col-md-12">
                <label for="message">{{ __('theme.message') }}</label>
                <textarea rows="6" id="message" class="form-control my-editor {{ $errors->has('message') ? ' has-error' : '' }}" name="message">{{ old('message') }}</textarea>
                @if ($errors->has('message'))
                    <span class="text-danger">
                        {{ $errors->first('message') }}
                    </span>
                @endif
            </div>
        </div>
        
    </div>
</form>


