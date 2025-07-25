<?php


namespace App\Services\Core\Auth;

use App\Exceptions\GeneralException;
use App\Helpers\Core\Traits\FileHandler;
use App\Helpers\Core\Traits\HasWhen;
use App\Helpers\Core\Traits\Helpers;
use App\Hooks\User\AfterLogin;
use App\Hooks\User\BeforeLogin;
use App\Models\Core\Auth\Role;
use App\Models\Core\Auth\User;
use App\Models\Core\Status;
use App\Repositories\Core\Setting\SettingRepository;
use App\Services\Core\Auth\Traits\HasUserActions;
use App\Services\Core\BaseService;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
// use Illuminate\Foundation\Auth\ThrottlesLogins;
// use Illuminate\Foundation\Auth\ThrottlesLogins;
use App\Models\ProjectManagement\Users\User as PMUser;


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


    public function attachRole()
    {
        if ((($this->model->isAppAdmin() && !auth()->user()->isAppAdmin()) || $this->model->id == auth()->id()) && !$this->model->isInvited())
            throw new GeneralException(trans('default.action_not_allowed'));

        $roles = $this->checkMakeArray(request('roles'));
        $this->model->roles()->sync(array_unique($roles));
        return $this->model;
    }

    public function detachRole()
    {
        if (($this->model->isAppAdmin() && !auth()->user()->isAppAdmin()) || $this->model->id == auth()->id())
            throw new GeneralException(trans('default.action_not_allowed'));

        $roles = $this->checkMakeArray(request('roles'));
        $this->model->roles()->detach($roles);
        $this->model->load('roles');
        return $this->model;
    }

    public function changeSetting($user = null)
    {
        $this->setModel($user ?? auth()->user());

        $this->attachSettings(
            request()->only('gender', 'date_of_birth', 'address', 'contact')
        );

        return true;
    }

    public function attachSettings($settings)
    {
        $settings_models = [];
        foreach ($settings as $key => $setting) {
            $setting_model = $this->model
                ->settings()
                ->firstOrNew([
                    'name' => $key,
                    'context' => 'user'
                ]);

            $setting_model->fill([
                'value' => $key == 'date_of_birth' ? Carbon::parse($setting)->format('Y-m-d') : $setting,
                'public' => 1
            ]);

            array_push($settings_models, $setting_model);
        }

        return $this->model
            ->settings()
            ->saveMany($settings_models);
    }

    public function storeThumbnail($user = null)
    {
        $user = $user ?? auth()->user();

        $this->deleteImage(optional($user->profilePicture)->path);

        $file_path = $this->uploadImage(
            request()->file('profile_picture'),
            config('file.profile_picture.folder'),
            config('file.profile_picture.height')
        );

        $user->profilePicture()->updateOrCreate([
            'type' => 'profile_picture'
        ], [
            'path' => $file_path
        ]);

        return $user->load('profilePicture');

    }


    public function login()
    {
        /**@var $user User*/
        $user = $this->model::findByEmail( request()->get('email') );

        BeforeLogin::new(true)
            ->setModel($user)
            ->handle();

        if (!$user->roles->count())
            throw new AuthenticationException(trans('default.no_roles_found'));

        if (Hash::check(request()->get('password'), optional($user)->password)) {
            auth()->login(
                $user,
                request()->get('remember_me',false)
            );

            AfterLogin::new(true)
                ->setModel($user)
                ->handle();


                Log::info($user);
                Log::info(session()->all());


            // Log in the PM user
            // $this->loginPMUser(request()->get('email'), request()->get('password'));

          


            return $user;
        }

        throw new AuthenticationException(
            trans('default.incorrect_user_password', [
                'password' => trans('default.password'),
                'email' => trans('default.email')
            ])
        );
    }

    protected function loginPMUser($email, $password)
    {
        $pmUser = PMUser::where('email', $email)->first();


        Log::info($pmUser);


        if ($pmUser && Hash::check($password, $pmUser->password)) {
            auth()->guard('pm')->login($pmUser);

                 // Manually generate the session for the PM user
        // session()->put('pm_user', $pmUser->id);
        session()->regenerate();

        Log::info(session()->all());


        } else {
            throw new AuthenticationException(
                trans('default.incorrect_user_password', [
                    'password' => trans('default.password'),
                    'email' => trans('default.email')
                ])
            );
        }


    }


    public function getFormattedSettings()
    {
        return resolve(SettingRepository::class)
            ->getFormattedSettings('user', User::class, auth()->id());
    }

    public function findAndCacheUser($id)
    {
        return cache()->remember('user-'.$id, 86400, function () use ($id) {
            return $this->select('id', 'first_name', 'last_name')->with('profilePicture')
                ->find($id);
        });
    }

    public function checkNoMoreAdmin() : bool
    {
        return User::allAdmin() <= 1;
    }


       /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        //
    }

     /**
     * Send the response after the user was authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();


        Log::info(session()->all());

        $this->clearLoginAttempts($request);

        flash(__('auth.welcome', ['name' => $request->user()->name]));

        return $this->authenticated($request, $this->guard()->user());   
     }
}
