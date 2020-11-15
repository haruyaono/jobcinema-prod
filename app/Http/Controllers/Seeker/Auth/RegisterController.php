<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\Profile;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Hashing\Hasher as Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Mail;
use App\Mail\RegisteredMail;

class RegisterController extends Controller
{
    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/members/register_complete';

    private $hash;

    public function __construct(Hash $hash)
    {
        $this->hash = $hash;
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
            'email' => ['required', 'string', 'email', 'max:191', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'max:191', 'confirmed'],
        ]);
    }

    protected function create(array $data)
    {

        $user = User::create([
            'email' => $data['email'],
            'password' => $this->hash->make($data['password'])
        ]);

        Profile::create([
            'user_id' => $user->id
        ]);

        Mail::to($user)->queue(new RegisteredMail($user));

        return $user;
    }

    public function complete()
    {
        return view('home');
    }
}
