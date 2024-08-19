@extends('layouts.crm')

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
@section('title', __('job.on_progress'))
@section('contents')
<ul class="breadcrumb hidden-print header-pill"><li>{{ __('job.on_progress') }}</li></ul>
<div class="panel panel-default table-responsive">
    <div class="project-controls flex justify-between items-center mb-4">
        <div class="index-nav-tabs pull-left hidden-xs">
            </div>
            {!! Form::open(['method' => 'get', 'class' => 'form-inline search-form']) !!}
            {{ Form::hidden('status_id') }}
            <div class="relative">
            <button type="submit" class="search-button">
            </button>
        </div>
            {!! Form::close() !!}
</div>
<div class="filters" style="margin-left:20px;">
    <div class="filter-item">
        <button class="btn filter-btn" type="button" id="projectslist" style="background-color: white; color: grey;    padding:12px ; border-radius: 25px;" aria-haspopup="true" aria-expanded="false">
            Projects all <i class="fas fa-caret-down arrow-icon" id="dropdownArrow"></i>
        </button>
        <div id="projectsDropdown" class="dropdown-content">
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
    <div class="filter-item search-item" style="margin-left:auto;">
        <input type="text" class="search-field" id="filterSearch" placeholder="Search...">
    </div>
</div>

    <div class="table-wrapper shadow" style="margin:20px">
    <table class="task-progress-table table table-condensed">
        <thead>
            <th>{{ __('app.table_no') }}</th>
            <th>{{ __('job.name') }}</th>
            <th>{{ __('project.name') }}</th>
            <th class="text-center">{{ __('job.created_at') }}</th>
            <th class="text-center">{{ __('job.tasks_count') }}</th>
            <th class="text-center">{{ __('job.progress') }}</th>
            @can('see-pricings', new App\Models\ProjectManagement\Projects\ProjectJob)
            <th class="text-right">{{ __('job.price') }}</th>
            @endcan
            <th>{{ __('job.person') }}</th>
            <th>{{ __('app.action') }}</th>
        </thead>
        <tbody>
            @forelse($jobs as $key => $job)
            <tr>
                <td>{{ 1 + $key }}</td>
                <td>
                    {{ $job->nameLink() }}
                    @if ($job->tasks->isEmpty() == false)
                    <ul>
                        @foreach($job->tasks as $task)
                        <li style="cursor:pointer" title="{{ $task->progress }} %">
                            <i class="fa fa-battery-{{ ceil(4 * $task->progress/100) }}"></i>
                            {{ $task->name }}
                        </li>
                        @endforeach
                    </ul>
                    @endif
                </td>
                <td>{{ $job->project->nameLink() }}</td>
                <td class="text-center" style="width: 120px;">{{ $job->project->created_at->format('Y-m-d') }}</td>
                <td class="text-center">{{ $job->tasks_count = $job->tasks->count() }}</td>
                <td class="text-center">{{ format_decimal($job->progress) }} %</td>
                @can('see-pricings', $job)
                <td class="text-right">{{ format_money($job->price) }}</td>
                @endcan
                <td>{{ $job->person->name }}</td>
                <td>
                    {{ link_to_route('jobs.show', __('app.show'), [$job], ['class' => 'btn btn-info btn-xs']) }}
                </td>
            </tr>
            @empty
            <tr><td colspan="8">{{ __('job.empty') }}</td></tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <th></th>
                <th class="text-right" colspan="3">{{ __('app.total') }}</th>
                <th class="text-center">{{ $jobs->sum('tasks_count') }}</th>
                <th class="text-center">{{ format_decimal($jobs->avg('progress')) }} %</th>
                @can('see-pricings', new App\Models\ProjectManagement\Projects\ProjectJob)
                <th class="text-right">{{ format_money($jobs->sum('price')) }}</th>
                @endcan
                <th colspan="2"></th>
            </tr>
        </tfoot>
    </table>
