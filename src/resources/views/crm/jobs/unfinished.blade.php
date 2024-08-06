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
            <button class="btn filter-btn" type="button" id="projectstage" style="background-color: white; color: grey;" aria-haspopup="true" aria-expanded="false">
                Project Progress <i class="fas fa-caret-down arrow-icon" id="dropdownArrow"></i>
            </button>
            <div id="progressDropdown" class="dropdown-content">
                @include('crm.jobs.partials.index-nav-tabs')
            </div>
        </div>
        <div class="filter-item">
            <button class="filter-btn" style="border-radius: 25px; padding:12px" id="datefilter">Date Range</button>
            <div id="dateDropdown" class="dropdown-content">
                <form id="dateRangeForm" class="filter-form">
                    @include('crm.projects.partials.datefilterDropdown')
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
        <button class="filter-btn" id="Projectvalue" style="border-radius: 25px; padding:12px">Project Value</button>
        <div id="valueDropdown" class="dropdown-content" style="display: none;">
            <form id="projectValueForm" class="filter-form">
                <div class="form-group">
                    <label for="minValue">Minimum Value</label>
                    <input type="number" id="minValue" class="form-control" placeholder="Min value" step="1">
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
    <div class="table-wrapper shadow" style="margin:20px">
    <table class="task-progress-table table table-condensed">
        <thead>
            <th>{{ __('app.table_no') }}</th>
            <th>{{ __('job.name') }}</th>
            <th>{{ __('project.name') }}</th>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.6/flatpickr.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
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
                selectedOrganizations.push({
                    id: checkbox.value,
                    name: checkbox.nextElementSibling.textContent
                });
            });
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
            const selectedClauses = [];
            const checkboxes = document.querySelectorAll('#clausesForm input[type="checkbox"]:checked');
            checkboxes.forEach(checkbox => {
                selectedClauses.push(checkbox.name);
            });
            console.log('Selected Clauses:', selectedClauses);
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
@endsection
