<?php

namespace App\Http\Controllers\Core\Auth\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Core\Auth\User\LoginRequest as Request;
use App\Services\Core\Auth\UserService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\RedirectResponse;
use App\Hooks\User\CustomRoute;
use Illuminate\Testing\Fluent\Concerns\Debugging; // Include the Debugging trait
use Illuminate\Support\Stringable;
// use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Log;




class LoginController extends Controller
{


    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */




//    use  AuthenticatesUsers;
    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    public function show()
    {
        return env('APP_INSTALLED') ? view('auth.login') : redirect('install');
    }

    /**
     * @param Request $request
     * @return string
     */
    public function login(Request $request)
    {
        try {
            // Validate the request credentials
            $credentials = $request->only('email', 'password');

            // Attempt to authenticate the user
            if (Auth::attempt($credentials)) {
                // Regenerate session to prevent session fixation attacks
                $request->session()->regenerate();

                // Redirect to the intended page or home page after login
                return redirect()->intended(route('home'));
            } else {
                // If authentication fails, return back with an error message
                return redirect()->back()->withErrors([
                    'email' => 'Invalid credentials, please try again.',
                ]);
            }
        } catch (\Exception $exception) {
            // Handle exceptions, including ModelNotFoundException
            return redirect()->back()->withErrors([
                'message' => $exception instanceof ModelNotFoundException
                    ? trans('default.resource_not_found', ['resource' => trans('default.user')])
                    : $exception->getMessage(),
            ]);
        }
    }


    public function logOut(): RedirectResponse
    {
        session()->flush();
        auth()->logout();
        session()->flush();

        return redirect()->route('home');
    }
}
