@inject('priorities', 'App\Models\ProjectManagement\Projects\Priority')
@inject('issueStatuses', 'App\Models\ProjectManagement\Projects\IssueStatus')
@inject('projects', 'App\Models\ProjectManagement\Projects\Project') 

@extends('layouts.crm')


@section('title', __('issue.open_issues'))


<style>
.filters {
    position: relative;
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
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

@section('contents')

<ul class="breadcrumb hidden-print header-pill"><li>{{ __('issue.issues_on_progress') }}</li></ul>


<div class="filters" style="margin-left:20px;">
    <div class="filter-item">
        <button class="btn filter-btn" type="button" id="Issueslist" style="background-color: white; color: grey;    padding:12px ; border-radius: 25px;" aria-haspopup="true" aria-expanded="false">
            Issues all <i class="fas fa-caret-down arrow-icon" id="dropdownArrow"></i>
        </button>
        <div id="issuesDropdown" class="dropdown-content">
            <form id="getTasks">
                <ul class="projectsList" id="projectsListContainer">
                </ul>   
                <br>
            <button type="button" id="clearProjects" class="btn btn-clear pl-sm-0">Clear</button>
            <button type="button" id="applyProjects" class="btn btn-primary">Apply</button>
            </form>
        </div>
    </div>
    <div class="filter-item">
        <button class="filter-btn" style="border-radius: 25px; padding:12px" id="datefilter">Created at</button>
        <div id="dateDropdown" class="dropdown-content">
            <form id="dateRangeForm" class="filter-form">
                @include('crm.projects.partials.dateFilterDropdownCustom')
            </form>
        </div>
    </div>
    <div class="filter-item">
        <button class="filter-btn" id="Organizationlist" style="border-radius: 25px; padding:12px">Organization</button>
        <div id="organizationDropdown" class="dropdown-content" style="display: none;">
            <form id="organizationForm" class="filter-form">
                <ul id="organizationListContainer"></ul>
                <br>
                <button type="button" id="clearOrganizations" class="btn btn-clear pl-sm-0">Clear</button>
                <button type="button" id="applyOrganizations" class="btn btn-primary">Apply</button>
            </form>
        </div>
    </div>
    <div class="filter-item">
        <button class="filter-btn" id="it-has" style="border-radius: 25px; padding:12px">Have</button>
        <div id="classDropdown" class="dropdown-content" style="display: none;">
            <form id="clausesForm" class="filter-form">
                <label><input type="checkbox" name="Proposal">Proposal</label>
                <label><input type="checkbox" name="Actions">Actions</label>
                <label><input type="checkbox" name="Objectives">Objectives</label>
                <button type="button" id="clearClauses" class="btn btn-clear pl-sm-0">Clear</button>
                <button type="button" id="applyClauses" class="btn btn-primary">Apply</button>
            </form>
        </div>
    </div>
    
    <!-- New Search Bar -->
    <div class="filter-item search-item" style="margin-left:auto; margin-right:20px">
        <input type="text" class="search-field" id="filterSearch" placeholder="Search...">
    </div>
</div>

<div class="datatable mt-5 ml-3 mr-3">
    <div class="table-responsive">
        <table style="width: 100%;">
        <thead>
            <tr style="border-bottom: 1px solid var(--default-border-color);">
                <th class="datatable-th">{{ __('app.table_no') }}</th>
                <th class="datatable-th">{{ __('issue.title') }}</th>
                <th class="datatable-th">{{ __('issue.priority') }}</th>
                <th class="datatable-th">{{ __('app.status') }}</th>
                <th class="datatable-th">{{ __('Project') }}</th>
                <th class="datatable-th">{{ __('issue.pic') }}</th>
                <th class="datatable-th">{{ __('issue.creator') }}</th>
                <th class="datatable-th">{{ __('app.last_update') }}</th>
                <th class="datatable-th">{{ __('app.action') }}</th>
            </tr>
        </thead>
        <tbody>
            @forelse($issues as $key => $issue)
            <tr style="border-bottom: 1px solid var(--default-border-color);">
                    <td class="datatable-td">{{ $key + 1 }}</td>
                    <td class="datatable-td">{{ $issue->title }}</td>
                    <td class="datatable-td">{!! $issue->priority_label !!}</td>
                    <td class="datatable-td">{!! $issue->status_label !!}</td>
                    <td class="datatable-td">{{ $issue->project->name }}</td>
                    <td class="datatable-td">{{ $issue->pic->name }}</td>
                    <td class="datatable-td">{{ $issue->creator->name }}</td>
                    <td class="datatable-td">{{ $issue->updated_at->diffForHumans() }}</td>
                    <td class="datatable-td"></td>
                </tr>
            @empty
                <tr><td colspan="9">{{ __('issue.not_found') }}</td></tr>
            @endforelse
        </tbody>
        <tfoot>
            <!-- Adjust your footer as needed -->
        </tfoot>
    </table>
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
        flatpickr("#proposal_date, #start_date, #due_date, #end_date", {
            dateFormat: "Y-m-d",
            disableMobile: true // optional: to force the desktop version on mobile devices
        });

      

        document.getElementById("Issueslist").addEventListener("click", toggleDropdown);

        function toggleDropdown() {
            var dropdown = document.getElementById('issuesDropdown');
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
                document.getElementById('dateDropdown').style.display = 'none';

                })
                .catch(error => {
                    console.error('Error fetching project data:', error);
                });

                        // Add your code to handle the selected dates
            // toggleDropdown('dateDropdown');
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



