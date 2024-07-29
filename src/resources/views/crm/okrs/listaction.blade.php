@foreach($okr['actions'] as $action)
    <div class="row mt-2">
        @if($action->isdone == null)
        <div class="col-auto align-self-center mb-3 pr-0">
            {{ $action->finished_at }}
            <span class="badge badge-pill badge-{{$action->priority()->getResults()->color}} ml-md-2 mr-md-2" style="width:100px">{{$action->priority()->getResults()->priority}}</span>
        </div>
        <div class="col align-self-center mb-3 ml-4" style="border-left: 5px solid {{ $action->keyresult->color()}}">
            <a href="{{ route('actions.showloneaction',$action->id) }}">{{ $action->title }}</a>
        </div>
        <div class="col-auto text-right align-self-center mb-sm-2 mb-4">
            <a href="{{ route('user.okr', $action->user->id) }}" title="{{$action->user->name}}" class="ml-4 mr-4 text-muted">
            <img src="storage/icon/green.png" style="width: 14px ; height: 14px;" class="avatar-xs mr-2">{{$action->user->name}}
               
            </a>
            <i class="fas fa-paperclip text-muted pr-2"></i> {{count($action->getRelatedFiles())}}
            
        </div>
        @endif
    </div>
@endforeach
