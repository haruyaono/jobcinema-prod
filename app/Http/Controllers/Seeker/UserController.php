<?php

namespace App\Http\Controllers\Seeker;

use App\Mail\Seeker\ApplyReport;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Seeker\UpdateUserPasswordRequest;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    private $user;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = \Auth::user();

            return $next($request);
        });
    }

    public function index()
    {
        return view('seeker.index', compact('user'));
    }

    public function getChangePasswordForm()
    {
        return view('auth.passwords.changepassword');
    }

    public function postChangePassword(UpdateUserPasswordRequest $request)
    {
        $user = $this->user;
        $msgData = [];

        //現在のパスワードが正しいかを調べる
        if (!(Hash::check($request->get('current-password'), $user->password))) {
            return redirect()->back()->with('change_password_error', '現在のパスワードが間違っています。');
        }

        //現在のパスワードと新しいパスワードが違っているかを調べる
        if (strcmp($request->get('current-password'), $request->get('new-password')) == 0) {
            return redirect()->back()->with('change_password_error', '新しいパスワードが現在のパスワードと同じです。違うパスワードを設定してください。');
        }

        $passData = [
            'password' => bcrypt($request->get('new-password')),
        ];

        $updated = $user->update($passData);

        if ($updated) {
            $msgData = [
                'change_password_success' => 'パスワードを変更しました。',
            ];
        } else {
            $msgData = [
                'change_password_error' => 'パスワードの変更に失敗しました。',
            ];
        }

        return redirect()->back()->with($msgData);
    }

    public function getChangeEmail()
    {
        return view('auth.passwords.change_email');
    }

    public function postChangeEmail(Request $request)
    {
        $user = $this->user;

        $request->validate([
            'email' => 'required|email|string|max:191|unique:users',
        ]);

        $passData = [
            'email' => $request->get('email'),
        ];

        $updated = $user->update($passData);

        if ($updated) {
            $msgData = [
                'change_email_success' => 'メールアドレスを変更しました。',
            ];
        } else {
            $msgData = [
                'change_email_error' => 'メールアドレスの変更に失敗しました。',
            ];
        }

        return redirect()->back()->with($msgData);
    }

    public function delete()
    {
        $user = $this->user;

        $user->applies->each(function ($apply) {
            if ($apply->s_recruit_status !== 8) {
                $apply->update(['s_recruit_status' => 8]);
                Mail::to($apply->jobitem->company->employer->email)->queue(new ApplyReport($apply));
            }
        });

        $user->delete();

        return redirect()->to('/');
    }
}
