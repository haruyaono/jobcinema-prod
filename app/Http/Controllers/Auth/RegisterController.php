<?php

namespace App\Http\Controllers\Auth;

use App\Job\Users\User;
use App\Job\Users\Repositories\Interfaces\UserRepositoryInterface;
use App\Job\Profiles\Repositories\Interfaces\ProfileRepositoryInterface;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Mail;
use App\Mail\RegisteredMail;
use Illuminate\Support\Facades\Auth;

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
    protected $redirectTo = '/members/register_complete';

    private $userRepo;
    private $profileRepo;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        UserRepositoryInterface $userRepository,
        ProfileRepositoryInterface $profileRepository
    ) {
        $this->middleware('guest');
        $this->userRepo = $userRepository;
        $this->profileRepo = $profileRepository;
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'email' => ['required', 'string', 'email', 'max:191', 'unique:users', 'unique:employers'],
            'password' => ['required', 'string', 'min:8', 'max:191', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return User
     */
    protected function create(array $data)
    {
        $user = $this->userRepo->createUser($data);
        $this->profileRepo->createProfile(['user_id' => $user->id]);

        //メールを非同期に送信するため、send から queueに変更
        Mail::to($user)->queue(new RegisteredMail($user));

        return $user;
    }
}
