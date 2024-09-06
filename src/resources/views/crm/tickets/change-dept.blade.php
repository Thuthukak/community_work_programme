<p>{{ __('theme.ticket') }}: # {{ $data->ticket_id }} - {{ $data->title }}</p>
<p>{{ __('theme.current_department') }}: {{ $data->department->title }}</p>

<div class="form-group">
    <label for="Name">{{ __('theme.departments') }}:</label>
    <select class="form-control" name="department" id="assignedDepartment">
        <option disabled selected>{{ __('theme.select_department') }}</option>
        @foreach($departments as $department)
            <option value="{{ $department->id }}">{{ $department->title }}</option>
        @endforeach
    </select>
</div>