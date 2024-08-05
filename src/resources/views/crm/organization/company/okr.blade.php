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
@section('title','Objective')
@section('contents')
<div class="container">
    @include('crm.organization.company.show')
    <div class="tab-pane fade show pl-sm-4 pr-sm-4">
        <div class="filters">
        <div class="filter-item">
            <button class="filter-btn" style="border-radius: 25px; padding:12px" id="datefilter">Date Range</button>
            <div id="dateDropdown" class="dropdown-content">
                <form id="dateRangeForm" class="filter-form">
                    @include('crm.organization.company.partials.datefilter')
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
  <div class="position-fixed" style="top: 100px; right: 50px;">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#objective">
                <img src="{{ asset('img/icon/add/lightgreen.svg') }}" alt="Add Objective">
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
            var actionOn = this.value;
            // Make sure actionOn is not empty
            if (actionOn) {
                fetchModels(actionOn);
            }
        });

        function fetchModels(actionOn) {
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
                        modelSelect.innerHTML += `<option value="${model.id}">${model.name}</option>`;
                    });

                    let lastModel = data.models.filter(model => typeof model === 'object').pop();
                if (lastModel) {
                    document.querySelector('#full_model_type').value = lastModel.model;
                    console.log(document.querySelector('#full_model_type').value);
                } else {
                    console.error('No valid model object found');
                }
                } else {
                    console.error('Element with id "model_id" not found');
                }


            })
            .catch(error => {
                console.error('Error fetching models:', error);
            });
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
        });
</script>
@endsection
