<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\Core\Auth\User;
use App\Http\Requests\Core\Auth\User\UserInvitationRequest;
use Illuminate\Http\Request;
use App\Http\Requests\Core\Auth\User\UserInvitationRequest as InvitationRequest;
use App\Http\Controllers\Core\Auth\UserInvitationController;
use App\Services\Core\Auth\RegistrationService;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use DB;

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
    protected $Userinvite;
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
    public function __construct(RegistrationService $RegistrationService ,UserInvitationController $UserInvitation)
    {
        $this->middleware('guest');
        $this->registerService = $RegistrationService;
        $this->Userinvite = $UserInvitation;

    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $rules = [
            'registration_type' => 'required|string',
        ];
    
        // Validation for new_applicant
        if (isset($data['registration_type']) && $data['registration_type'] === 'new_applicant') {
            $rules = array_merge($rules, [
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'cell_no' => 'required|numeric|digits:10|unique:phones,value',
                'id_no' => 'required|numeric|digits:13|unique:custom_field_values,value',
            ]);
        }
    
        // Validation for cwp_candidate
        if (isset($data['registration_type']) && $data['registration_type'] === 'cwp_candidate') {
            $rules = array_merge($rules, [
                'cwp_email' => 'required|email|exists:users,email',
                'cwp_cell_no' => 'required|numeric|digits:10|exists:phones,value',
                'cwp_id_no' => 'required|numeric|digits:13|exists:custom_field_values,value',
                'cwp_no' => 'required|numeric|exists:custom_field_values,value',
            ]);
        }
    
    
        // Validation for smart_partner
        if (isset($data['registration_type']) && $data['registration_type'] === 'smart_partner') {
            $rules = array_merge($rules, [
                'company_name' => 'required|string|max:255',
                'business_registration_number' => 'required|string|max:255|unique:custom_field_values,value',
                'business_address' => 'required|string|max:255',
                'website_url' => 'required|url|unique:custom_field_values,value',
                'partner_email' => 'required|email|unique:emails,value',
                'partner_cell_no' => 'required|numeric|digits:10|unique:phones,value',
                'areas_of_expertise.*' => 'required|string',
            ]);


           
        }

         // Add conditional validation for contact person fields
         if (!empty($data['contact_first_name']) || !empty($data['contact_last_name']) || !empty($data['contact_cell_no']) || !empty($data['contact_email'])) {
            $rules = array_merge($rules, [
                'contact_first_name' => 'required|string|max:255',
                'contact_last_name' => 'required|string|max:255',
                'contact_cell_no' => 'required|numeric|digits:10|unique:phones,value',
                'contact_email' => 'required|email|unique:emails,value',
            ]);
        }
    
                // Perform validation
                $validator = Validator::make($data, $rules);
                // Log errors if validation fails
                if (!$validator) {
                    return response()->json([
                        'errors' => $validator->errors()
                    ], 422);
                }else {
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
    protected function create(Request $request ,array $data )
    {


        if($data['registration_type'] == 'new_applicant') {
            // Merge first_name and last_name into the name field
            $data = array_merge($data, [
                'name' => $data['first_name'] . ' ' . $data['last_name'], // Append first name and last name
                'owner_id' => 1,
            ]);
            // dd($data);

            $user = $this->registerService->RegisterPerson($data);

        
            // Remove first_name and last_name from the array
            unset($data['first_name'], $data['last_name']);
            // dd($data);

            return $user;
    
            }elseif($data['registration_type'] == 'cwp_candidate')
            {




              // Extract the email from the original $request
            $invitationData = $request->only('email');

            // Append the 'roles' attribute with the value 'client'
            $invitationData['roles'] = ['client'];

            // Create a new instance of UserInvitationRequest
            $NewinvitationRequest = new UserInvitationRequest();

            // Merge the extracted and modified data into the new UserInvitationRequest instance
            $invitationRequest = $NewinvitationRequest->merge($invitationData);

            // Handle the invitation
            $userInvite = $this->Userinvite->invite($invitationRequest);
                    
        

            //    dd($user);
                return $userInvite;
            }elseif($data['registration_type'] == 'smart_partner')
            {

               $SmartPartner = $this->registerService ->RegisterSmartPartner($data);

                return $SmartPartner;
       
            }
            

    }

   
}
