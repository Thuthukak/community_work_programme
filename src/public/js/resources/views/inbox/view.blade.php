@inject('permission', 'App\Http\Controllers\PermissionController')
@extends('dashboard.master')
@section('title', __('theme.view_contact_message'))
@section('main-section')

    <div class="container-fluid">
        <h4 class="page-title">{{ __('theme.view_contact_message') }}</h4>
        <div class="row">
            <div class="col-md-12">
                @if($permission->manageInbox() == 1)
                <div class="card">
                    <div class="card-body">
                        <div class="card-header">
                            <div class="page-title">{{ __('theme.view_contact_message') }}</div>
                        </div>
                        <div class="">
                            <p>{{ __('theme.name') }}: {{ $contact->name }}</p>
                            <p>{{ __('theme.phone') }}: {{ $contact->phone }}</p>
                            <p>{{ __('theme.email') }}: {{ $contact->email }}</p>
                            <p>{{ __('theme.message_at') }}: {{ $contact->created_at->toDayDateTimeString() }}</p>
                            <p>{{ __('theme.message') }}:<br>
                                {{ $contact->message }}
                            </p>
                        </div>
                    </div>
                    <div class="card-footer">

                    </div>
                </div>
                @else
                    <div class="callout callout-warning">
                        <h4>{{ __('theme.access_denied') }}</h4>

                        <p>{{ __("theme.don't_have_permission") }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection