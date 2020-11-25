<?php

namespace App\Http\Controllers\Seeker;

use App\Http\Controllers\Controller;
use App\Http\Requests\Seeker\UpdateUserProfileRequest;
use App\Http\Requests\Seeker\UpdateUserCareerRequest;
use Illuminate\Support\Facades\DB;

class UserProfileController extends Controller
{
    private $user;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = \Auth::guard('seeker')->user();
            return $next($request);
        });
    }

    public function edit()
    {
        $user = $this->user;
        $profile = $user->profile;
        $postcode = $user->profile->postcode ? explode("-", $user->profile->postcode) : [];

        return view('seeker.edit', compact('user', 'profile', 'postcode'));
    }

    public function update(UpdateUserProfileRequest $request)
    {
        $user = $this->user;
        $uData = $request->input('data.user');
        $pData = $request->input('data.profile');

        $pData['postcode'] = $pData['postcode01'] && $pData['postcode02'] ? $pData['postcode01'] . "-" . $pData['postcode02'] : '';
        unset($pData['postcode01'], $pData['postcode02']);

        DB::beginTransaction();
        try {
            $user->update($uData);
            $user->profile->update($pData);

            DB::commit();
        } catch (\PDOException $e) {
            DB::rollBack();
            return false;
        }

        return redirect()->back()->with('message', '会員情報を更新しました');
    }

    public function editCareer()
    {
        $user = $this->user;
        $profile = $user->profile;
        return view('seeker.career_edit', compact('profile'));
    }

    public function updateCareer(UpdateUserCareerRequest $request)
    {
        $user = $this->user;
        $data = $request->input('data.profile');

        $user->profile->update($data);

        return redirect()->back()->with('message', '現在の状況・希望を更新しました');
    }
}
