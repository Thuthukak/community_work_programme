@extends('layouts.crm')
@section('title','Action')
@section('contents')

<div class="container">
    <div class="row mb-2">
        <div class="col">
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-10 col-12">
            {{-- edit --}}
            @can('update', $action)
            <div class="row justify-content-end">
                <div class="col-auto">
                    <a class="text-info" href="#" onclick="document.getElementById('doneAct{{ $action->id }}').submit()"><i class="fas fa-check-circle"></i> {{ $action->isdone?'Cancel':'Finish' }}</a>
                    <form method="POST" id="doneAct{{ $action->id }}" action="{{ route('actions.done',$action->id) }}">
                        @csrf
                    </form>
                </div>
                <div class="col-auto">
                <button class="btn text-info fas fa-edit p-2  fa-sm w-100 edit-action-btn" data-id="{{  $action->id }}" data-toggle="modal" data-target="#EditActionModal">
                    {{ trans('Edit') }}
                </button>
                </div>
                <div class="col-auto">
                    <a href="#" data-toggle="dropdown" class="text-info"><i class="fas fa-trash-alt"></i> delete</a>
                    <form method="POST" id="deleteAct{{ $action->id }}" action="{{ route('actions.destroy', $action->id) }}">
                        @csrf
                        {{ method_field('DELETE') }}
                        <div class="dropdown-menu u-padding-16">
                            <div class="row justify-content-center mb-2">
                                <div class="col-auto text-danger"><i class="fas fa-exclamation-triangle"></i></div>
                            </div>
                            <div class="row">
                                <div class="col text-center">
                                    Are you sure you want to take Action?<br>
                                </div>
                            </div>
                            <div class="row justify-content-center mt-3">
                                <div class="col text-center pr-0"><button class="btn btn-danger" type="submit">delete</button></div>
                                <div class="col text-center pl-0"><a class="btn btn-secondary text-white">Cancel</a></div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            @endcan
            {{-- kr --}}
            <div class="row">
                <div class="col-auto font-weight-bold text-muted align-self-center">
                    <div class="badge badge-pill pl-4 pr-4 text-white mr-2"  style="line-height: 18px; background-color:{{ $action->keyresult->color() }};">KR</div>
                    {{ $action->keyresult->title }}
                </div>
            </div>
            {{-- Action title --}}
            <div class="row mt-4 mb-4">
                <div class="col-auto">
                    <h4>{{ $action->title }}</h4>
                </div>
                <div class="col-auto text-right text-muted align-self-center">{{ $action->updated_at }}renew</div>
            </div>
            <div class="row mt-4 mb-4">
                <div class="col-auto align-self-center text-muted pr-md-4" style="line-height: 24px;">
                deadline｜
                    <i class="far fa-clock pr-2"></i>
                    {{ date('M. d, Y', strtotime($action->finished_at)) }}
                </div>
                <div class="col-auto align-self-center text-muted pl-md-4 pr-md-4" style="line-height: 24px;">
                person in charge｜
                    <a href="{{ route('user.okr', $action->user->id) }}" title="{{ $action->user->name }}">
                        <img src="{{ $action->user->getAvatar() }}" class="avatar-xs mr-1">
                        <span>{{ $action->user->name }}</span>
                    </a>
                </div>
                <div class="col-auto text-center align-self-center text-muted pl-md-4" style="line-height: 24px;">
                    priority｜
                    <div class="badge badge-pill badge-{{ $action->priority()->getResults()->color }} pl-4 pr-4">{{ $action->priority()->getResults()->priority }}</div>
                </div>
            </div>
            <hr/>
            <div class="row pl-md-4 pr-md-4">
                <div class="col-12">
                    <div>
                        <pre style="line-height: 28px;">{{$action->content}}</pre>
                    </div>
                </div>
            </div>
            @if(!empty($files))
            <div class="row justify-content-center pt-4 pb-4">
                <div class="col">
                    <i class="fas fa-paperclip text-muted pr-2"></i>
                    <label class="text-muted">appendix</label>
                    @foreach($files as $file)
                        <div class="row ml-3 mt-2">
                            <div class="col-auto">{{ $file['updated_at'] }}</div>
                            <div class="col-auto"><a href="{{ $file['url'] }}">{{ $file['name'] }}</a></div>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif
            <hr>
            <div class="row">
                <div class="col">
                    @comments(['model' => $action])
                    @endcomments
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div id="EditActionModal" class="modal fade" role="dialog">
            <div class="modal-dialog modal-xl modal-dialog-scrollable" style="max-height: 100%;">
                <!-- Modal content-->
                <div class="modal-content" style="max-height: calc(100vh - 210px); overflow-y: auto;">
                    <div class="modal-header">
                        <h4 class="modal-title">{{ __('Add Action') }}</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="POST" action="{{ route('actions.updateloneaction' , $action->id) }}" enctype="multipart/form-data" class="p-4" id="createActionForm">
                    @csrf
                    @method('PATCH')


                    <input type="hidden" name="action_id" id="action_id">

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="action_title">Action</label>
                            <input type="text" class="form-control" name="act_title" id="action_title" required>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="priority">Priority</label>
                            <select id="priority" class="form-control" name="priority" required>
                                <option value="">Select Priority</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="started_at">Starting day</label>
                            <input autocomplete="off" class="form-control" name="st_date" id="started_at" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="finished_at">Completion date</label>
                            <input autocomplete="off" class="form-control" name="fin_date" id="finished_at" required>
                        </div>
                    </div>

                    <div class="form-row">

                    <div class="form-group col-md-6">
                            <label for="Objective">Objective</label>
                            <select class="form-control" name="objective_id" id="objective" required>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="keyresult">Associated KR</label>
                            <select class="form-control" name="krs_id" id="keyresult" required>
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="model_type">Action On</label>
                            <select id="model_type" class="form-control" name="model_type" required>
                                <option value="">Select Action On</option>
                                <option value="Onboarding">Onboarding</option>
                                <option value="Project">Project</option>
                                <option value="Proposal">Proposal</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="model_id">Target Entity</label>
                            <select id="model_id" class="form-control" name="model_id" required>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="action_content">Content</label>
                            <textarea class="form-control" id="action_content" rows="7" name="act_content" style="resize: none;" required></textarea>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="files">Upload Attachment</label>
                            <input type="file" class="form-control-file" name="files[]" id="files" multiple>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12 text-right">
                            <button class="btn btn-primary" type="submit">Save</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('app.cancel') }}</button>
                        </div>
                    </div>

                </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')

