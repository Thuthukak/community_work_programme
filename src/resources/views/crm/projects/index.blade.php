@extends('layouts.crm')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.6/flatpickr.min.css">
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

.search-field {
    padding: 12px;
    border-radius: 25px;
    border: 1px solid #ccc;
}



</style>

@section('title', trans('project.index_title', ['status' => $status]))

@section('contents')
<div id="app">
    <div class="project-header flex justify-between items-center mb-4">
        <h4 class="project-title page-header-pill text-xl custom-page-header font-semibold">
            {{ trans('project.index_title', ['status' => $status]) }}
        </h4>
        @can('create', new App\Models\ProjectManagement\Projects\Project)
            <div class="create-action-btns ml-auto">
                <div class="dropdown">
                    <button class="btn btn-success mr-2 btn-sm dropdown-toggle p-2" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {{ trans('project.action') }}
                        <i class="fas fa-caret-down arrow-icon" id="dropdownArrow"></i>
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    @if ($projects->isNotEmpty() && $project = $projects->first())
                        <a class="dropdown-item {{ Request::segment(3) == 'jobs' ? 'active' : '' }}" href="{{ route('projects.jobs.index', $project->id) }}">
                            <i class="fas fa-tasks"></i> {!! __('project.jobs').' ('.$project->jobs->count().')' !!}
                        </a>
                        <a class="dropdown-item {{ Request::segment(3) == 'issues' ? 'active' : '' }}" href="{{ route('projects.issues.index', $project->id) }}">
                            <i class="fas fa-exclamation-circle"></i> {!! __('project.issues').' ('.$project->issues->count().')' !!}
                        </a>
                        <a class="dropdown-item {{ Request::segment(3) == 'comments' ? 'active' : '' }}" href="{{ route('projects.comments.index', $project->id) }}">
                            <i class="fas fa-comments"></i> {!! __('comment.list').' ('.$project->comments->count().')' !!}
                        </a>
                        <a class="dropdown-item {{ Request::segment(3) == 'files' ? 'active' : '' }}" href="{{ route('projects.files', $project->id) }}">
                            <i class="fas fa-file-alt"></i> {!! __('project.files').' ('.$project->files->count().')' !!}
                        </a>
                    @else
                        <a class="dropdown-item disabled" href="#">
                            <i class="fas fa-exclamation-triangle"></i> No projects found
                        </a>
                    @endif
                    </div>
                </div>
                <div class="create-project-btn ml-auto">
                    <button class="btn btn-warning btn-sm p-2" data-toggle="modal" data-target="#createProjectModal">{{ trans('project.create') }}</button>
                </div>
            </div>
        @endcan
    </div>

<div class="project-controls flex justify-between items-center mb-4 single-filter single-search-wrapper">
    <!-- Filters on the left -->
    <div class="filters d-flex" style="margin-left: 20px;">
        <div class="filter-item">
            <button class="btn filter-btn" type="button" id="projectstage" style="background-color: white; color: grey;    padding:12px ; border-radius: 25px;" aria-haspopup="true" aria-expanded="false">
                Project Progress <i class="fas fa-caret-down arrow-icon" id="dropdownArrow"></i>
            </button>
            <div id="progressDropdown" class="dropdown-content">
                @include('crm.projects.partials.index-nav-tabs')
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
            <button class="filter-btn" id="Projectvalue" style="border-radius: 25px; padding:12px">Project Value</button>
            <div id="valueDropdown" class="dropdown-content" style="display: none;">
                <form id="projectValueForm" class="filter-form">
                    <div class="form-group">
                        <label for="minValue">Minimum Value</label>
                        <input type="number" id="minValue" value = '0'class="form-control" placeholder="Min value" step="1">
                    </div>
                    <div class="form-group">
                        <label for="maxValue">Maximum Value</label>
                        <input type="number" id="maxValue" class="form-control" placeholder="Max value" step="1">
                    </div>
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
                    <label><input type="checkbox" name="Actions">Actions</label>
                    <label><input type="checkbox" name="Objectives">Objectives</label>
                    <button type="button" id="clearClauses" class="btn btn-clear pl-sm-0">Clear</button>
                    <button type="button" id="applyClauses" class="btn btn-primary">Apply</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Search on the right -->
    {!! Form::open(['method' => 'get', 'class' => 'form-inline search-form d-flex align-items-center']) !!}
    {{ Form::hidden('status_id') }}
    <div class="form-group form-group-with-search d-flex align-items-center relative">
        <span class="form-control-feedback">
            <i>
                <svg class="feather feather-search" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="11" cy="11" r="8"></circle>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                </svg>
            </i>
        </span>
        {!! Form::text('q', Request::get('q'), ['class' => 'form-control index-search-field', 'placeholder' => trans('project.search')]) !!}
    </div>
    {!! Form::close() !!}
