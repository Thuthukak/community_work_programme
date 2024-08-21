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
    gap: 15px;
}

.filter-item {
    position: relative;
    height: 30px;
    border-radius: 25px;

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
    list-style-type: none; 
    padding: 10px;
    position: absolute;
    top: 100%;
    left: 0;
    background-color: transparent;
    min-width: 160px;
    z-index: 1;
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

.search-item {
    margin-left: auto;
}

.search-field {
    padding: 12px;
    border-radius: 25px;
    border: 1px solid #ccc;
    min-width: 200px; /* Adjust the width as needed */
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
            <button class="btn filter-btn" type="button" id="actions" style="background-color: white; color: grey;    padding:12px ; border-radius: 25px;" aria-haspopup="true" aria-expanded="false">
                Actions All <i class="fas fa-caret-down arrow-icon" id="dropdownArrow"></i>
            </button>
            <div id="actionsDropdown" class="dropdown-content">
            </div>
        </div>

        <div class="filter-item">
            <button class="filter-btn" style="border-radius: 25px; padding:12px" id="datefilter">Date Range</button>
            <div id="dateDropdown" class="dropdown-content">
                <form id="dateRangeForm" class="filter-form">
                    @include('crm.projects.partials.dateFilterDropdownCustom')
                </form>
            </div>
        </div>

        <div class="filter-item">
            <button class="filter-btn" id="Organizationlist" style="border-radius: 25px; padding:12px">Organization</button>
            <div id="organizationDropdown" class="dropdown-content" style="display:none;">
                <form id="organizationForm" class="filter-form">
                    <ul id="organizationListContainer"></ul>
                    <br>
                    <hr>
                    <div class="d-flex justify-content-between mt-3">
                        <button type="button" id="clearOrganizations" class="btn btn-clear">Clear</button>
                        <button type="button" id="applyOrganizations" class="btn btn-primary">Apply</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="filter-item">
            <button class="filter-btn" id="Projectvalue" style="border-radius: 25px; padding:12px">Priority</button>
            <div id="valueDropdown" class="dropdown-content" style="display: none;">
                <form id="projectValueForm" class="filter-form">
                <label><input type="checkbox" name="Urgent">Urgent</label>
                    <label><input type="checkbox" name="Immediate">Immediate</label>
                    <label><input type="checkbox" name="Normal">Normal</label>
                    <label><input type="checkbox" name="Low">Low</label>
                    <label><input type="checkbox" name="Postponed">Postponed</label>
                    <button type="button" id="clearValues" class="btn btn-clear pl-sm-0">Clear</button>
                    <button type="button" id="applyValues" class="btn btn-primary">Apply</button>
                </form>
            </div>
        </div>

        <div class="filter-item">
            <button class="filter-btn" id="it-has" style="border-radius: 25px; padding:12px">Have</button>
            <div id="classDropdown" class="dropdown-content" style="display: none;">
                <form id="clausesForm" class="filter-form">
                    <label><input type="checkbox" name="Proposal">Proposal</label>
                    <label><input type="checkbox" name="Pipeline">Pipeline</label>
                    <label><input type="checkbox" name="Objectives">Objectives</label>
                    <label><input type="checkbox" name="Project">Project</label>
                    <button type="button" id="clearClauses" class="btn btn-clear">Clear</button>
                    <button type="button" id="applyClauses" class="btn btn-primary">Apply</button>
                </form>
            </div>
        </div>

        <div class="filter-item search-item" style="margin-left:auto;">
        <input type="text" class="search-field" id="filterSearch" placeholder="Search...">
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


        document.getElementById("actions").addEventListener("click", toggleDropdown);

        function toggleDropdown() {
            var dropdown = document.getElementById('actionsDropdown');
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

                flatpickr("#startDate", {
                    dateFormat: "Y-m-d"
                });

                flatpickr("#endDate", {
                    dateFormat: "Y-m-d"
                });

                }
        });

        document.getElementById("clearDates").addEventListener("click", function() {
            document.getElementById("startDate")._flatpickr.clear();
            document.getElementById("endDate")._flatpickr.clear();
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

        document.getElementById("Organizationlist").addEventListener("click", function() {
            event.stopPropagation();
            var dropdown = document.getElementById('organizationDropdown');
            if (dropdown.style.display === "block") {
                dropdown.style.display = "none";
            } else {
                closeAllDropdowns();
                dropdown.style.display = "block";

                var url = `{{ route('organization.get') }}`;

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

                    const organizationListContainer = document.getElementById('organizationListContainer');
                    organizationListContainer.innerHTML = '';                  
                    const hr = document.createElement('hr');


                    for (const [id, name] of Object.entries(data)) {
                        const listItem = document.createElement('li');

                        
                        const checkbox = document.createElement('input');
                        checkbox.type = 'checkbox';
                        checkbox.id = `organization-${id}`;
                        checkbox.value = id;
                        checkbox.classList.add('organization-checkbox');

                        const label = document.createElement('label');
                        label.htmlFor = `organization-${id}`;
                        label.textContent = name;

                        listItem.appendChild(checkbox);
                        listItem.appendChild(label);
                        listItem.classList.add('organization-item');
                        
                        organizationListContainer.appendChild(listItem);
                    }
                    organizationListContainer.appendChild(hr);

                })
                .catch(error => {
                    console.error('Error fetching organization data:', error);
                });
            }
        });

        document.getElementById("clearOrganizations").addEventListener("click", function() {
            const checkboxes = document.querySelectorAll('.organization-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.checked = false;
            });
        });

        document.getElementById("applyOrganizations").addEventListener("click", function() {
            const selectedOrganizationIds = [];
            const checkboxes = document.querySelectorAll('.organization-checkbox:checked');
            
            checkboxes.forEach(checkbox => {
                selectedOrganizationIds.push(checkbox.value);
            });

            if (selectedOrganizationIds.length > 0) {
                console.log('Selected Organization IDs:', selectedOrganizationIds);

                // Create a comma-separated string of IDs
                const idsString = selectedOrganizationIds.join(',');

                // Build the URL manually
                var baseUrl = "{{ route('projects.get') }}";  // Get the base URL
                var url = `${baseUrl}?Organization=${encodeURIComponent(idsString)}`;

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
                    console.log('Fetched data:', data);
                    const projects = data.projects.data;

                // Clear the existing table rows
                const tableBody = document.querySelector('table tbody');
                tableBody.innerHTML = '';

                // Check if there are any projects returned
                if (projects.length === 0) {
                    const noResultsRow = `<tr><td colspan="8" class="text-center">{{ trans('project.not_found') }}</td></tr>`;
                    tableBody.innerHTML = noResultsRow;
                } else {

                    const projects = data.projects.data;
                    console.log(projects);
                    // Loop through the filtered data and create rows
                    projects.forEach((project, key) => {
                    const row = `
                        <tr>
                            <td>${data.projects.from + key}</td>
                            <td>${project.name}</td>
                            <td class="text-center">${project.start_date}</td>
                            <td class="text-right">${project.work_duration || 'N/A'}</td>
                            <td class="text-right">${project.project_value || 'N/A'}</td>
                            <td class="text-center">${project.status_text}</td>
                            <td>
                                <a href="${project.organization}">
                                    ${project.organization ? project.OrganizationName : 'N/A'}
                                </a>
                            </td>
                            <td>
                                <a href="${project.show_url}" class="btn btn-info btn-xs" title="${project.OrganizationName}">
                                    <i class="fas fa-search"></i>
                                </a>
                                <button class="btn btn-warning btn-xs edit-project-btn" data-id="${project.id}" data-toggle="modal" data-target="#editProjectModal" title="${project.edit_text}">
                                    <i class="fas fa-edit"></i>
                                </button>
                            </td>
                        </tr>`;
                    tableBody.innerHTML += row;
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

            var baseUrl = "{{ route('projects.get') }}";
            var url = `${baseUrl}?classes=${encodeURIComponent(JSON.stringify(selectedClasses))}`;

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
                    const projects = data.projects.data;

                // Clear the existing table rows
                const tableBody = document.querySelector('table tbody');
                tableBody.innerHTML = '';

                // Check if there are any projects returned
                if (projects.length === 0) {
                    const noResultsRow = `<tr><td colspan="8" class="text-center">{{ trans('project.not_found') }}</td></tr>`;
                    tableBody.innerHTML = noResultsRow;
                } else {

                    const projects = data.projects.data;
                    console.log(projects);
                    // Loop through the filtered data and create rows
                    projects.forEach((project, key) => {
                    const row = `
                        <tr>
                            <td>${data.projects.from + key}</td>
                            <td>${project.name}</td>
                            <td class="text-center">${project.start_date}</td>
                            <td class="text-right">${project.work_duration || 'N/A'}</td>
                            <td class="text-right">${project.project_value || 'N/A'}</td>
                            <td class="text-center">${project.status_text}</td>
                            <td>
                                <a href="${project.organization}">
                                    ${project.organization ? project.OrganizationName : 'N/A'}
                                </a>
                            </td>
                            <td>
                                <a href="${project.show_url}" class="btn btn-info btn-xs" title="${project.OrganizationName}">
                                    <i class="fas fa-search"></i>
                                </a>
                                <button class="btn btn-warning btn-xs edit-project-btn" data-id="${project.id}" data-toggle="modal" data-target="#editProjectModal" title="${project.edit_text}">
                                    <i class="fas fa-edit"></i>
                                </button>
                            </td>
                        </tr>`;
                    tableBody.innerHTML += row;
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

        document.getElementById("Projectvalue").addEventListener("click", toggleProjectValue);

        function toggleProjectValue(event) {
            event.stopPropagation();
            var dropdown = document.getElementById('valueDropdown');
            if (dropdown.style.display === "block") {
                dropdown.style.display = "none";
            } else {
                closeAllDropdowns();
                dropdown.style.display = "block";
            }
        }

        document.getElementById("clearValues").addEventListener("click", function() {
            document.getElementById("minValue").value = '';
            document.getElementById("maxValue").value = '';
        });

        document.getElementById("applyValues").addEventListener("click", function() {
            var minValue = document.getElementById("minValue").value;
            var maxValue = document.getElementById("maxValue").value 



            if(minValue || maxValue){

                if (!maxValue) {
                    console.log('Max value is not set. No projects will be listed.');
                    return;
                }

                // Build the base URL
                var baseUrl = "{{ route('projects.get') }}";

                // Append query strings for minValue and maxValue
                var url = `${baseUrl}?minValue=${encodeURIComponent(minValue)}&maxValue=${encodeURIComponent(maxValue)}`;

                console.log("Final URL:", url);
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
                    const projects = data.projects.data;

                // Clear the existing table rows
                const tableBody = document.querySelector('table tbody');
                tableBody.innerHTML = '';

                // Check if there are any projects returned
                if (projects.length === 0) {
                    const noResultsRow = `<tr><td colspan="8" class="text-center">{{ trans('project.not_found') }}</td></tr>`;
                    tableBody.innerHTML = noResultsRow;
                } else {

                    const projects = data.projects.data;
                    console.log(projects);
                    // Loop through the filtered data and create rows
                    projects.forEach((project, key) => {
                    const row = `
                        <tr>
                            <td>${data.projects.from + key}</td>
                            <td>${project.name}</td>
                            <td class="text-center">${project.start_date}</td>
                            <td class="text-right">${project.work_duration || 'N/A'}</td>
                            <td class="text-right">${project.project_value || 'N/A'}</td>
                            <td class="text-center">${project.status_text}</td>
                            <td>
                                <a href="${project.organization}">
                                    ${project.organization ? project.OrganizationName : 'N/A'}
                                </a>
                            </td>
                            <td>
                                <a href="${project.show_url}" class="btn btn-info btn-xs" title="${project.OrganizationName}">
                                    <i class="fas fa-search"></i>
                                </a>
                                <button class="btn btn-warning btn-xs edit-project-btn" data-id="${project.id}" data-toggle="modal" data-target="#editProjectModal" title="${project.edit_text}">
                                    <i class="fas fa-edit"></i>
                                </button>
                            </td>
                        </tr>`;
                    tableBody.innerHTML += row;
                });


                }
                })
                .catch(error => {
                    console.error('Error fetching project data:', error);
                });

            }else{
                console.log('no Values selected to filtering with project value ');
            }

            // Add your code to handle the selected values
            document.getElementById('valueDropdown').style.display = 'none';
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