<!-- Modal -->
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
                <!-- Login Form -->
                <form id="loginForm" method="POST" action="{{ route('users.login') }}">
                    @csrf
                    <div class="form-group">
                        <label for="email">{{ __('Email Address') }}</label>
                        <input type="email" name="email" class="form-control" id="email" placeholder="Enter your email" required>
                    </div>
                    <div class="form-group">
                        <label for="password">{{ __('Password') }}</label>
                        <input type="password" name="password" class="form-control" id="password" placeholder="Enter your password" required>
                    </div>
                    <div class="row">
                        <div class="col-6">
                        <p> Don't have an account? 
                        <a href="javascript:void(0);" data-toggle="modal" data-target="#registerModal">Apply</a>
                        </p>

                        </div>
                        <div class="col-6">
                        <p class="text-right"> <a href="javascript:void(0);" data-toggle="modal" data-target="#resetPasswordModal">Forgot password? </a></p>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-primary">Login</button>
                </form>

            </div>
        </div>
    </div>
</div>