<script src="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.6/flatpickr.min.js"></script>

<!-- Your script to initialize Flatpickr -->
<script>


document.addEventListener('DOMContentLoaded', function () {
        // Initialize Flatpickr on the date input fields


        flatpickr(" #st_date, #fin_date ,#started_at , #finished_at", {
            dateFormat: "Y-m-d",
            disableMobile: false // optional: to force the desktop version on mobile devices
        });


        var editActionUrl = "{{ route('actions.edit', ['action' => ':id']) }}";

    document.querySelectorAll('.edit-action-btn').forEach(function (button) {
    button.addEventListener('click', function () {
        var actionId = this.getAttribute('data-id');
        var url = editActionUrl.replace(':id', actionId);

        console.log(url);

        // var token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        fetch(url, {
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
    console.log('Fetched Data:', data); // Debugging line

    // Find the action object with the matching ID
    const action = data.actions.find(action => action.id == actionId);

    if (action) {
        // Populate the form fields with the action data
        document.getElementById('action_id').value = action.id;
        document.getElementById('action_title').value = action.title;
        document.getElementById('started_at').value = action.started_at;
        document.getElementById('finished_at').value = action.finished_at;
        document.getElementById('action_content').value = action.content;

        // Populate priorities
        var prioritySelect = document.getElementById('priority');
        prioritySelect.innerHTML = '<option value=""></option>';
        data.priorities.forEach(function (priority) {
            var option = document.createElement('option');
            option.value = priority.id;
            option.textContent = priority.priority;
            prioritySelect.appendChild(option);
        });
        prioritySelect.value = action.priority;

        // Populate objectives
        var objectiveSelect = document.getElementById('objective');
        objectiveSelect.innerHTML = '<option value=""></option>';
        data.objective.forEach(function (objective) {
            var option = document.createElement('option');
            option.value = objective.id;
            option.textContent = objective.title;
            objectiveSelect.appendChild(option);
        });
        objectiveSelect.value = action.keyresult.objective_id;

        // Populate key results
        var keyresultSelect = document.getElementById('keyresult');
        keyresultSelect.innerHTML = '<option value=""></option>';
        data.keyresults.forEach(function (keyresult) {
            var option = document.createElement('option');
            option.value = keyresult.id;
            option.textContent = keyresult.title;
            keyresultSelect.appendChild(option);
        });
        keyresultSelect.value = action.keyresult.id;

        // Clear and set the existing model type value
        var modelTypeSelect = document.getElementById('model_type');
        modelTypeSelect.innerHTML = '<option value=""></option>';

        // Extract the last segment of the model_type
        var modelTypeLastSegment = action.model_type.split('\\').pop();
        var option = document.createElement('option');
        option.value = action.model_type;
        option.textContent = modelTypeLastSegment;
        option.selected = true;
        modelTypeSelect.appendChild(option);

        // Populate model IDs (example using model_id_object data)
        var modelIdSelect = document.getElementById('model_id');
        modelIdSelect.innerHTML = '<option value=""></option>';
        action.model_id_object.forEach(function (modelObject) {
            var option = document.createElement('option');
            option.value = modelObject.id;
            option.textContent = modelObject.name;
            modelIdSelect.appendChild(option);
        });
        modelIdSelect.value = action.model_id;
    } else {
        console.error('Action not found');
    }
}).catch(error => console.error('Error:', error));
    });
});

});


</script>