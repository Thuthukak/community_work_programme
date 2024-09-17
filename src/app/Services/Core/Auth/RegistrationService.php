<?php


namespace App\Services\Core\Auth;

use App\Exceptions\GeneralException;
use App\Helpers\Core\Traits\FileHandler;
use App\Helpers\Core\Traits\HasWhen;
use App\Helpers\Core\Traits\Helpers;
use App\Hooks\User\AfterLogin;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use App\Hooks\User\BeforeLogin;
use App\Models\Core\Auth\Role;
use App\Models\CRM\Ticket\Ticket;
use App\Models\CRM\Deal\Deal;
use App\Http\Controllers\CRM\Deal\DealController;
use App\Models\CRM\Person\Person;
use App\Models\CRM\Organization\Organization;
use App\Http\Controllers\CRM\Contact\OrganizationController;
use App\Filters\CRM\OrganizationFilter;
use App\Services\CRM\Contact\OrganizationService;
use App\Http\Requests\CRM\Organization\OrganizationRequest;
use App\Models\CRM\Email\Email;
use App\Models\CRM\Phone\Phone;
use App\Models\Core\Builder\Form\CustomFieldValue;
use App\Models\Core\Builder\Form\CustomField;
use App\Models\CRM\Contact\ContactType;
use App\Models\CRM\Contact\PhoneEmailType;
use App\Models\Core\Auth\User;
use App\Models\Core\Status;
use App\Repositories\Core\Setting\SettingRepository;
use App\Services\Core\Auth\Traits\HasUserActions;
use App\Services\Core\BaseService;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use DB;



class RegistrationService extends BaseService
{
    use FileHandler, Helpers, HasWhen, HasUserActions;
        //  ThrottlesLogins;

    protected $role;

    public function __construct(User $user, Role $role)
    {
        $this->model = $user;
        $this->role = $role;
    }

    public function create()
    {
        $status = Status::findByNameAndType('status_active', 'user')->id;

        parent::save($this->getFillAble(array_merge(request()->only(
            'first_name',
            'last_name',
            'email',
            'password'
        ), ['status_id' => $status])));

        return $this;
    }


    public function update()
    {
        $this->model->fill($this->getFillAble(request()->only('first_name', 'last_name', 'status_id')));

        throw_if(
            // at least 2 admin user should present to remove one.
            $this->model->isDirty('status_id') && (($this->model->isAppAdmin() && $this->checkNoMoreAdmin()) || $this->model->id == auth()->id()),
            new GeneralException(trans('default.action_not_allowed'))
        );

        $this->when($this->model->isDirty(), function (UserService $service) {
            $service->notify('user_updated');
        });

        $this->model->save();

        $this->when(request()->get('roles'), function (UserService $service) {
            $service->assignRole(request()->get('roles'));
        });

        return $this->model;
    }

    public function assignRole($roles)
    {
        $this->model->assignRole($roles);

        return $this;
    }

    public function delete(User $user)
    {
        if (($user->isAppAdmin() && $this->checkNoMoreAdmin()) && !$user->isInvited())
            throw new GeneralException(trans('default.action_not_allowed'));

        if ($user->id == auth()->id())
            throw new GeneralException(trans('default.cant_delete_own_account'));

        return $user->delete();
    }



    public function RegisterPerson($data )
    {



        if($data['registration_type'] == 'new_applicant')
        {

         // Store the updated data
         $person = Person::create([
            'name' => $data['name'],
            'owner_id' => 1,
            'id_no' => $data['id_no'],
            'created_by' => 1,
            'contact_type_id' => 2,
            'created_by' => 0,
        ]);

        if($person){
            $customfield = CustomFieldValue::create([
                'value' =>$data['id_no'],
                'contextable_type' => get_class($person),
                'contextable_id' => $person['id'],
                'custom_field_id' => 2,
            ]);  
        }

        if ($person) {
            // Use the polymorphic relationship method to create the email
            $person->emails()->create([
                'value' => $data['email'],
                'type_id' => 1,
            ]);
        
            // Use the polymorphic relationship method to create the phone
            $person->phones()->create([
                'value' => $data['cell_no'],
                'type_id' => 1,
            ]);
        }

          if($person)
          {
            $ticket = $this->createTicket($person);
          }

          if($ticket)
          {
            $applicant = $this->OnboardApplicant($data,$person);
          }
        }
    }

