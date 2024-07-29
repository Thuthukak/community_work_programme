@extends('layouts.crm')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.6/flatpickr.min.css">

@section('title','Objective')
@section('contents')
<div class="container">

<ul class="nav justify-content-flex-start" style="margin-left: -100px; margin-top: 25px; color: #374151 !important;font-family: 'Poppins', sans-serif !important; font-weight: 500 !important; font-size: 1rem !important;" id="myTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link project-title page-header-pill text-xl  font-semibold" id="okr-tab" data-toggle="tab"  role="tab" aria-controls="okr"
                aria-selected="false">Actions</a>
        </li>
    </ul>
    <br>
    <br>
    <div class="tab-pane fade show pl-sm-4 mt-4 pr-sm-4">
        <div class="row m-3 pt-4 justify-content-center">
            <div class="col-auto mb-2">
            <form action="" class="form-inline search-form">
                <input autocomplete="off" class="form-control input-sm" name="st_date" id="filter_started_at" value=""
                    placeholder="Start date">
                <input autocomplete="off" class="form-control input-sm ml-md-2" name="fin_date" id="filter_finished_at"
                    value="" placeholder="Settlement date">
                <select name="order" class="form-control input-sm mr-md-2 ml-md-2">
                    <option value="">Sort by</option>
                    <option value="started_at_asc">Start date, earliest to latest</option>
                    <option value="started_at_desc">Start date, latest to earliest</option>
                    <option value="finished_at_asc">Finish date, earliest to latest</option>
                    <option value="finished_at_desc">Finish date, latest to earliest</option>
                    <option value="updated_at_asc">Recently updated, earliest to latest</option>
                    <option value="updated_at_desc">Recently updated, latest to earliest</option>
                </select>
                <button class="btn btn-info">Filter</button>
            </form>
            </div>
        </div>
        @if ($actions)
            @foreach($actions as $action)
                @include('crm.actions.actions', ['actions' => $actions])
            @endforeach
        @else
            <div id="dragCard" class="row justify-content-md-center u-mt-16">
                <div class="alert alert-warning alert-dismissible fade show u-mt-32" role="alert">
                    <strong><i class="fas fa-exclamation-circle pl-2 pr-2"></i></strong>
                    No Actions have been established for the Company !!
                </div>
            </div>
        @endif
    </div>
  <!-- Button trigger modal -->
  <div class="position-fixed" style="top: 100px; right: 100px;">
  <button class="btn btn-warning btn-sm p-2 fa  fa-sm w-100 add-action-btn" style="font-family: 'Poppins', sans-serif "  data-toggle="modal" data-target="#createActionModal"> Add 
 {{ trans('Action') }}
     </button>               
                 <img src="{{ asset('img/icon/add/lightgreen.svg') }}" alt="">
            </button>
        </div>
    @can('storeObjective', $actions)
        <a href="#" data-toggle="modal" data-target="#objective" class="newObjective"><img src="{{ asset('img/icon/add/lightgreen.svg') }}" alt=""></a>
        
        <!-- Modal -->
        <div id="createActionModal" class="modal fade" role="dialog">
            <div class="modal-dialog modal-xl modal-dialog-scrollable" style="max-height: 100%;">
                <!-- Modal content-->
                <div class="modal-content" style="max-height: calc(100vh - 210px); overflow-y: auto;">
                    <div class="modal-header">
                        <h4 class="modal-title">{{ __('Add Action') }}</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="POST" action="{{ route('actions.storeloneaction') }}" enctype="multipart/form-data" class="p-4" id="createActionForm">
                    @csrf
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

                        <input type="hidden" name="full_model_type" id="full_model_type">

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
                            <button class="btn btn-primary" type="submit">Add</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('app.cancel') }}</button>
                        </div>
                    </div>

                </form>
                </div>
            </div>
        </div>
        </div>
    @endcan
</div>
@endsection
@section('script')
<!-- Include Flatpickr JS from cdnjs -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.6/flatpickr.min.js"></script>

<!-- Your script to initialize Flatpickr -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize Flatpickr on the date input fields
        flatpickr("#filter_started_at, #filter_finished_at, #st_date, #fin_date ,#started_at , #finished_at", {
            dateFormat: "Y-m-d",
            disableMobile: true // optional: to force the desktop version on mobile devices
        });


        document.querySelector('.add-action-btn').addEventListener('click', function() {
        var url = `{{ route('actions.get') }}`;

        console.log(url)
        
        fetch(url, {
            method: 'GET',
            headers: {
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
            // Populate objectives
            let objectiveSelect = document.querySelector('#objective');
            objectiveSelect.innerHTML = '<option value="">Select Objective</option>';
            data.objectives.forEach(obj => {
                objectiveSelect.innerHTML += `<option value="${obj.id}">${obj.title}</option>`;
            });

            // Populate priorities
            let prioritySelect = document.querySelector('#priority');
            prioritySelect.innerHTML = '<option value="">Select Priority</option>';
            data.priorities.forEach(priority => {
                prioritySelect.innerHTML += `<option value="${priority.id}">${priority.priority}</option>`;
            });

            // Show the modal
            $('#createActionModal').modal('show');
        })
        .catch(error => {
            console.error('Error fetching data:', error);
        });
    });

    // Handle Objective Selection
    document.querySelector('#objective').addEventListener('change', function() {
    let objectiveId = this.value;

    if (objectiveId) {
        fetch(`{{ url('actions/keyresults') }}/${objectiveId}`, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            console.log('Parsed JSON data:', data);

            let keyResultSelect = document.querySelector('#keyresult');
            keyResultSelect.innerHTML = '<option value="">Select Key Result</option>';
            data.forEach(kr => {
                keyResultSelect.innerHTML += `<option value="${kr.id}">${kr.title}</option>`;
            });
        })
        .catch(error => console.error('Error fetching key results:', error));
    }
});
            // Handle Action On Selection
            document.querySelector('#model_type').addEventListener('change', function() {
            let actionOn = this.value;


            fetch(`{{ url('actions/models') }}/${actionOn}`, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json'
                }
            })
            .then(response => {
                console.log('Response Status:', response.status); // Debugging line
                return response.json();
            })
            .then(data => {
                console.log('Fetched Data:', data); // Debugging line
                let modelSelect = document.querySelector('#model_id');

                if (modelSelect) {
                modelSelect.innerHTML = '<option value="">Select Target</option>';
                data.models.forEach(model => {
                    if (typeof model === 'object') {
                        modelSelect.innerHTML += `<option value="${model.id}">${model.name}</option>`;
                    }
                });

                let lastModel = data.models.filter(model => typeof model === 'object').pop();
                if (lastModel) {
                    document.querySelector('#full_model_type').value = lastModel.model;
                    console.log(document.querySelector('#full_model_type').value);
                } else {
                    console.error('No valid model object found');
                }
            } else {
                console.error('Element with id "model" not found');
            }



            })
            .catch(error => {
                console.error('Error fetching models:', error);
            });

        });

    });
</script>



