@extends('layouts.crm')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.6/flatpickr.min.css">

@section('title','Objective')
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
@section('contents')
<div class="container-fluid" style="margin-top: 40px;">
    <div class="row align-items-center justify-content-between mb-4" style="margin-left: 10px;">
        <h4 class="header-pill col-auto">Actions List</h4>
        <div class="col-auto text-right" style="margin-right: 40px;">
            <!-- Button trigger modal -->
            <button class="btn btn-primary add-action-btn btn-with-shadow" id = "add-action-btn" style="font-family: 'Poppins', sans-serif " data-toggle="modal" data-target="#createActionModal">
                {{ trans('Add Action') }}
            </button>
        </div>
    </div>

    <!-- Filters -->

    <!-- Filters on the left -->
    <div class="filters d-flex" style="margin-left: 30px;">
        <div class="filter-item">
            <button class="filter-btn" style="border-radius: 25px; padding:12px" id="datefilter">Date Range</button>
            <div id="dateDropdown" class="dropdown-content dropdown-content-date" >
                <form id="dateRangeForm" class="filter-form" style="width:auto">
                    @include('crm.actions.partials.dateTimeFilter')
                </form>
            </div>
        </div>

        <div class="filter-item">
            <button class="filter-btn" id="UsersLists" style="border-radius: 25px; padding:12px">Assigned To</button>
            <div id="usersDropdown" class="dropdown-content" style="display:none;">
                <form id="usersForm" class="filter-form">
                    <ul id="usersListContainer"></ul>
                    <br>
                    <hr>
                    <div class="d-flex justify-content-between mt-3">
                        <button type="button" id="clearUsers" class="btn btn-clear">Clear</button>
                        <button type="button" id="applyUsers" class="btn btn-primary">Apply</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="filter-item">
            <button class="btn filter-btn" type="button" id="isdone"  style="background-color: white; color: grey;    padding:12px ; border-radius: 25px;" aria-haspopup="true" aria-expanded="false">
               Is Done<i  id="dropdownArrow"></i>
            </button>
            <div id="isdoneDropdown" class="dropdown-content">
            </div>
        </div>
        <div class="filter-item">
            <button class="filter-btn" id="priority" style="border-radius: 25px; padding:12px">Priority</button>
            <div id="priorityDropdown" class="dropdown-content" style="display: none;">
            <form id="prioritiesForm" class="filter-form">
                    <ul id="prioritiesListContainer"></ul>
                    <br>
                    <hr>
                    <div class="d-flex justify-content-between mt-3">
                        <button type="button" id="clearpriorities" class="btn btn-clear">Clear</button>
                        <button type="button" id="applyPriorities" class="btn btn-primary">Apply</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="filter-item">
            <button class="filter-btn" id="it-has" style="border-radius: 25px; padding:12px">Actions On</button>
            <div id="classDropdown" class="dropdown-content" style="display: none;">
                <form id="clausesForm" class="filter-form">
                    <label><input type="checkbox" name="Proposal">Proposal</label>
                    <label><input type="checkbox" name="Pipeline">Pipeline</label>
                    <label><input type="checkbox" name="Objectives">Objectives</label>
                    <label><input type="checkbox" name="Objectives">Project</label>
                    <button type="button" id="clearClauses" class="btn btn-clear">Clear</button>
                    <button type="button" id="applyClauses" class="btn btn-primary">Apply</button>
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

    <!-- actions -->
    <div class="row">
        <div class="col-12" style="padding-left: 20px; padding-right: 20px;">
            <div class="tab-pane fade show pl-sm-4 mt-4 pr-sm-4">
                @if ($actions)
                        @include('crm.actions.actions', ['actions' => $actions])
                @else
                    <div id="dragCard" class="row justify-content-md-center u-mt-16">
                        <div class="alert alert-warning alert-dismissible fade show u-mt-32" role="alert">
                            <strong><i class="fas fa-exclamation-circle pl-2 pr-2"></i></strong>
                            No Actions have been established for the Company !!
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div id="createActionModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-xl modal-dialog-scrollable" style="max-height: 100%;">
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

                </div>
                <div class="form-row">
                <div class="form-group col-md-6">
                        <label for="manager">Accountable Manager</label>
                        <select id="manager" class="form-control" name="manager" required>
                            <option value="">Select Manager</option>
                        </select>
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
@endsection