</div>


    <small class="custom-text-muted" style="margin-left:20px;">{{ $projects->total() }} {{ trans('project.found') }}</small>

    @if($projects->isEmpty())
        <div class="alert alert-warning" role="alert">
            {{ $status }} {{ trans('project.not_found') }}
        </div>
    @else
        <div class="table-wrapper shadow">
            <div class="panel panel-default table-responsive">
                <table class="table table-condensed table-hover">
                    <thead class="custom-th">
                        <th>{{ trans('app.table_no') }}</th>
                        <th>{{ trans('project.name') }}</th>
                        <th class="text-center">{{ trans('project.start_date') }}</th>
                        <th class="text-center">{{ trans('project.work_duration') }}</th>
                        @if (request('status_id') == 2)
                        <th class="text-right">{{ trans('project.overall_progress') }}</th>
                        <th class="text-center">{{ trans('project.due_date') }}</th>
                        @endif
                        @can('see-pricings', new App\Models\ProjectManagement\Projects\Project)
                        <th class="text-right">{{ trans('project.project_value') }}</th>
                        @endcan
                        <th class="text-center">{{ trans('app.status') }}</th>
                        <th>{{ trans('Organization') }}</th>
                        <th>{{ trans('app.action') }}</th>
                    </thead>
                    <tbody>
                        @foreach($projects as $key => $project)
                            <tr>
                                <td>{{ $projects->firstItem() + $key }}</td>
                                <td>{{ $project->nameLink() }}</td>
                                <td class="text-center">{{ $project->start_date }}</td>
                                <td class="text-right">{{ $project->work_duration }}</td>
                                @if (request('status_id') == 2)
                                <td class="text-right">{{ format_decimal($project->getJobOveralProgress()) }} %</td>
                                <td class="text-center">{{ $project->due_date }}</td>
                                @endif
                                @can('see-pricings', new App\Models\ProjectManagement\Projects\Project)
                                <td class="text-right">{{ format_money($project->project_value) }}</td>
                                @endcan
                                <td class="text-center">{{ $project->present()->status }}</td>
                                <td>
                                    <a href="{{ route('organizations.edit', $project->organization_id) }}">
                                        {{ is_object($project->organization) ? __($project->organization->name) : __($project->organization) }}
                                    </a>
                                </td>
                                <td>
                                    {!! html_link_to_route('projects.show', '', [$project->id], ['icon' => 'search', 'class' => 'btn btn-info btn-xs', 'title' => trans('app.show')]) !!}
                                    <button class="btn btn-warning btn-xs edit-project-btn" data-id="{{ $project->id }}" data-toggle="modal" data-target="#editProjectModal" title="{{ trans('app.edit') }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    {{ $projects->appends(Request::except('page'))->render() }}
</div>

<!-- Modal -->
<div id="createProjectModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{ __('Add Project') }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                {!! Form::open(['route' => 'projects.store', 'method' => 'POST']) !!}
                <div class="modal-body">
                    {!! FormField::text('name', ['label' => trans('project.name'), 'required' => true ]) !!}
                    {!! FormField::select('organization_id', $Organization, ['placeholder' => ('Organization'), 'required' => true]) !!}
                    <div class="row">
                        <div class="col-md-6">
                            {!! FormField::text('proposal_date', ['label' => trans('project.proposal_date') , 'required' => true ]) !!}
                        </div>
                        <div class="col-md-6">
                            {!! FormField::price('proposal_value', ['label' => trans('project.proposal_value'), 'currency' => Option::get('money_sign', 'R') , 'required' => true ]) !!}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            {!! FormField::text('start_date', ['label' => __('project.start_date') , 'required' => true ]) !!}
                        </div>
                        <div class="col-md-6">
                            {!! FormField::text('due_date', ['label' => __('project.due_date') , 'required' => true ]) !!}
                        </div>
                        <div class="col-md-6">
                            {!! FormField::text('end_date', ['label' => __('project.end_date') ,'required' => true]) !!}
                        </div>
                    </div>
                    {!! FormField::textarea('description', ['label' => trans('project.description') ,'required' => true ]) !!}
                </div>
                <div class="modal-footer">
                    {!! Form::submit(trans('Save'), ['class' => 'btn btn-success']) !!}
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('app.cancel') }}</button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>


