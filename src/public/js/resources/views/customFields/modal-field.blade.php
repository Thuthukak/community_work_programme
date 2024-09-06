<div class="form-group">
    <label for="title">{{ __('theme.name') }}:</label>
    <input type="text" class="form-control" id="title" name="title" value="{{ $field->name }}">
</div>
<div class="form-group">
    <label for="type">{{ __('theme.type') }}:</label>
    <select class="form-control" name="type" id="type">
        <option value="text" {{ $field->type == 'text' ? 'selected': ''}}>text</option>
        <option value="select" {{ $field->type == 'select' ? 'selected': ''}}>select</option>
        <option value="radio" {{ $field->type == 'radio' ? 'selected': ''}}>radio</option>
        <option value="checkbox" {{ $field->type == 'checkbox' ? 'selected': ''}}>checkbox</option>
        <option value="file" {{ $field->type == 'file' ? 'selected': ''}}>file</option>
    </select>
</div>
<div class="form-row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="placeholder"><strong>{{ __('theme.placeholder') }}</strong> </label>
            <input type="text" class="form-control has-error bold" id="placeholder" name="placeholder" value="{{$field->placeholder}}" placeholder="Enter placeholder">
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="field_length"><strong>{{ __('theme.field_length') }}</strong> </label>
            <input type="number" class="form-control has-error bold" min="1" id="field_length" name="field_length" value="{{$field->field_length}}" placeholder="Enter field length">
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="title">{{ __('theme.required') }}</label><br>
            <div class="form-check-inline">
                <label class="customradio"><span class="radiotextsty">{{ __('theme.yes') }}</span>
                <input type="radio" name="required" value="1" {{ $field->required == 1 ? 'checked' : '' }}>
                <span class="checkmark"></span>
                </label>        
                <label class="customradio"><span class="radiotextsty">{{ __('theme.no') }}</span>
                <input type="radio" name="required" value="0" {{ $field->required == 0 ? 'checked' : '' }}>
                <span class="checkmark"></span>
                </label>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="title">{{ __('theme.status') }}</label><br>
            <div class="form-check-inline">
                <label class="customradio"><span class="radiotextsty">{{ __('theme.active') }}</span>
                <input type="radio" name="status" value="1" {{ $field->status == 1 ? 'checked' : '' }}>
                <span class="checkmark"></span>
                </label>        
                <label class="customradio"><span class="radiotextsty">{{ __('theme.inactive') }}</span>
                <input type="radio" name="status" value="0" {{ $field->status == 0 ? 'checked' : '' }}>
                <span class="checkmark"></span>
                </label>
            </div>
        </div>
    </div>
</div>