@extends('layouts.crm')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.6/flatpickr.min.css">
<link href="{{ asset('src/public/assets/css/okr/app.css') }}" rel="stylesheet">
<link href="{{ asset('src/public/assets/css/okr/base.css') }}" rel="stylesheet">
<link href="{{ asset('css/component.css') }}" rel="stylesheet">
<link href="https://unpkg.com/gijgo@1.9.11/css/gijgo.min.css" rel="stylesheet" type="text/css" />
<link href="{{ asset('src/public/assets/css/okr/ion.rangeSlider.css') }}" rel="stylesheet" />
<link href="{{ asset('src/public/assets/css/okr/bootstrap-notifications.min.css') }}" rel="stylesheet">

@section('script')

<script src="{{ asset('src/public/assets/js/okr/app.js') }}" defer></script>
<script src="{{ asset('src/public/assets/js/okr/tooltip.js') }}" defer></script>
<script src="{{ asset('src/public/assets/js/okr/circle-progress.min.js') }}" defer></script>
<script src="{{ asset('src/public/assets/js/okr/circleProgress.js') }}" defer></script>
<script src="{{ asset('src/public/assets/js/okr/editbtn.js') }}" defer></script>
{{-- Chartjs --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js" charset="utf-8"></script>
<script src="{{ asset('src/public/assets/js/okr/chart.js') }}" defer></script>
<script src="{{ asset('src/public/assets/js/okr/okr.js') }}" defer></script>



@endsection

<style>
.filters {
    position: relative;
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin-right:20px;
}
.filter-item {
    position: relative;
}

.dropdown-content {
    display: none;
    list-style-type: none; 
    padding: 10px;
    position: absolute;
    top: 100%;
    left: 0;
    background-color: white;
    min-width: 160px;
    box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
    z-index: 1;
}

.dropdown-content-date {
    display: none;
    padding: 10px;
    position: absolute;
    top: 100%;
    left: 0;
    background-color: white;
    min-width: 500px;
    z-index: 1;
    box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
}

/* Flexbox for the date-form */
.date-form {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 10px; /* Space between elements */
}

/* Spacing for inputs and select */
.date-form .form-control {
    flex: 1; /* Ensures inputs take up available space */
    min-width: 150px; /* Ensures a minimum width for input fields */
}

.date-form button {
    flex-shrink: 0; /* Prevent the button from shrinking */
}

.dropdown-content ul li {
        display: flex; 
        align-items: center; 
        margin-bottom: 5px; 
    }
.dropdown-content ul li input {
   margin: 5px; 
}
.dropdown-content ul li {
        display: flex; 
        align-items: center; 
        margin-bottom: 5px; 
    }
.dropdown-content ul li label {
   margin: 5px; 
}
.filter-btn {
    cursor: pointer;
    padding: 12px;
    border: none;
    background-color: white;
    color: grey;
    border-radius: 25px;
}
.filter-item.search-item {
    margin-left: auto;
    margin-right: 20px;
}

.form-group-with-search {
    position: relative;
    width: 100%;
}

.form-control-feedback {
    position: relative;
    left: 0px; /* Adjust as needed */
    top: 50%;
    transform: translateY(-50%);
    cursor: pointer;
    pointer-events: none; /* Prevents the icon from being clicked */
}

.form-control {
    width: 100%;
    padding-right: 30px; /* Space for the search icon */
    border-radius: 25px;
}

.search-field {
    padding: 10px;
    border-radius: 25px;
    border: 1px solid #ccc;
}


</style>
@section('title','Objective')
@section('contents')
<div class="row align-items-center justify-content-between" style="margin-left:70px; margin-right:70px; margin-top:20px; margin-bottom:40px">
    <h4 class="header-pill col-auto" style="font-family: 'Poppins', sans-serif;">Objectives and Key Results</h4>
    <div class="col-auto">
        <!-- Button trigger modal -->
        <div class="" style="top: 100px; right: 50px;">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#objective">
                Add Objective
            </button>
        </div>
        @can('storeObjective', $company)
        <a href="#" data-toggle="modal" data-target="#objective" class="newObjective"></a>
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
        @endcan
    </div>
</div>

<div class="container-fluid" style="margin-right:60px;">
    @include('crm.organization.company.show')
    <div class="tab-pane fade show pl-sm-4 pr-sm-4">
        <!-- Filters on the left -->
         
    <div class="filters d-flex" style="margin-left: 30px; margin-right: 55px;">
       

        <div class="filter-item">
            <button class="filter-btn" style="border-radius: 25px; padding:12px width:100px" id="datefilter">Date Range</button>
            <div id="dateDropdown" class="dropdown-content">
                <form id="dateRangeForm" class="filter-form">
                    @include('crm.actions.partials.dateTimeFilter')
                </form>
            </div>
        </div>


        <div class="filter-item search-item" style="margin-left:auto; margin-right:50px;">
            <div class="form-group form-group-with-search d-flex align-items-center relative">
            <span class="form-control-feedback">
                    <i>
                        <svg class="feather feather-search" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="11" cy="11" r="8"></circle>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                        </svg>
                    </i>
                </span>
                <input type="text" class="form-control input-sm search-field" id="filterSearch" placeholder="Search...">
            </div>
        </div>
    </div>
        @if ($company->okrs)
            @foreach($company->okrs as $okr)
                @include('crm.okrs.okr', ['okr' => $okr, 'owner' => $company])
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


        var AddActionUrl = "{{ route('actions.create', ['objective' => ':id']) }}";

        document.querySelectorAll('.add-action-btn').forEach(function (button) {
        button.addEventListener('click', function () {
        var objectiveId = this.getAttribute('data-id');
        var url = AddActionUrl.replace(':id', objectiveId);

        console.log(objectiveId);
        
        fetch( url , {
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        })
        .then(response => {
            console.log(response);
            if (!response.ok) {

                throw new Error(url +'Network response was not ok');
            }
            return response.json();
        })
        .then(data => {

            console.log('Fetched Data:', data); // Debugging line

            document.querySelector('#createActionForm').reset();
            document.querySelector('#priority').innerHTML = '';
            document.querySelector('#keyresult').innerHTML = '';
            document.querySelector('#manager').innerHTML = '';


            // Populate priorities
            let prioritySelect = document.querySelector('#priority');
            prioritySelect.innerHTML = '<option value="">Select Priority</option>';
            data.priorities.forEach(priority => {
                prioritySelect.innerHTML += `<option value="${priority.id}">${priority.priority}</option>`;
            });

            let managerSelect = document.querySelector('#manager');
                managerSelect.innerHTML = '<option value="">Select Manager</option>';
                data.users.forEach(manager => {
                    managerSelect.innerHTML += `<option value="${manager.id}">${manager.first_name} ${manager.last_name}</option>`;
                });

            // Populate keyresults
            if (data.keyresults) {
                data.keyresults.forEach(function(keyresult) {
                    document.querySelector('#keyresult').innerHTML += `<option value="${keyresult.id}">${keyresult.title}</option>`;
                });
            }

            // Populate action_on with static options
            // const actionOnOptions = ['Onboarding', 'Project', 'Proposal'];
            // actionOnOptions.forEach(function(option) {
            //     document.querySelector('#model_type').innerHTML += `<option value="${option}">${option.charAt(0).toUpperCase() + option.slice(1)}</option>`;
            // });

            $('#createActionModal').modal('show');
        })
        .catch(error => {
                console.error('Error fetching data:', error);
            });
        });
    });




        document.querySelector('#model_type').addEventListener('change', function() {
            let modelType = this.value;
            if (modelType) {
                fetch(`{{ url('actions/models') }}/${modelType}`, {
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
                    console.log("fetched data :", data)
                    let modelIdSelect = document.querySelector('#model_id');
                    let modelNameSpace = document.querySelector('#full_model_type');

                    modelIdSelect.innerHTML = '<option value="">Select Target Entity</option>';
                    data.models.forEach(entity => {
                        if (entity.name) {
                            modelIdSelect.innerHTML += `<option value="${entity.id}">${entity.name}</option>`;
                            modelNameSpace.value = entity.model;
                        } else if (entity.subject) {
                            modelIdSelect.innerHTML += `<option value="${entity.id}">${entity.subject}</option>`;
                            modelNameSpace.value = entity.model;
                        }
                    });

                    if (data.models.length > 0) {
                        modelNameSpace.value = data.models[0].model;
                    } else {
                        modelNameSpace.value = '';
                    }
                })
                .catch(error => {
                    console.error('Error fetching entities:', error);
                });
            } else {
                document.querySelector('#model_id').innerHTML = '<option value="">Select Target Entity</option>';
            }
        });


        document.getElementById("datefilter").addEventListener("click", function() { 
            event.stopPropagation();
            var dropdown = document.getElementById('dateDropdown');
            if (dropdown.style.display === "block") {
                dropdown.style.display = "none";
            } else {
                closeAllDropdowns();
                dropdown.style.display = "block";

                flatpickr("#startDate", {
                    dateFormat: "Y-m-d"
                });

                flatpickr("#endDate", {
                    dateFormat: "Y-m-d"
                });

                }
        });

      

        document.getElementById("applyDates").addEventListener("click", function() {
            var startDate = document.getElementById("startDate").value;
            var endDate = document.getElementById("endDate").value;

            
            console.log("Start Date:", startDate, "End Date:", endDate);

            if (!startDate && !endDate) {
                    console.log('No dates selected. No filter will be applied.');
                    return; // Exit if no dates are selected
                }

                var baseUrl = "{{ route('projects.get') }}";
                var url = `${baseUrl}`;

                if (startDate) {
                    url += `?startDate=${encodeURIComponent(startDate)}`;
                }

                if (endDate) {
                    url += startDate ? `&endDate=${encodeURIComponent(endDate)}` : `?endDate=${encodeURIComponent(endDate)}`;
                }
        });

        function updateButtonText(buttonId, text) {
            var button = document.getElementById(buttonId);
            button.innerText = text;
        }

      

       

        function closeAllDropdowns() {
            var dropdowns = document.getElementsByClassName("dropdown-content");
            for (var i = 0; i < dropdowns.length; i++) {
                dropdowns[i].style.display = "none";
            }
        }

        window.onclick = function(event) {
            if (!event.target.matches('.filter-btn') && !event.target.closest('.dropdown-content')) {
                closeAllDropdowns();
            }
        }
    });
</script>