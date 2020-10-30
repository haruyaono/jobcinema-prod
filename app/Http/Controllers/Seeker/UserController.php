<?php

namespace App\Http\Controllers\Seeker;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Job\Users\Repositories\UserRepository;
use App\Job\Users\Repositories\Interfaces\UserRepositoryInterface;
use App\Job\Profiles\Repositories\ProfileRepository;
use App\Job\JobItems\Repositories\Interfaces\JobItemRepositoryInterface;
use App\Job\Applies\Repositories\Interfaces\ApplyRepositoryInterface;
use App\Job\Users\Requests\UpdateUserPasswordRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * @var UserRepositoryInterface
     */
    private $userRepo;

    /**
     * @var JobItemRepositoryInterface
     */
    private $jobItemRepo;

    /**
     * @var ApplyRepositoryInterface
     */
    private $applyRepo;

    private $user;
    private $isLogin;

    /**
     * UserController constructor.
     * @param UserRepositoryInterface $userRepository
     * @param JobItemRepositoryInterface $jobItemRepository
     * @param ApplyRepositoryInterface $applyRepository
     */
    public function __construct(
        UserRepositoryInterface $userRepository,
        JobItemRepositoryInterface $jobItemRepository,
        ApplyRepositoryInterface $applyRepository
    ) {
        $this->userRepo = $userRepository;
        $this->jobItemRepo = $jobItemRepository;
        $this->applyRepo = $applyRepository;

        $this->middleware(function ($request, $next) {
            $this->user = \Auth::user();
            $this->isLogin = \Auth::check();

            return $next($request);
        });
    }

    public function index()
    {
        return view('seeker.index', compact('user'));
    }

    //mypage password change
    public function getChangePasswordForm()
    {
        return view('auth.passwords.changepassword');
    }

    public function postChangePassword(UpdateUserPasswordRequest $request)
    {

        $user = $this->user;
        $userRepo = new userRepository($user);
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

        $updated = $userRepo->updateUser($passData);

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

    //mypage email change
    public function getChangeEmail()
    {
        return view('auth.passwords.change_email');
    }

    public function postChangeEmail(Request $request)
    {
        $user = $this->user;
        $userRepo = new userRepository($user);

        $request->validate([
            'email' => 'required|email|string|max:191|unique:employers|unique:users',
        ]);

        $passData = [
            'email' => $request->get('email'),
        ];

        $updated = $userRepo->updateUser($passData);

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
        $user = $this->userRepo->findUserById(auth()->user()->id);
        $userRepo = new UserRepository($user);
        $profile = new ProfileRepository($user->profile);

        // $applies = $this->userRepo->findApplies($user);
        // $appliedJobItems = $this->userRepo->listAppliedJobItem($user);

        DB::beginTransaction();
        try {
            if ($user->profile->resume) {
                Storage::disk('public')->delete($user->profile->resume);
                Storage::disk('s3')->delete('resume/' . $user->profile->resume);
                $profile->updateProfile(['resume' => null]);
            }

            $profile->deleteProfile();
            $userRepo->deleteUser();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }

        return redirect()->to('/');
    }
}
