<div class="row justify-content-center">
    <div class="col-sm-6">
        <div class="alert alert-info" role="alert">
            Please complete <span class="alert-link">"{{ $invitation->model->title }}"</span> Task section
            <a href="{{ route('actions.member.invite.agree', [$invitation->model, auth()->user()->id]) }}" class="btn btn-primary">join in</a>
            <a href="{{ route('actions.member.invite.reject', [$invitation->model, auth()->user()->id]) }}" class="btn btn-danger">reject</a>
        </div>
    </div>
</div>
