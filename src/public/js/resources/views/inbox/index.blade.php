@inject('permission', 'App\Http\Controllers\PermissionController')
@extends('dashboard.master')
@section('title', __('theme.contact_message_inbox'))
@section('main-section')
    <div class="container-fluid">
        <h4 class="page-title">{{ __('theme.contact_message_inbox') }}</h4>
        <div class="row">
            <div class="col-md-12">
                @if($permission->manageInbox() == 1)
                <div class="card">
                    <div class="card-body">
                        <div class="card-header">
                            <div>{{ __('theme.contact_message_inbox') }}</div>
                        </div>
                        <table class="table mt-3">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">{{ __('theme.name') }}</th>
                                <th scope="col">{{ __('theme.phone') }}</th>
                                <th scope="col">{{ __('email') }}</th>
                                <th scope="col">{{ __('theme.date') }}</th>
                                <th scope="col">{{ __('theme.action') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($messages as $message)
                            <tr @if($message->status == 0) class="bg-light" @endif>
                                <td>{{ $loop->index+1 }}</td>
                                <td>{{ $message->name }}</td>
                                <td>
                                    <a href="{{ route('readMessage', $message->id) }}">
                                        {{ $message->phone }}
                                    </a>
                                </td>
                                <td>{{ $message->email }}</td>
                                <td>{{ $message->created_at->toDayDateTimeString() }}</td>
                                <td>
                                    <a href="{{ route('readMessage', $message->id) }}" class="badge badge-primary" title="View">{{ __('theme.view') }}</a>
                                    <form id="delete-form-{{ $message->id }}" method="post" action="{{ route('message.destroy', $message->id) }}" style="display: none">
                                                {{csrf_field()}}
                                                {{ method_field('DELETE') }}
                                    </form>
                                    <a href="" class="badge bg-danger text-white" onclick="
                                            if(confirm('Are you sure, You want to Delete this ??'))
                                            {
                                            event.preventDefault();
                                            document.getElementById('delete-form-{{ $message->id }}').submit();
                                            }
                                            else {
                                            event.preventDefault();
                                            }"><i class="fa fa-trash-o"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                                <td colspan="6" class="text-center">{{ __('theme.currently_no_messages_found') }}</td>
                            @endforelse
                            </tbody>
                        </table>
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