</div> 
</div>
@endsection

@section('script')
<!-- Include Flatpickr JS from cdnjs -->

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById("projectslist").addEventListener("click", toggleDropdown);

        function toggleDropdown() {
            var dropdown = document.getElementById('projectsDropdown');
            if (dropdown.style.display === "block") {
                dropdown.style.display = "none";
            } else {
                dropdown.style.display = "block";


                var url = `{{ route('projects.list') }}`;


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
                    // Clear any existing list items
                    const projectListContainer = document.getElementById('projectsListContainer');
                    projectListContainer.innerHTML = '';                  

                    // Create list items for each project
                    data.forEach(project => {
                    const listItem = document.createElement('li');

                    const checkbox = document.createElement('input');
                    checkbox.type = 'checkbox';
                    checkbox.id = `project-${project.id}`;
                    checkbox.name = 'selected_projects';
                    checkbox.value = project.id;

                    const label = document.createElement('label');
                    label.htmlFor = `project-${project.id}`;
                    label.textContent = project.name;

                    listItem.appendChild(checkbox);
                    listItem.appendChild(label);
                    projectListContainer.appendChild(listItem);
                });

                 

                })
                .catch(error => {
                    console.error('Error fetching projects data:', error);
                });


            }
        }
        document.getElementById("clearProjects").addEventListener("click", function() {
                const checkboxes = document.querySelectorAll('.projectsList input[type="checkbox"]');
                checkboxes.forEach(checkbox => {
                    checkbox.checked = false;
                });
            });

            document.getElementById("applyProjects").addEventListener("click", function() {
            const selectedProjects = [];
            const checkboxes = document.querySelectorAll('.projectsList input[type="checkbox"]:checked');
            checkboxes.forEach(checkbox => {
                selectedProjects.push(checkbox.value);
            });

            if(selectedProjects.length > 0) {
                console.log('Selected Projects:', selectedProjects);

                const idsString =  selectedProjects.join(',');

                var baseUrl = "{{ route('jobs.list') }}"

                var url = `${baseUrl}?projects=${encodeURIComponent(idsString)}`;
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
                // Clear the existing table rows
                const tableBody = document.querySelector('table tbody');
                tableBody.innerHTML = ''; // Clear existing table rows

                const jobs = data.jobs.data; // Assuming 'data.jobs.data' contains the filtered jobs

                // Check if there are any jobs returned
                if (jobs.length === 0) {
                    const noResultsRow = `<tr><td colspan="8" class="text-center">{{ trans('No Tasks Found') }}</td></tr>`;
                    tableBody.innerHTML = noResultsRow;
                } else {
                    console.log(data);

                    jobs.forEach((job, key) => {
                        const tasksList = job.tasks.map(task => `
                            <li style="cursor:pointer" title="${task.progress} %">
                                <i class="fa fa-battery-${Math.ceil(4 * task.progress / 100)}"></i>
                                ${task.name}
                            </li>
                        `).join('');

                        const row = `
                            <tr>
                                <td>${data.jobs.from + key}</td>
                                <td>
                                    <a href="${job.show_url}">${job.name}</a>
                                    ${tasksList ? `<ul>${tasksList}</ul>` : ''}
                                </td>
                                <td><a href="${job.project_Show_Link}">${job.project_name}</a></td>
                                <td class="text-center" style="width: 120px;">${job.target_start_date}</td>
                                <td class="text-center">${job.tasks_count || 0}</td>
                                <td class="text-center">${job.progress}</td>
                               <td class="text-right">${job.formatted_price}</td>
                                <td>${job.person_name}</td>
                                <td>
                                    <a href="${job.show}" class="btn btn-info btn-xs" title="${job.name}">
                                        <i class="fas fa-search"></i> {{ __('app.show') }}
                                    </a>
                                </td>
                            </tr>`;
                        
                        tableBody.innerHTML += row; // Append the new row to the table
                    });

                    const tableFooter = document.querySelector('table tfoot');
                    const footerRow = `
                            <tr>
                                <th></th>
                                <th class="text-right" colspan="3">{{ __('app.total') }}</th>
                                <th class="text-center">${data.totalTasksCount}</th>
                                <th class="text-center">${data.formattedAvgProgress}</th>
                                @can('see-pricings', new App\Models\ProjectManagement\Projects\ProjectJob)
                                <th class="text-right">${data.formattedTotalPrice}</th>
                                @endcan
                                <th colspan="2"></th>
                            </tr>`;

                tableFooter.innerHTML = footerRow;
                }

                })
                .catch(error => {
                    console.error('Error fetching project data:', error);
                });
                
            } else {
                console.log('No projects selected.');
            }

            

            document.getElementById('projectsDropdown').style.display = 'none';
        });

        document.getElementById("datefilter").addEventListener("click", function(event) {
            event.stopPropagation();
            var dropdown = document.getElementById('dateDropdown');
            if (dropdown.style.display === "block") {
                dropdown.style.display = "none";
            } else {
                closeAllDropdowns();  // Make sure this function is defined elsewhere to close other dropdowns
                dropdown.style.display = "block";

                // Initialize flatpickr for the start and end date inputs
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
            // Add your code to handle the selected dates
            toggleDropdown('dateDropdown');
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
                const selectedOrganizations = [];
                const checkboxes = document.querySelectorAll('.organization-checkbox:checked');
                checkboxes.forEach(checkbox => {
                    selectedOrganizations.push(checkbox.value); // Only push the ID (value) instead of an object
                });

                if (selectedOrganizations.length > 0) {
                    console.log('Selected Organizations:', selectedOrganizations);

                    const idsString = selectedOrganizations.join(','); // Join the IDs into a comma-separated string

                    var baseUrl = "{{ route('jobs.list') }}";

                    var url = `${baseUrl}?Organization=${encodeURIComponent(idsString)}`;
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
                // Clear the existing table rows
                const tableBody = document.querySelector('table tbody');
                tableBody.innerHTML = ''; // Clear existing table rows

                const jobs = data.jobs.data; // Assuming 'data.jobs.data' contains the filtered jobs

                // Check if there are any jobs returned
                if (jobs.length === 0) {
                    const noResultsRow = `<tr><td colspan="8" class="text-center">{{ trans('No Tasks Found') }}</td></tr>`;
                    tableBody.innerHTML = noResultsRow;
                } else {
                    console.log(data);

                    jobs.forEach((job, key) => {
                        const tasksList = job.tasks.map(task => `
                            <li style="cursor:pointer" title="${task.progress} %">
                                <i class="fa fa-battery-${Math.ceil(4 * task.progress / 100)}"></i>
                                ${task.name}
                            </li>
                        `).join('');

                        const row = `
                            <tr>
                                <td>${data.jobs.from + key}</td>
                                <td>
                                    <a href="${job.show_url}">${job.name}</a>
                                    ${tasksList ? `<ul>${tasksList}</ul>` : ''}
                                </td>
                                <td><a href="${job.project_Show_Link}">${job.project_name}</a></td>
                                <td class="text-center" style="width: 120px;">${job.target_start_date}</td>
                                <td class="text-center">${job.tasks_count || 0}</td>
                                <td class="text-center">${job.progress}</td>
                               <td class="text-right">${job.formatted_price}</td>
                                <td>${job.person_name}</td>
                                <td>
                                    <a href="${job.show}" class="btn btn-info btn-xs" title="${job.name}">
                                        <i class="fas fa-search"></i> {{ __('app.show') }}
                                    </a>
                                </td>
                            </tr>`;
                        
                        tableBody.innerHTML += row; // Append the new row to the table
                    });

                    const tableFooter = document.querySelector('table tfoot');
                    const footerRow = `
                            <tr>
                                <th></th>
                                <th class="text-right" colspan="3">{{ __('app.total') }}</th>
                                <th class="text-center">${data.totalTasksCount}</th>
                                <th class="text-center">${data.formattedAvgProgress}</th>
                                @can('see-pricings', new App\Models\ProjectManagement\Projects\ProjectJob)
                                <th class="text-right">${data.formattedTotalPrice}</th>
                                @endcan
                                <th colspan="2"></th>
                            </tr>`;

                tableFooter.innerHTML = footerRow;
                }

                })
                .catch(error => {
                    console.error('Error fetching project data:', error);
                });
                
            } else {
                console.log('No tasks selected.');
            }

            console.log('Selected Organizations:', selectedOrganizations);
            document.getElementById('organizationDropdown').style.display = 'none';
        });


        function selectOrganization(id, name) {
            console.log('Selected Organization:', id, name);
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

            if (selectedClasses.length > 0) {
                console.log('Selected Classes:', selectedClasses);

                var baseUrl = "{{ route('jobs.list') }}";
                var url = `${baseUrl}?classes=${encodeURIComponent(JSON.stringify(selectedClasses))}`;
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
                // Clear the existing table rows
                const tableBody = document.querySelector('table tbody');
                tableBody.innerHTML = ''; // Clear existing table rows

                const jobs = data.jobs.data; // Assuming 'data.jobs.data' contains the filtered jobs

                // Check if there are any jobs returned
                if (jobs.length === 0) {
                    const noResultsRow = `<tr><td colspan="8" class="text-center">{{ trans('No Tasks Found') }}</td></tr>`;
                    tableBody.innerHTML = noResultsRow;
                } else {
                    console.log(data);

                    jobs.forEach((job, key) => {
                        const tasksList = job.tasks.map(task => `
                            <li style="cursor:pointer" title="${task.progress} %">
                                <i class="fa fa-battery-${Math.ceil(4 * task.progress / 100)}"></i>
                                ${task.name}
                            </li>
                        `).join('');

                        const row = `
                            <tr>
                                <td>${data.jobs.from + key}</td>
                                <td>
                                    <a href="${job.show_url}">${job.name}</a>
                                    ${tasksList ? `<ul>${tasksList}</ul>` : ''}
                                </td>
                                <td><a href="${job.project_Show_Link}">${job.project_name}</a></td>
                                <td class="text-center" style="width: 120px;">${job.target_start_date}</td>
                                <td class="text-center">${job.tasks_count || 0}</td>
                                <td class="text-center">${job.progress}</td>
                               <td class="text-right">${job.formatted_price}</td>
                                <td>${job.person_name}</td>
                                <td>
                                    <a href="${job.show}" class="btn btn-info btn-xs" title="${job.name}">
                                        <i class="fas fa-search"></i> {{ __('app.show') }}
                                    </a>
                                </td>
                            </tr>`;
                        
                        tableBody.innerHTML += row; // Append the new row to the table
                    });

                    const tableFooter = document.querySelector('table tfoot');
                    const footerRow = `
                            <tr>
                                <th></th>
                                <th class="text-right" colspan="3">{{ __('app.total') }}</th>
                                <th class="text-center">${data.totalTasksCount}</th>
                                <th class="text-center">${data.formattedAvgProgress}</th>
                                @can('see-pricings', new App\Models\ProjectManagement\Projects\ProjectJob)
                                <th class="text-right">${data.formattedTotalPrice}</th>
                                @endcan
                                <th colspan="2"></th>
                            </tr>`;

                tableFooter.innerHTML = footerRow;
                }

                })
                .catch(error => {
                    console.error('Error fetching project data:', error);
                });
                
            } else {
                console.log('No tasks selected.');
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
            var maxValue = document.getElementById("maxValue").value;
            console.log("Min Value:", minValue, "Max Value:", maxValue);
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.6/flatpickr.min.js"></script>

@endsection
