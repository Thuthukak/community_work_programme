<?php

namespace App\Http\Controllers\Core\Auth;

use App\Models\Core\Auth\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    public function redirectTo()
    {
        if (auth()->user()->is_admin || auth()->user()->user_type) {
            return '/dashboard';
        } else {
            return '/';
        }
    }

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */

    //protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
     protected function validator(array $data)
        {
            // Define the base validation rules
            $rules = [
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'cell_no' => ['required', 'numeric', 'digits_between:10,12'],
                'id_no' => ['required', 'numeric', 'digits:13'],
                'email' => 'required|string|email|max:255|unique:users',
                'register-password' => 'required|string|min:6|confirmed',
            ];
        
            // Check for registration_type and add or remove rules accordingly
            if (isset($data['registration_type'])) {
                if ($data['registration_type'] === 'cwp_candidate') {
                    $rules['cwp_no'] = 'required|numeric';
                }
        
                if ($data['registration_type'] === 'smart_partner') {
                    // Remove first_name and last_name fields from the rules
                    unset($rules['first_name'], $rules['last_name']);
        
                    // Add rules specific to smart_partner
                    $rules = array_merge($rules, [
                        'company_name' => 'required|string|max:255',
                        'type_of_company' => 'required|string',
                        'industry_sector' => 'required|string',
                        'date_of_establishment' => 'required|date',
                        'business_registration_number' => 'required|string|max:255',
                        'business_address' => 'required|string|max:255',
                        'website_url' => 'required|url',
                        'areas_of_expertise' => 'required|array',
                        'description_of_services' => 'required|string|max:1000',
                    ]);
                }
            }
        
            // Perform validation
            $validator = Validator::make($data, $rules);
            // Log errors if validation fails
            if ($validator->fails()) {
                \Log::info('Validation errors:', $validator->errors()->toArray());
            } else {
                // dd('$validator->errors()->toArray()');

                \Log::info('Validation Successful');
            }
        
            // Return the validator instance
            return $validator;
        }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {

        return User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'cell_no' => $data['cell_no'],
            'cwp_no' => $data['cwp_no'],
            'email' => $data['email'],
            'register-password' => Hash::make($data['register-password']),
        ]);
    }
}
