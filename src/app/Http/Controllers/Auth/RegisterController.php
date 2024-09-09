<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\Core\Auth\User;

use App\Services\Core\Auth\RegistrationService;
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
    /**
     * properties for registering a application
     */
    protected $person;
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
    public function __construct(RegistrationService $RegistrationService)
    {
        $this->middleware('guest');
        $this->registerService = $RegistrationService;

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
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {


        if($data['registration_type'] == 'new_applicant') {
            // Merge first_name and last_name into the name field
            $data = array_merge($data, [
                'name' => $data['first_name'] . ' ' . $data['last_name'], // Append first name and last name
                'owner_id' => 1,
            ]);
            // dd($data);

            $this->registerService->RegisterPerson($data);

        
            // Remove first_name and last_name from the array
            unset($data['first_name'], $data['last_name']);
            // dd($data);

            return $user;
    
            }elseif($data['registration_type'] == 'cwp_candidate')
            {
                return $user;
            }elseif($data['registration_type'] == 'smart_partner')
            {
                return $user;
       
            }
            

    }

   
}
