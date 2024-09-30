<div class="row justify-content-center">
    <div class="col-sm-8">
        <div class="alert alert-info" role="alert">
        Invite you to join <span class="alert-link">"{{ $invitation->model->name }}"</span> Organization！！
            <a href="{{ route('company.member.invite.agree', [$invitation->model, auth()->user()->id]) }}" class="btn btn-primary">Add</a>
            <a href="{{ route('company.member.invite.reject', [$invitation->model, auth()->user()->id]) }}" class="btn btn-danger">Reject</a>
        </div>
    </div>
</div>
