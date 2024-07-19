@extends('layouts.crm')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.6/flatpickr.min.css">

@section('title','Objective')

@section('contents')
<div class="container">
    @include('crm.organization.company.show')

    <ul class="nav nav-tabs justify-content-center" id="myTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link" id="department-tab" href="{{ route('company.index') }}">Sub-department</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" id="okr-tab" data-toggle="tab" href="#okr" role="tab" aria-controls="okr"
                aria-selected="false">OKRs</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="member-tab" href="{{ route('company.member') }}">Member</a>
        </li>
    </ul>

    <div class="tab-pane fade show pl-sm-4 pr-sm-4">
        <div class="row m-3 pt-4 justify-content-center">
            <div class="col-auto">{{ $pageInfo['link'] }}</div>
            <div class="col-auto mb-2">
                <form action="{{ $company->getOKrRoute() }}" class="form-inline search-form">
                    <input autocomplete="off" class="form-control input-sm" name="st_date" id="filter_started_at" value=""
                        placeholder="Start date">
                    <input autocomplete="off" class="form-control input-sm ml-md-2" name="fin_date" id="filter_finished_at"
                        value="" placeholder="Settlement Date">
                    <select name="order" class="form-control input-sm mr-md-2 ml-md-2">
                        <option value="">Sort by</option>
                        <option value="started_at_asc">Start date, earliest to latest</option>
                        <option value="started_at_desc">Start date, latest to earliest</option>
                        <option value="finished_at_asc">Finish date, earliest to latest</option>
                        <option value="finished_at_desc">Finish date, latest to earliest</option>
                        <option value="updated_at_asc">Recently updated, earliest to lates</option>
                        <option value="updated_at_desc">Recently updated, latest to earliest</option>
                    </select>
                    <button class="btn btn-primary">Filter</button>
                </form>
            </div>
        </div>

        @if ($company->okrs && count($company->okrs) > 0)
            @foreach($company->okrs as $okr)
                @include('crm.okrs.okr', ['okr' => $okr, 'owner' => $company])
            @endforeach
        @else
            <div id="dragCard" class="row justify-content-md-center u-mt-16">
                <div class="alert alert-warning alert-dismissible fade show u-mt-32" role="alert">
                    <strong><i class="fas fa-exclamation-circle pl-2 pr-2"></i></strong>
                    No OKRs have been established for the current period!!
                </div>
            </div>
        @endif

        <!-- Button trigger modal -->
        <div class="position-fixed" style="top: 100px; right: 20px;">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#objective">
                <img alt="Add Objectve">
            </button>
        </div>

        <!-- Modal -->
        <div class="modal {{ count($errors) == 0 ? 'fade' : '' }}" id="objective" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">
                            <span>&times;</span>
                        </button>
                    </div>
                    @include('crm.okrs.create', ['route' => route('company.objective.store', $company->id)])
                </div>
            </div>
        </div>
        <!-- End Modal -->
    </div>
</div>
@endsection