<!-- Edit Modal -->
<div id="editProjectModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ __('Edit Project') }}</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                {!! Form::model($projects->first(), ['route' => ['projects.update', $projects->first()->id ?? 0], 'method' => 'patch', 'id' => 'editProjectForm']) !!}
                <div class="panel-body">
                    {!! FormField::text('name', ['label' => __('project.name') ,'required' => true ]) !!}
                    <div class="row">
                        <div class="col-md-8">
                            {!! FormField::textarea('description', ['label' => __('project.description'), 'rows' => 5 ,'required' => true  ]) !!}
                        </div>
                        <div class="col-md-4">
                            {!! FormField::price('proposal_value', ['label' => __('project.proposal_value'), 'currency' => Option::get('money_sign', 'R' ) ,'required' => true ]) !!}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            {!! FormField::text('proposal_date', ['label' => __('project.proposal_date') ,'required' => true]) !!}
                        </div>
                        <div class="col-md-6">
                            {!! FormField::text('start_date', ['label' => __('project.start_date') , 'required' => true ]) !!}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            {!! FormField::text('due_date', ['label' => __('project.due_date') , 'required' => true]) !!}
                        </div>
                        <div class="col-md-6">
                            {!! FormField::text('end_date', ['label' => __('project.end_date') , 'required' => true ]) !!}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            {!! FormField::select('status_id', ProjectStatus::toArray(), ['label' => __('app.status') , 'required' => true ]) !!}
                        </div>
                        <div class="col-md-6">
                            {!! FormField::select('organization_id', $Organization, ['label' => __('Organization'), 'required' => true]) !!}
                        </div>
                    </div>
                    <div class="modal-footer">
                        {!! Form::submit(trans('Save'), ['class' => 'btn btn-success']) !!}
                        <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('app.cancel') }}</button>
                        @can('delete', $projects->first())
                            {!! link_to_route('projects.delete', __('app.delete'), [$projects->first()->id ?? 0], ['class' =>'btn btn-danger pull-right']) !!}
                        @endcan
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
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

        document.querySelectorAll('.edit-project-btn').forEach(function(button) {
            button.addEventListener('click', function() {
                var projectId = this.getAttribute('data-id');
                var url = "{{ route('projects.edit', ['project' => ':id']) }}".replace(':id', projectId);

                console.log('Project ID:', projectId); // Log the project ID
                console.log('URL:', url); // Log the URL

                // AJAX request to fetch project details
                fetch(url, {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest' // Ensure the request is identified as AJAX
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Fetched data:', data); // Log the fetched data

                    const project = data.project;
                    const organization = data.organization;

                    // Check if the form and its fields exist before populating them
                    const editProjectForm = document.getElementById('editProjectForm');
                    if (!editProjectForm) {
                        throw new Error('Edit Project Form not found');
                    }

                    editProjectForm.setAttribute('action', "{{ route('projects.update', 0) }}".replace('/0', '/' + project.id));
                    const nameField = document.querySelector('#editProjectForm input[name="name"]');
                    const descriptionField = document.querySelector('#editProjectForm textarea[name="description"]');
                    const proposalDateField = document.querySelector('#editProjectForm input[name="proposal_date"]');
                    const startDateField = document.querySelector('#editProjectForm input[name="start_date"]');
                    const dueDateField = document.querySelector('#editProjectForm input[name="due_date"]');
                    const endDateField = document.querySelector('#editProjectForm input[name="end_date"]');
                    const statusField = document.querySelector('#editProjectForm select[name="status_id"]');
                    const organizationField = document.querySelector('#editProjectForm select[name="organization_id"]');

                    if (nameField) nameField.value = project.name;
                    if (descriptionField) descriptionField.value = project.description;
                    if (proposalDateField) proposalDateField.value = project.proposal_date;
                    if (startDateField) startDateField.value = project.start_date;
                    if (dueDateField) dueDateField.value = project.due_date;
                    if (endDateField) endDateField.value = project.end_date;
                    if (statusField) statusField.value = project.status_id;
                    if (organizationField) organizationField.value = project.organization_id;

                    // Show the modal
                    $('#editProjectModal').modal('show');
                })
                .catch(error => {
                    console.error('Error fetching project data:', error);
                });
            });
        });


        document.getElementById("projectstage").addEventListener("click", toggleDropdown);

        function toggleDropdown() {
            var dropdown = document.getElementById('progressDropdown');
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
@endsection

