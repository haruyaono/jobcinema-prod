<?php

namespace App\Http\Controllers\Seeker;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Job\Users\Repositories\UserRepository;
use App\Job\Profiles\Requests\UpdateUserProfileRequest;
use App\Job\Profiles\Requests\UpdateUserCareerRequest;
use App\Job\Profiles\Repositories\ProfileRepository;
use App\Job\Profiles\Repositories\Interfaces\ProfileRepositoryInterface;
use Illuminate\Support\Facades\DB;

class UserProfileController extends Controller
{
    /**
     * @var ProfileRepositoryInterface
     */
    private $profileRepo;

    private $user;

    /**
     * @param ProfileRepositoryInterface  $profileRepository
     */
    public function __construct(
        ProfileRepositoryInterface $profileRepository
    ) {
        $this->profileRepo = $profileRepository;

        $this->middleware(function ($request, $next) {
            $this->user = \Auth::user();

            return $next($request);
        });
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit()
    {
        $user = $this->user;
        $profile = $user->profile;
        $postcode = $user->profile->postcode ? explode("-", $user->profile->postcode) : [];

        return view('seeker.edit', compact('user', 'profile', 'postcode'));
    }

    /**
     * @param UpdateUserProfileRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateUserProfileRequest $request)
    {
        $user = $this->user;
        $uData = $request->input('data.user');
        $pData = $request->input('data.profile');

        $userRepo = new UserRepository($user);
        $profileRepo = new ProfileRepository($user->profile);

        $pData['postcode'] = $pData['postcode01'] && $pData['postcode02'] ? $pData['postcode01'] . "-" . $pData['postcode02'] : '';
        unset($pData['postcode01'], $pData['postcode02']);

        DB::beginTransaction();
        try {
            $profileRepo->updateProfile($pData);
            $userRepo->updateUser($uData);

            DB::commit();
        } catch (\PDOException $e) {
            DB::rollBack();
            return false;
        }

        return redirect()->back()->with('message', '会員情報を更新しました');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function editCareer()
    {
        $user = $this->user;
        $profile = $user->profile;
        return view('seeker.career_edit', compact('profile'));
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateCareer(UpdateUserCareerRequest $request)
    {
        $user = $this->user;
        $profile = $user->profile;
        $data = $request->input('data.profile');

        $profileRepo = new ProfileRepository($profile);
        $profileRepo->updateProfile($data);

        return redirect()->back()->with('message', '現在の状況・希望を更新しました');
    }
}
