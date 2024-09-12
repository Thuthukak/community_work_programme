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



    public function RegisterPerson($data ){



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

          if($person)
          {
            $email = Email::create([
                'value' => $data['email'],
                'type_id' => 1,
                'contextable_type' => get_class($person),
                'contextable_id' => $person['id'],
            ]);
          }

          
          if($person && $email)
          {
            $phone = Phone::create([
                'value' => $data['cell_no'],
                'type_id' => 1,
                'contextable_type' => get_class($person),
                'contextable_id' => $person['id'],
            ]);
          }

          if($phone && $email)
          {
            $ticket = $this->createTicket($person);
          }

          if($ticket)
          {
            $applicant = $this->OnboardApplicant($data,$person);
          }
        }elseif($data['registration_type'] == 'cwp_candidate')
        {
     
        }elseif($data['registration_type'] == 'smart_partner')
        {



          $organization =  Organization::create([
                'name' => $data['company_name'],
                'address' => $data['business_address'],
                'contact_type_id' => 3,
                'created_by' => 1,
                'owner_id' => 1,
           
            ]);

            $contactPerson = Person::create([
                'name' => $data['contact_first_name'],
                'owner_id' => 1,
                'id_no' => $data['id_no'],
                'created_by' => 1,
                'contact_type_id' => 2,
                'created_by' => 0,
            ]);

            if($person)
            {
              $email = Email::create([
                  'value' => $data['email'],
                  'type_id' => 1,
                  'contextable_type' => get_class($person),
                  'contextable_id' => $person['id'],
              ]);
            }
  
            
            if($person && $email)
            {
              $phone = Phone::create([
                  'value' => $data['cell_no'],
                  'type_id' => 1,
                  'contextable_type' => get_class($person),
                  'contextable_id' => $person['id'],
              ]);
            }
  
            if($phone && $email)
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
        if($data['registration_type'] == 'smart_partner')
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

        return $deal;
     }


     public function CheckEmail($email = '')
     {
        $user = Email::where('value', '=', $email)->first();

        return $user;
     }
}