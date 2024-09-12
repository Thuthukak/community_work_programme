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
                    <button type="submit" class="btn btn-primary">Login</button>
                </form>

            </div>
        </div>
    </div>
</div>


<script>

$(document).on('submit', '#loginForm', function (e) {
    e.preventDefault();

    var formData = $(this).serialize();

    $.ajax({
        type: 'POST',
        url: '{{ route("users.login") }}',
        data: formData,
        success: function (response) {
            // Handle success (e.g., redirect or close modal)
            $('#loginModal').modal('hide');
            location.reload();
        },
        error: function (xhr) {
            var errors = xhr.responseJSON.errors;
            // Clear previous errors
            $('.invalid-feedback').remove();
            $('.form-control').removeClass('is-invalid');

            // Loop through the errors and show them in the form
            $.each(errors, function (key, value) {
                var input = $('[name=' + key + ']');
                input.addClass('is-invalid');
                input.after('<div class="invalid-feedback">' + value[0] + '</div>');
            });
        }
    });
});

    </script>