@extends('dashboard.master')
@section('title', __('theme.notifications'))
@section('main-section')

    <div class="container-fluid">
        <h4 class="page-title">{{ __('theme.all_notifications') }}</h4>
        <div class="card">
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    @forelse($notifications as $notification)
                        <div class="border-top"
                             @if(!$notification->read_at) id="notificationRead-{{ $notification->id }}"
                             data-nid="{{ $notification->id }}"
                             data-ticketid="{{ $notification->data['ticket_id'] }}" @endif>
                            <a href="@if(!$notification->read_at) javascript:void(0) @else {{ route('ticket.show', $notification->data['ticket_id']) }} @endif">
                                <li class="list-group-item"
                                    @if(!$notification->read_at) style="background: aliceblue;"@endif>{{ $notification->data['title'] }}
                                    <br>
                                    <small>{{ __('theme.received_at') }}
                                        :{{ $notification->created_at->diffForHumans() }}</small>
                                </li>
                            </a>
                        </div>
                    @empty
                        <div class="border-top">
                            {{ __('theme.notification_empty') }}
                        </div>
                    @endforelse
                </ul>

                <div class="mt-3">
                    {{ $notifications->links() }}
                </div>
            </div>
        </div>
    </div>

@endsection
