@extends('layouts.crm')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.6/flatpickr.min.css">

@section('title','Objective')
@section('contents')
<div class="container">
    @include('crm.organization.company.show')
    <ul class="nav nav-tabs justify-content-flex-start" style="margin-left: -100px" id="myTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="okr-tab" data-toggle="tab" href="#okr" role="tab" aria-controls="okr"
                aria-selected="false">OKRs</a>
        </li>
    </ul>
    <div class="tab-pane fade show pl-sm-4 pr-sm-4">
        <div class="row m-3 pt-4 justify-content-center">
            <div class="col-auto mb-2">
            <form action="{{ $company->getOKrRoute() }}" class="form-inline search-form">
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
        @if ($company->okrs)
            @foreach($company->okrs as $okr)
                @include('crm.okrs.okr', ['okr' => $okr, 'owner'=>$company])
            @endforeach
        @else
            <div id="dragCard" class="row justify-content-md-center u-mt-16">
                <div class="alert alert-warning alert-dismissible fade show u-mt-32" role="alert">
                    <strong><i class="fas fa-exclamation-circle pl-2 pr-2"></i></strong>
                    No OKRs have been established for the current period !!
                </div>
            </div>
        @endif
    </div>
  <!-- Button trigger modal -->
  <div class="position-fixed" style="top: 100px; right: 20px;">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#objective">
                <img src="{{ asset('img/icon/add/lightgreen.svg') }}" alt="Add Objective">
            </button>
        </div>
    @can('storeObjective', $company)
        <a href="#" data-toggle="modal" data-target="#objective" class="newObjective"><img src="{{ asset('img/icon/add/lightgreen.svg') }}" alt=""></a>
        <div class="modal {{ count($errors) == 0 ? 'fade' : '' }}" id="objective" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">
                            <span>&times;</span>
                        </button>
                    </div>
                    @include('crm.okrs.create', ['route'=>route('company.objective.store', $company->id)])
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

        document.querySelectorAll('.add-action-btn').forEach(function(button) {
        button.addEventListener('click', function() {
        var objectiveId = this.getAttribute('data-id');
        var url = `{{ url('objective') }}/${objectiveId}/action/create`;

        console.log(objectiveId);
        console.log(url);

        // AJAX request to fetch data
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
            console.log('Fetched Data:', data); // Debugging line

            document.querySelector('#createActionForm').reset();
            document.querySelector('#priority').innerHTML = '';
            document.querySelector('#keyresult').innerHTML = '';
            document.querySelector('#action_on').innerHTML = '';

            // Populate priorities
            let prioritySelect = document.querySelector('#priority');
            prioritySelect.innerHTML = '<option value="">Select Priority</option>';
            data.priorities.forEach(priority => {
                prioritySelect.innerHTML += `<option value="${priority.id}">${priority.priority}</option>`;
            });

            // Populate keyresults
            if (data.keyresults) {
                data.keyresults.forEach(function(keyresult) {
                    document.querySelector('#keyresult').innerHTML += `<option value="${keyresult.id}">${keyresult.title}</option>`;
                });
            }

            // Populate action_on with static options
            const actionOnOptions = ['projects', 'pipeline', 'proposals'];
            actionOnOptions.forEach(function(option) {
                document.querySelector('#action_on').innerHTML += `<option value="${option}">${option.charAt(0).toUpperCase() + option.slice(1)}</option>`;
            });

            flatpickr("#started_at", {
                defaultDate: data.default_start_date || new Date()
            });
            flatpickr("#finished_at", {
                defaultDate: data.default_end_date || new Date()
            });

            $('#createActionModal').modal('show');
        })
        .catch(error => {
            console.error('Error fetching data:', error);
        });
    });
});




document.querySelector('#createActionForm').addEventListener('submit', function(event) {
    let isValid = true;

    // Check if each required field is filled
    document.querySelectorAll('input[required], select[required], textarea[required]').forEach(function(field) {
        if (!field.value) {
            isValid = false;
            field.classList.add('is-invalid');
        } else {
            field.classList.remove('is-invalid');
        }
    });

    // Prevent form submission if not valid
    if (!isValid) {
        event.preventDefault();
        alert('Please fill out all required fields.');
    }
});


document.querySelector('#action_on').addEventListener('change', function() {
    var actionOn = this.value;
    
    // Make sure actionOn is not empty
    if (actionOn) {
        fetchModels(actionOn);
    }
});

function fetchModels(actionOn) {

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
        // Update the model dropdown
        var modelDropdown = document.querySelector('#model');
        modelDropdown.innerHTML = ''; // Clear existing options

        data.models.forEach(function(model) {
            var option = document.createElement('option');
            option.value = model.id;
            option.textContent = model.name;
            modelDropdown.appendChild(option);
        });
    })
    .catch(error => {
        console.error('Error fetching models:', error);
    });
}

});
</script>



