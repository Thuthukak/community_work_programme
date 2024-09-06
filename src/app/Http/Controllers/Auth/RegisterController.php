<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\Core\Auth\User;
use App\Models\CRM\Ticket\Ticket;
use App\Http\Controllers\CRM\Deal\DealController;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

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
            // dd($data);
            // Define the base validation rules
            $rules = [
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'cell_no' => ['required', 'numeric', 'digits_between:10,12'],
                'id_no' => ['required', 'numeric', 'digits:13'],
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:6|confirmed',  // Change this to 'password'
            ];
            
            // Check for registration_type and add or remove rules accordingly
            if (isset($data['registration_type'])) {
                if ($data['registration_type'] === 'cwp_candidate') {
                    $rules['cwp_no'] = 'required|numeric';
                }
        
                if ($data['registration_type'] === 'smart_partner') {
                    // Remove first_name and last_name fields from the rules
                    unset($rules['first_name'], $rules['last_name'], $rules['id_no']);
        
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
     * Create registering intances of a Ticket and Onboard them into a pipeline
     *  Also Assign a CWP Employee to their application 
     */

     public function OnboardApplicants($user)
     {

     }
    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {

            dd($data);
       
            if($data['registration_type'] == 'new_applicant')
            {
                return User::create([
                    'first_name' => $data['first_name'],
                    'last_name' => $data['last_name'],
                    'cell_no' => $data['cell_no'],
                    'id_no' => $data['id_no'],
                    'status_id' => 3,
                    'email' => $data['email'],
                    'password' => Hash::make($data['password']),
                ]);

            }elseif($data['registration_type'] == 'cwp_candidate')
            {
                return User::create([
                    'first_name' => $data['first_name'],
                    'last_name' => $data['last_name'],
                    'cell_no' => $data['cell_no'],
                    'id_no' => $data['id_no'],
                    'cwp_no' => $data['cwp_no'],
                    'status_id' => 1,
                    'email' => $data['email'],
                    'password' => Hash::make($data['password']),
                ]);
            }elseif($data['registration_type'] == 'smart_partner')
            {
                return User::create([
                    'first_name' => $data['first_name'],
                    'last_name' => $data['last_name'],
                    'cell_no' => $data['cell_no'],
                    'id_no' => $data['id_no'],
                    'cwp_no' => $data['cwp_no'],
                    'status_id' => 1,
                    'email' => $data['email'],
                    'password' => Hash::make($data['password']),
                ]);
            }
            

    }
}
