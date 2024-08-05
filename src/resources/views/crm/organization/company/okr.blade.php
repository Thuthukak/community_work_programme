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
<div class="row align-items-center justify-content-between" style="margin: 60px;">
    <h4 class="header-pill col-auto">Objectives and Key Results</h4>
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
        <div class="row m-3 pt-4 justify-content-start" style="margin 20px;">
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
        flatpickr("#filter_started_at, #filter_finished_at, #st_date, #fin_date ,#started_at , #finished_at", {
            dateFormat: "Y-m-d",
            disableMobile: true // optional: to force the desktop version on mobile devices
        });
    });
</script>
@endsection
