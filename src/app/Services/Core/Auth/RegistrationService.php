<?php


namespace App\Services\Core\Auth;

use App\Exceptions\GeneralException;
use App\Helpers\Core\Traits\FileHandler;
use App\Helpers\Core\Traits\HasWhen;
use App\Helpers\Core\Traits\Helpers;
use App\Hooks\User\AfterLogin;
use App\Hooks\User\BeforeLogin;
use App\Models\Core\Auth\Role;
use App\Models\CRM\Ticket\Ticket;
use App\Http\Controllers\CRM\Deal\DealController;
use App\Models\CRM\Person\Person;
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



class UserService extends BaseService
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

    public function RegisterPerson($data){


        if($data['registration_type'] == 'cwp_candidate')
        {

         // Store the updated data
         $person = Person::create([
            'name' => $data['first_name'],
            'owner_id' => $data['last_name'],
            'cell_no' => $data['cell_no'],
            'id_no' => $data['id_no'],
            'cwp_no' => $data['cwp_no'],
            'status_id' => 1,
            'email' => $data['email'],
        ]);
          if($person)
          {
            $contactType = ContactType::create([
                'value' => $data['phone_no'],
                'type_id' => $data['last_name'],
                'contextable_type' => $data['cell_no'],
                'contextable_id' => $data['id_no'],
            ]);
          }

          if($person & $contactType)
          {
            $contactType = PhoneEmailType::create([
                'value' => $data['phone_no'],
                'type_id' => $data['last_name'],
                'contextable_type' => $data['cell_no'],
                'contextable_id' => $data['id_no'],
            ]);
          }

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
    
    public function createTicket($user){

    }

     /**
     * Create registering intances of a Ticket and Onboard them into a pipeline
     *  Also Assign a CWP Employee to their application 
     */

     public function OnboardApplicants($applicant)
     {

     }

}