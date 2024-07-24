@extends('layouts.crm')
@section('title','Action')
@section('contents')
<div class="container">
    <div class="row mb-2">
        <div class="col">
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-10 col-12">
            {{-- edit --}}
            @can('update', $actions)
            <div class="row justify-content-end">
                <div class="col-auto">
                    <a class="text-info" href="#" onclick="document.getElementById('doneAct{{ $actions->id }}').submit()"><i class="fas fa-check-circle"></i> {{ $action->isdone?'Cancel':'Finish' }}</a>
                    <form method="POST" id="doneAct{{ $action->id }}" action="{{ route('actions.done',$action->id) }}">
                        @csrf
                    </form>
                </div>
                <div class="col-auto">
                    <a class="text-info" href="{{ route('actions.edit',$action->id) }}"><i class="fas fa-edit"></i> edit</a>
                </div>
                <div class="col-auto">
                    <a href="#" data-toggle="dropdown" class="text-info"><i class="fas fa-trash-alt"></i> delete</a>
                    <form method="POST" id="deleteAct{{ $action->id }}" action="{{ route('actions.destroy', $action->id) }}">
                        @csrf
                        {{ method_field('DELETE') }}
                        <div class="dropdown-menu u-padding-16">
                            <div class="row justify-content-center mb-2">
                                <div class="col-auto text-danger"><i class="fas fa-exclamation-triangle"></i></div>
                            </div>
                            <div class="row">
                                <div class="col text-center">
                                    Are you sure you want to take Action?<br>
                                </div>
                            </div>
                            <div class="row justify-content-center mt-3">
                                <div class="col text-center pr-0"><button class="btn btn-danger" type="submit">delete</button></div>
                                <div class="col text-center pl-0"><a class="btn btn-secondary text-white">Cancel</a></div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            @endcan
            {{-- kr --}}
            <div class="row">
                <div class="col-auto font-weight-bold text-muted align-self-center">
                    <div class="badge badge-pill pl-4 pr-4 text-white mr-2"  style="line-height: 18px; background-color:{{ $action->keyresult->color() }};">KR</div>
                    {{ $action->keyresult->title }}
                </div>
            </div>
            {{-- Action title --}}
            <div class="row mt-4 mb-4">
                <div class="col-auto">
                    <h4>{{ $action->title }}</h4>
                </div>
                <div class="col-auto text-right text-muted align-self-center">{{ $action->updated_at }}renew</div>
            </div>
            <div class="row mt-4 mb-4">
                <div class="col-auto align-self-center text-muted pr-md-4" style="line-height: 24px;">
                deadline｜
                    <i class="far fa-clock pr-2"></i>
                    {{ date('M. d, Y', strtotime($action->finished_at)) }}
                </div>
                <div class="col-auto align-self-center text-muted pl-md-4 pr-md-4" style="line-height: 24px;">
                person in charge｜
                    <a href="{{ route('user.okr', $action->user->id) }}" title="{{ $action->user->name }}">
                        <img src="{{ $action->user->getAvatar() }}" class="avatar-xs mr-1">
                        <span>{{ $action->user->name }}</span>
                    </a>
                </div>
                <div class="col-auto text-center align-self-center text-muted pl-md-4" style="line-height: 24px;">
                    priority｜
                    <div class="badge badge-pill badge-{{ $action->priority()->getResults()->color }} pl-4 pr-4">{{ $action->priority()->getResults()->priority }}</div>
                </div>
            </div>
            <hr/>
            <div class="row pl-md-4 pr-md-4">
                <div class="col-12">
                    <div>
                        <pre style="line-height: 28px;">{{$action->content}}</pre>
                    </div>
                </div>
            </div>
            @if(!empty($files))
            <div class="row justify-content-center pt-4 pb-4">
                <div class="col">
                    <i class="fas fa-paperclip text-muted pr-2"></i>
                    <label class="text-muted">appendix</label>
                    @foreach($files as $file)
                        <div class="row ml-3 mt-2">
                            <div class="col-auto">{{ $file['updated_at'] }}</div>
                            <div class="col-auto"><a href="{{ $file['url'] }}">{{ $file['name'] }}</a></div>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif
            <hr>
            <div class="row">
                <div class="col">
                    @comments(['model' => $action])
                    @endcomments
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
