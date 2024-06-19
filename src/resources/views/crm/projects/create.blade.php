@extends('layouts.crm')

@section('title', trans('project.create'))

@section('contents')
<div class="page-header">
<ul class="breadcrumb hidden-print">
    <li><a href="{{ route('projects.index') }}" class="breadcrumb-item ">{{ trans('project.projects') }}</a></li>
    <li class="active create-project-title">{{ trans('project.create') }}</li>
</ul>
</div>

<div class="create_table row justify-center">
    <div class="col-md-6">
        {!! Form::open(['route' => 'projects.store']) !!}
        <div class="panel panel-default">
            
            <div class="panel-body">
                {!! FormField::text('name', ['label' => trans('project.name')]) !!}
                {!! FormField::select('organization_id', $Organization, ['placeholder' => __('Organization')]) !!}
                <div class="row">
                    <div class="col-md-6">
                        {!! FormField::text('customer_name') !!}
                    </div>
                    <div class="col-md-6">
                        {!! FormField::text('customer_email') !!}
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        {!! FormField::text('proposal_date', ['label' => trans('project.proposal_date')]) !!}
                    </div>
                    <div class="col-md-6">
                        {!! FormField::price('proposal_value', ['label' => trans('project.proposal_value'), 'currency' => Option::get('money_sign', 'Rp')]) !!}
                    </div>
                </div>
                {!! FormField::textarea('description', ['label' => trans('project.description')]) !!}
            </div>

            <div class="footer_btns panel-footer form-buttons">
                {!! Form::submit(trans('project.create'), ['class' => 'create-btn btn btn-primary btn-sm']) !!}
                {!! link_to_route('projects.index', trans('app.cancel'), [], ['class' => 'cancel-btn btn btn-default btn-sm']) !!}
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>
@endsection

@section('ext_css')
<link rel="stylesheet" href="{{ url('assets/css/plugins/jquery.datetimepicker.css') }}">
@endsection

@section('ext_js')
<script src="{{ url('assets/js/plugins/jquery.datetimepicker.js') }}"></script>
@endsection

@section('script')
<script>
(function() {
    $('#proposal_date').datetimepicker({
        timepicker: false,
        format: 'Y-m-d',
        closeOnDateSelect: true,
        scrollInput: false
    });
})();
</script>
@endsection