    public function RegisterSmartPartner($data)
    {

        DB::enableQueryLog(); // Enable query log

        if($data['registration_type'] == 'smart_partner')
        {

            $contactPerson = Person::create([
                'name' => $data['contact_first_name'] . '' . $data['contact_last_name'],
                'owner_id' => 1,
                'created_by' => 1,
                'contact_type_id' =>3,
                'created_by' =>1 ,
            ]);

        //     $Orgmodel  = new Organization();
        //     $organizationService = new OrganizationService($Orgmodel);

        //     $organizationFilter = new OrganizationFilter();
        //   $organization =  new OrganizationController($organizationService,$organizationFilter);

        //     $NewOrganizationRequest = new OrganizationRequest();


        //     $data = array_merge($data, [
        //         'name' => $data['company_name'] 
        //     ]);

        //     // dd($data);



        //     $OrganizationRequest = $NewOrganizationRequest->merge($data);


            // dd($OrganizationRequest->all());
        // $Organization = $organization->store($OrganizationRequest);
          
         
            if($contactPerson){
                $organization =  Organization::create([
                    'name' => $data['company_name'],
                    'address' => $data['business_address'],
                    'contact_type_id' => 3,
                    'created_by' => 1,
                    'owner_id' => 1,
                ]);
            }

            $customFields = [
                'website_url' => 3, 
                'business_registration_number' => 4, 
                'industry_sector' => 5, 
                'areas_of_expertise' => 6,
            ];


            foreach ($customFields as $field => $customFieldId) {
                    // If the field is an array (like areas_of_expertise), handle it separately
                    if (is_array($data[$field])) {
                        foreach ($data[$field] as $value) {
                            CustomFieldValue::create([
                                'value' => $value,
                                'contextable_type' => get_class($organization),
                                'contextable_id' => $organization->id,
                                'custom_field_id' => $customFieldId,
                            ]);
                        }
                    } else {
                        CustomFieldValue::create([
                            'value' => $data[$field],
                            'contextable_type' => get_class($organization),
                            'contextable_id' => $organization->id,
                            'custom_field_id' => $customFieldId,
                        ]);
                    }
                }
            if($organization)
            {
                $organization->emails()->create([
                    'value' => $data['partner_email'],
                    'type_id' => 3,
                  
                ]);
                $organization->phones()->create([
                    'value' => $data['partner_cell_no'],
                    'type_id' => 1,
                ]);
            }          
             if ($contactPerson) {
                // Use the polymorphic relationship method to create the email
                $contactPerson->emails()->create([
                    'value' => $data['contact_email'],
                    'type_id' => 1,
                ]);
            
                // Use the polymorphic relationship method to create the phone
                $contactPerson->phones()->create([
                    'value' => $data['contact_cell_no'],
                    'type_id' => 1,
                ]);
            }
            if($contactPerson && $contactPerson)
            {
              $ticket = $this->createTicket($organization);

            }
            if($ticket)
            {
              $applicant = $this->OnboardApplicant($data,$organization);

            }
            return $organization;
        }
    }
    
    public function createTicket($user)
    {
        $ticket = Ticket::create([
            'user_id' => 1,
            'company_id' => 1,
            'ticket_id' => strtoupper(Str::random(10)),
            'title' => "New Applicant",
            'status' => "pending",
            'priority' => "Normal",
            'message' => "This is a new Application for :".$user['name'],
        ]);

        return $ticket;
    }

     /**
     * Create registering intances of a Ticket and Onboard them into a pipeline
     *  Also Assign a CWP Employee to their application 
     */

     public function OnboardApplicant($applicant, $person)
     {

        if($applicant['registration_type'] == 'smart_partner'){
            $deal = Deal::create([
                'title' => $applicant['company_name'],
                'value' => 1,
                'pipeline_id' => 2,
                'stage_id' => 8,
                'contextable_type' => get_class($person),
                'contextable_id' => $person['id'],
                'lost_reason_id' => null,
                'status_id' => 13,
                'created_by' => 1,
                'owner_id' => 1,
    
            ]);

        }else{
            $deal = Deal::create([
                'title' => $applicant['name'],
                'value' => 1,
                'pipeline_id' => 2,
                'stage_id' => 8,
                'contextable_type' => get_class($person),
                'contextable_id' => $person['id'],
                'lost_reason_id' => null,
                'status_id' => 13,
                'created_by' => 1,
                'owner_id' => 1,
    
            ]);
        }
        

        return $deal;
     }


    }