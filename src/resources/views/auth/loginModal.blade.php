<!-- Login Modal -->
<div class=" modal fade" id="loginModal"role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true" style="z-index: 1041;" >
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="loginModalLabel">{{ __('theme.login') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('users.login') }}">
                    @csrf
                    <div class="form-group">
                        <input type="email" class="form-control" id="login-email" name="email" required placeholder= "Username" autocomplete="Username">
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" id="login-password" name="login-password" required autocomplete="current-password" placeholder="Password">
                    </div>
                    <button type="submit" class="btn btn-primary">{{ __('theme.login') }}</button>
                </form>
            </div>

            <div id="formFooter">
                   <div>
                   <a class="nav-link" href="javascript:void(0);" data-toggle="modal" data-target="#resetPasswordModal">{{ __("theme.forgot_your_password") }}</a>
                   </div>
                    <div>
                        {{ __("theme.don't_have_account") }}
                        <a class="nav-link" href="javascript:void(0);" data-toggle="modal" data-target="#registerModal">{{ __('theme.register') }}</a>
                        </div>
                </div>
        </div>
    </div>
</div>