@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.6/flatpickr.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        flatpickr("#filter_started_at, #filter_finished_at, #st_date, #fin_date ,#started_at , #finished_at", {
            dateFormat: "Y-m-d",
            disableMobile: true
        });

        document.querySelector('.add-action-btn').addEventListener('click', function() {
            var url = `{{ route('actions.get') }}`;
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

                console.log("fetched data :", data)
                let objectiveSelect = document.querySelector('#objective');
                objectiveSelect.innerHTML = '<option value="">Select Objective</option>';
                data.objectives.forEach(obj => {
                    objectiveSelect.innerHTML += `<option value="${obj.id}">${obj.title}</option>`;
                });

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

                $('#createActionModal').modal('show');
            })
            .catch(error => {
                console.error('Error fetching data:', error);
            });
        });

        document.querySelector('#objective').addEventListener('change', function() {
            let objectiveId = this.value;
            if (objectiveId) {
                fetch(`{{ url('actions/keyresults') }}/${objectiveId}`, {
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

                    let keyresultSelect = document.querySelector('#keyresult');
                    keyresultSelect.innerHTML = '<option value="">Select Key Result</option>';
                    data.forEach(kr => {
                        keyresultSelect.innerHTML += `<option value="${kr.id}">${kr.title}</option>`;
                    });
                })
                .catch(error => {
                    console.error('Error fetching key results:', error);
                });
            } else {
                document.querySelector('#keyresult').innerHTML = '<option value="">Select Key Result</option>';
            }
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



        document.getElementById("isdone").addEventListener("click", toggleDropdown);

            function toggleDropdown() {
                var dropdown = document.getElementById('isdoneDropdown');
                if (dropdown.style.display === "block") {
                    dropdown.style.display = "none";
                } else {
                    closeAllDropdowns();
                    dropdown.style.display = "block";



                }
            }
            document.getElementById("datefilter").addEventListener("click", function() { 
                event.stopPropagation();
                var dropdown = document.getElementById('dateDropdown');
                if (dropdown.style.display === "block") {
                    dropdown.style.display = "none";
                } else {
                    closeAllDropdowns();
                    dropdown.style.display = "block";
                    }
            });



            document.getElementById("applyDates").addEventListener("click", function() {

                event.preventDefault();

                let startDate = document.getElementById("filter_started_at").value;
                let finishedDate = document.getElementById("filter_finished_at").value;
                const sortBy = document.getElementById("sort_by").value;

                startDate = startDate.replace(/\//g, '-');
                finishedDate = finishedDate.replace(/\//g, '-');

                console.log('startDate:', startDate);
                console.log('finished date:', finishedDate);
                console.log('sortby:', sortBy);

                const baseUrl = "{{ route('actions.filter') }}";
                let url = `${baseUrl}`;
                

                const params = new URLSearchParams();
                
                if (startDate) {
                    params.append('startDate', encodeURIComponent(startDate));
                }
                if (finishedDate) {
                    params.append('finishedDate', encodeURIComponent(finishedDate));
                }
                if (sortBy) {
                    params.append('sortBy', encodeURIComponent(sortBy));
                }

                if (params.toString()) {
                    url += `?${params.toString()}`;
                }

                console.log(url);

                fetch(url, {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                        
                        console.log(data);
                       const actions = data.actions.data;
                          // Clear the existing table rows
                         const tableBody = document.querySelector('table tbody');
                        tableBody.innerHTML = '';
                        // Check if there are any actions returned
                        if (actions.length === 0) {
                            const noResultsRow = `<tr><td colspan="8" class="text-center">{{ trans('No Actions Found') }}</td></tr>`;
                            tableBody.innerHTML = noResultsRow;
                        } else {

                        let actionsTableBody = document.querySelector('#actions-table tbody');
                        actionsTableBody.innerHTML = ''; // Clear existing data

                        data.actions.data.forEach(action => {
                            let row = `
                                <tr style="border-bottom: 1px solid var(--default-border-color);">
                                    <td class="datatable-td">${action.started_at}</td>
                                    <td class="datatable-td">
                                        <span class="badge rounded-pill bg-${action.priority_color} fixed-pill">
                                            ${action.priority_label}
                                        </span>
                                    </td>
                                    <td class="datatable-td"> 
                                      <a href="${action.show_action_url}">${action.title}</a>
                                      </td>
                                    <td class="datatable-td">${action.content}</td>
                                    <td class="datatable-td">${action.KeyResult}</td>
                                    <td class="datatable-td">${action.model_type}</td>
                                    <td class="datatable-td">${action.finished_at}</td>
                                    <td class="datatable-td">${action.user_name}</td>
                                </tr>
                            `;
                            actionsTableBody.insertAdjacentHTML('beforeend', row);
                        });
                    }
                })
                .catch(error => {
                    console.error('Fetch error:', error);
                });
            });

                  

         
          
            function updateButtonText(buttonId, text) {
                var button = document.getElementById(buttonId);
                button.innerText = text;
            }

            document.getElementById("UsersLists").addEventListener("click", function() {
                event.stopPropagation();
                var dropdown = document.getElementById('usersDropdown');
                if (dropdown.style.display === "block") {
                    dropdown.style.display = "none";
                } else {
                    closeAllDropdowns();
                    dropdown.style.display = "block";

                    var url = `{{ route('users.get') }}`;

                    console.log(url);

                    fetch(url, {
                        method: 'GET',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log('Fetched data:', data);

                        const UsersListContainer = document.getElementById('usersListContainer');
                        UsersListContainer.innerHTML = '';                  
                        const hr = document.createElement('hr');

                        // Iterate over each user object in the array
                        data.forEach(user => {
                            const listItem = document.createElement('li');

                            const checkbox = document.createElement('input');
                            checkbox.type = 'checkbox';
                            checkbox.id = `user-${user.id}`;
                            checkbox.value = user.id;
                            checkbox.classList.add('user-checkbox');

                            const label = document.createElement('label');
                            label.htmlFor = `user-${user.id}`;
                            label.textContent = user.full_name;

                            listItem.appendChild(checkbox);
                            listItem.appendChild(label);
                            listItem.classList.add('user-item');
                            
                            UsersListContainer.appendChild(listItem);
                        });

                        UsersListContainer.appendChild(hr);
                    })
                    .catch(error => {
                        console.error('Error fetching users data:', error);
                    });

                }
            });

            document.getElementById("clearUsers").addEventListener("click", function() {
                const checkboxes = document.querySelectorAll('.user-checkbox');
                checkboxes.forEach(checkbox => {
                    checkbox.checked = false;
                });
            });

            document.getElementById("applyUsers").addEventListener("click", function() {
                const selectedUsersIds = [];
                const checkboxes = document.querySelectorAll('.user-checkbox:checked');
                
                checkboxes.forEach(checkbox => {
                    selectedUsersIds.push(checkbox.value);
                });

                if (selectedUsersIds.length > 0) {
                    console.log('Selected Users IDs:', selectedUsersIds);

                    // Create a comma-separated string of IDs
                    const idsString = selectedUsersIds.join(',');

                    // Build the URL manually
                    var baseUrl = "{{ route('actions.filter') }}";  // Get the base URL
                    var url = `${baseUrl}?user=${encodeURIComponent(idsString)}`;

                    // console.log(url);
                    fetch(url, {
                        method: 'GET',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {


                        const actions = data.actions.data;

                          // Clear the existing table rows
                        const tableBody = document.querySelector('table tbody');
                        tableBody.innerHTML = '';
                        // Check if there are any Actions returned
                        if (actions.length === 0) {
                            const noResultsRow = `<tr><td colspan="8" class="text-center">{{ trans('No Actions Found') }}</td></tr>`;
                            tableBody.innerHTML = noResultsRow;
                        } else {

                        let actionsTableBody = document.querySelector('#actions-table tbody');
                        actionsTableBody.innerHTML = ''; // Clear existing data

                        data.actions.data.forEach(action => {
                            let row = `
                                <tr style="border-bottom: 1px solid var(--default-border-color);">
                                    <td class="datatable-td">${action.started_at}</td>
                                    <td class="datatable-td">
                                        <span class="badge rounded-pill bg-${action.priority_color} fixed-pill">
                                            ${action.priority_label}
                                        </span>
                                    </td>
                                    <td class="datatable-td"> 
                                      <a href="${action.show_action_url}">${action.title}</a>
                                      </td>
                                    <td class="datatable-td">${action.content}</td>
                                    <td class="datatable-td">${action.KeyResult}</td>
                                    <td class="datatable-td">${action.model_type}</td>
                                    <td class="datatable-td">${action.finished_at}</td>
                                    <td class="datatable-td">${action.user_name}</td>
                                </tr>
                            `;
                            actionsTableBody.insertAdjacentHTML('beforeend', row);
                        });
                    }
                        })
                        .catch(error => {
                            console.error('Error fetching project data:', error);
                        });
                    } else {
                        console.log('No organizations selected');
                    }
                });

            function selectOrganization(id, name) {
                document.getElementById('organizationDropdown').style.display = 'none';
            }

            document.getElementById("it-has").addEventListener("click", toggleIsWith);

            function toggleIsWith(event) {
                event.stopPropagation();
                var dropdown = document.getElementById('classDropdown');
                if (dropdown.style.display === "block") {
                    dropdown.style.display = "none";
                } else {
                    closeAllDropdowns();
                    dropdown.style.display = "block";
                }
            }

            document.getElementById("clearClauses").addEventListener("click", function() {
                const checkboxes = document.querySelectorAll('#clausesForm input[type="checkbox"]');
                checkboxes.forEach(checkbox => {
                    checkbox.checked = false;
                });
            });

            document.getElementById("applyClauses").addEventListener("click", function() {
                const selectedClasses = [];
                const checkboxes = document.querySelectorAll('#clausesForm input[type="checkbox"]:checked');
                checkboxes.forEach(checkbox => {
                    selectedClasses.push(checkbox.name);
                });
                console.log('Selected Clauses:', selectedClasses);

                if(selectedClasses){

                    var baseUrl = "{{ route('actions.filter') }}";
                    var url = `${baseUrl}?classes=${selectedClasses.join(',')}`; 
                fetch(url, {
                        method: 'GET',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                       
                        const actions = data.actions.data;
                          // Clear the existing table rows
                        const tableBody = document.querySelector('table tbody');
                        tableBody.innerHTML = '';
                        // Check if there are any actions returned
                        if (actions.length === 0) {
                            const noResultsRow = `<tr><td colspan="8" class="text-center">{{ trans('No Actions Found') }}</td></tr>`;
                            tableBody.innerHTML = noResultsRow;
                        } else {

                        let actionsTableBody = document.querySelector('#actions-table tbody');
                        actionsTableBody.innerHTML = ''; // Clear existing data

                        data.actions.data.forEach(action => {
                            let row = `
                                <tr style="border-bottom: 1px solid var(--default-border-color);">
                                    <td class="datatable-td">${action.started_at}</td>
                                    <td class="datatable-td">
                                        <span class="badge rounded-pill bg-${action.priority_color} fixed-pill">
                                            ${action.priority_label}
                                        </span>
                                    </td>
                                    <td class="datatable-td"> 
                                      <a href="${action.show_action_url}">${action.title}</a>
                                      </td>
                                    <td class="datatable-td">${action.content}</td>
                                    <td class="datatable-td">${action.KeyResult}</td>
                                    <td class="datatable-td">${action.model_type}</td>
                                    <td class="datatable-td">${action.finished_at}</td>
                                    <td class="datatable-td">${action.user_name}</td>
                                </tr>
                            `;
                            actionsTableBody.insertAdjacentHTML('beforeend', row);
                        });
                    }
                    })
                    .catch(error => {
                        console.error('Error fetching project data:', error);
                    });



                console.log("Final URL:", url);
                }else{
                    return;
                }


                document.getElementById('classDropdown').style.display = 'none';
            });

            document.getElementById("priority").addEventListener("click", toggleProjectValue);

            function toggleProjectValue(event) {
                event.stopPropagation();
                var dropdown = document.getElementById('priorityDropdown');
                if (dropdown.style.display === "block") {
                    dropdown.style.display = "none";
                } else {
                    closeAllDropdowns();
                    dropdown.style.display = "block";

                    var url = `{{ route('priorities.get') }}`;

                    console.log(url);

                    fetch(url, {
                        method: 'GET',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log('Fetched data:', data);

                        const prioritiesListContainer = document.getElementById('prioritiesListContainer');
                        prioritiesListContainer.innerHTML = '';                  
                        const hr = document.createElement('hr');

                        // Iterate over each user object in the array
                        data.forEach(priority => {
                            const listItem = document.createElement('li');

                            const checkbox = document.createElement('input');
                            checkbox.type = 'checkbox';
                            checkbox.id = `priority-${priority.id}`;
                            checkbox.value = priority.id;
                            checkbox.classList.add('priority-checkbox');

                            const label = document.createElement('label');
                            label.htmlFor = `priority-${user.id}`;
                            label.textContent = priority.priority;

                            listItem.appendChild(checkbox);
                            listItem.appendChild(label);
                            listItem.classList.add('priority-item');
                            
                            prioritiesListContainer.appendChild(listItem);
                        });

                        prioritiesListContainer.appendChild(hr);
                    })
                    .catch(error => {
                        console.error('Error fetching users data:', error);
                    });

                
            
                }
            }

            document.getElementById("applyPriorities").addEventListener("click", function() {
            // Get all checked checkboxes within the priorityValueForm
            const selectedPriorityIds = [];
            const checkboxes = document.querySelectorAll('.priority-checkbox:checked');

            // Collect the names of selected checkboxes
            checkboxes.forEach(checkbox => {
                selectedPriorityIds.push(checkbox.value);
            });
            
            // console.log(selectedPriorityIds);

            // Prepare the URL
            const baseUrl = "{{ route('actions.filter') }}";
            let url = `${baseUrl}`;
            
            if (selectedPriorityIds.length > 0) {
                const params = new URLSearchParams();
                params.append('priorities', selectedPriorityIds.join(','));
                url += `?${params.toString()}`;
            }

            // Log the URL or make an AJAX request
            console.log(url);
            
            // Example: Send the data to your method via an AJAX GET request
            fetch(url, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
              
                const actions = data.actions.data;
                        // Check if there are any actions returned

                        if (actions.length === 0) {
                            const noResultsRow = `<tr><td colspan="8" class="text-center">{{ trans('No Actions Found') }}</td></tr>`;
                            tableBody.innerHTML = noResultsRow;
                        } else {

                        let actionsTableBody = document.querySelector('#actions-table tbody');
                        actionsTableBody.innerHTML = ''; // Clear existing data

                        data.actions.data.forEach(action => {
                            let row = `
                                <tr style="border-bottom: 1px solid var(--default-border-color);">
                                    <td class="datatable-td">${action.started_at}</td>
                                    <td class="datatable-td">
                                        <span class="badge rounded-pill bg-${action.priority_color} fixed-pill">
                                            ${action.priority_label}
                                        </span>
                                    </td>
                                    <td class="datatable-td"> 
                                      <a href="${action.show_action_url}">${action.title}</a>
                                      </td>
                                    <td class="datatable-td">${action.content}</td>
                                    <td class="datatable-td">${action.KeyResult}</td>
                                    <td class="datatable-td">${action.model_type}</td>
                                    <td class="datatable-td">${action.finished_at}</td>
                                    <td class="datatable-td">${action.user_name}</td>
                                </tr>
                            `;
                            actionsTableBody.insertAdjacentHTML('beforeend', row);
                        });
                    }
            })
            .catch(error => {
                console.error('Fetch error:', error);
            });
        });



       // Event listener for when the search input changes or when the user presses enter
        document.getElementById("filterSearch").addEventListener("input", function(event) {
            const searchQuery = event.target.value;

            const baseUrl = "{{ route('actions.filter') }}";
            // Log the search query to the console or use it in an AJAX request
            console.log('Search query:', searchQuery);

            // Example: Append the search query to a URL and make an AJAX request
            const url = `${baseUrl}?search=${encodeURIComponent(searchQuery)}`;

            console.log(url);
            fetch(url, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
              
                     const actions = data.actions.data;
                     // Clear the existing table rows
                     const tableBody = document.querySelector('table tbody');
                     tableBody.innerHTML = '';
                        // Check if there are any actions returned
                        if (actions.length === 0) {
                            const noResultsRow = `<tr><td colspan="8" class="text-center">{{ trans('No Actions Found') }}</td></tr>`;
                            tableBody.innerHTML = noResultsRow;
                        } else {

                        let actionsTableBody = document.querySelector('#actions-table tbody');
                        actionsTableBody.innerHTML = ''; // Clear existing data

                        data.actions.data.forEach(action => {
                            let row = `
                                <tr style="border-bottom: 1px solid var(--default-border-color);">
                                    <td class="datatable-td">${action.started_at}</td>
                                    <td class="datatable-td">
                                        <span class="badge rounded-pill bg-${action.priority_color} fixed-pill">
                                            ${action.priority_label}
                                        </span>
                                    </td>
                                    <td class="datatable-td"> 
                                      <a href="${action.show_action_url}">${action.title}</a>
                                      </td>
                                    <td class="datatable-td">${action.content}</td>
                                    <td class="datatable-td">${action.KeyResult}</td>
                                    <td class="datatable-td">${action.model_type}</td>
                                    <td class="datatable-td">${action.finished_at}</td>
                                    <td class="datatable-td">${action.user_name}</td>
                                </tr>
                            `;
                            actionsTableBody.insertAdjacentHTML('beforeend', row);
                        });
                    }
            })
            .catch(error => {
                console.error('Fetch error:', error);
            });
        });






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
@endsection

