@extends('layouts.crm')

@section('script')
<!-- Include necessary scripts here -->
{{-- <script src="{{ asset('js/okr/avatar.js') }}" defer></script>
<script src="{{ asset('js/okr/tooltip.js') }}" defer></script>
<script src="{{ asset('js/okr/circle-progress.min.js') }}" defer></script>
<script src="{{ asset('js/okr/circleProgress.js') }}" defer></script>
<script src="{{ asset('js/okr/editbtn.js') }}" defer></script> --}}
{{-- Chartjs --}}
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js" charset="utf-8"></script>
<script src="{{ asset('js/kr/chart.js') }}" defer></script>
<script src="{{ asset('js/okr.js') }}" defer></script> --}}
@endsection

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.6/flatpickr.min.css">

@section('title','Objective')
@section('contents')
<div class="row align-items-center justify-content-between" style="margin: 40px;">
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
        <div class="row m-3 pt-4 justify-content-center">
            <div class="col-12 mb-2">
                <form action="{{ $company->getOKrRoute() }}" class="form-inline search-form w-100">
                    <input autocomplete="off" class="form-control input-sm w-25" name="st_date" id="filter_started_at" value="" placeholder="Start date">
                    <input autocomplete="off" class="form-control input-sm ml-md-2 w-25" name="fin_date" id="filter_finished_at" value="" placeholder="Settlement date">
                    <select name="order" class="form-control input-sm mr-md-2 ml-md-2 w-25">
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
