<!-- Login Modal -->
<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="loginModalLabel">Login</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="loginForm" method="POST" action="{{ route('users.login') }}">
                    @csrf
                    <div class="form-group">
                        <label for="email">{{ __('Email Address') }}</label>
                        <input type="email" name="email" class="form-control" id="email" placeholder="{{ __('theme.email') }}" required>
                    </div>
                    <div class="form-group">
                        <label for="password">{{ __('Password') }}</label>
                        <input type="password" name="password" class="form-control" id="password" placeholder="{{ __('theme.password') }}" required>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <p> Don't have an account? 
                                <!-- Apply link triggers Register Modal -->
                                <a href="#" data-toggle="modal" data-target="#registerModal" data-dismiss="modal">Apply</a>
                            </p>
                        </div>
                        <div class="col-6">
                            <p class="text-right">
                                <!-- Forgot password link triggers Reset Password Modal -->
                                <a href="#" data-toggle="modal" data-target="#resetPasswordModal" data-dismiss="modal">Forgot password?</a>
                            </p>
                        </div>
                    </div>
                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-primary">Login</button>
                </form>
            </div>
        </div>
    </div>
</div>
