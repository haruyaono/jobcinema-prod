<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Job\Users\Repositories\UserRepository;
use App\Job\Profiles\Requests\UpdateUserProfileRequest;
use App\Job\Profiles\Repositories\ProfileRepository;
use App\Job\Profiles\Repositories\Interfaces\ProfileRepositoryInterface;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserProfileController extends Controller
{
    /**
     * @var ProfileRepositoryInterface
     */
    private $profileRepo;

    /**
     * @param ProfileRepositoryInterface  $profileRepository
     */
    public function __construct(
        ProfileRepositoryInterface $profileRepository
    ) {
        $this->profileRepo = $profileRepository;
    }


    /**
     * @param CreateProfileRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CreateProfileRequest $request)
    {
        $request['user_id'] = auth()->user()->id;

        $this->profileRepo->createAddress($request->except('_token', '_method'));

        if($request->zip31 && $request->zip32) {
            $request['postcode'] = $request->zip31."-".$request->zip32;
        } else {
            $request['postcode']  = '';
        }

        DB::beginTransaction();

        try {
            Profile::where('user_id', $user->id)->update([

                'phone1' => request('phone1'),
                'phone2' => request('phone2'),
                'phone3' => request('phone3'),
                'age' => request('age'),
                'gender' => request('gender'),
                'postcode' => $postal_code,
                'prefecture' => $request->pref31,
                'city' => $request->addr31,
            ]);
            DB::table('users')->where('id', $user->id)->update([
                'last_name' => request('last_name'),
                'first_name' => request('first_name'),
            ]);

            DB::commit();

        } catch (\PDOException $e){
            DB::rollBack();
            return false;
        }
        
        return redirect()->back()->with('message','会員情報を更新しました');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit()
    {

        $profile = auth()->user()->profile;

        $postCodeList = $profile->getPostCode();

        $profile['postcode1'] = $postCodeList[0];
        $profile['postcode2'] = $postCodeList[1];

        $profileRepo = new ProfileRepository($profile);
        $profile = $profileRepo->getResume();

        return view('mypages.edit', compact('profile'));
    }

    /**
     * @param UpdateUserProfileRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateUserProfileRequest $request)
    {
        $user = auth()->user();
        $profile = $user->profile;

        $profileData = [
            'phone1' => $request->phone1,
            'phone2' => $request->phone2,
            'phone3' => $request->phone3,
            'age' => $request->age,
            'gender' => $request->gender,
            'postcode' => $request->zip31."-".$request->zip32,
            'prefecture' => $request->pref31,
            'city' => $request->addr31,
        ];

        $userData = [
            'last_name' => $request->last_name,
            'first_name' => $request->first_name,
        ];

        $profileRepo = new ProfileRepository($profile);
        $userRepo = new UserRepository($user);

        DB::beginTransaction();
        try {
            $profileRepo->updateProfile($profileData);
            $userRepo->updateUser($userData);

            DB::commit();
        } catch (\PDOException $e){

            DB::rollBack();
            return false;
        }
        
        return redirect()->back()->with('message','会員情報を更新しました');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function editCareer() 
    {
        return view('mypages.career_edit');
    }

     /**
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateCareer(Request $request)
    {

        $request = $request->except('_method', '_token');

        $user = auth()->user();
        $profile = $user->profile;

        $profileRepo = new ProfileRepository($profile);
        $profileRepo->updateProfile($request);

        return redirect()->back()->with('message','現在の状況・希望を更新しました');
    }

     /**
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function resume(Request $request)
    {
        $this->validate($request,[
            'resume' => 'required | max:20000' ,
        ]);

        $user = auth()->user();
        $profile = $user->profile;

        $profileRepo = new ProfileRepository($profile);

        if($profile->resume) {
            Storage::disk('public')->delete($profile->resume);
            Storage::disk('s3')->delete('resume/'.$profile->resume);
        }

        $filename = $request->file('resume')->hashName();
        $path = $request->file('resume')->storeAs('public/files/'.$user->id, $filename);
       
        $contents = Storage::get($path);

        Storage::disk('s3')->put('resume/files/'.$user->id.'/'.$filename, $contents, 'public');

        $profileRepo->updateProfile(['resume' => 'files/'.$user->id.'/'.$filename]);

        return redirect()->back()->with('message','履歴書を更新しました');
    }

     /**
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function resumeDelete(Request $request)
    {
        $user = auth()->user();
        $profile = $user->profile;

        $profileRepo = new ProfileRepository($profile);

        if (is_null($profile->resume)) {
            return redirect()->back()->with('error', '削除する履歴書ファイルがありません');
        }

        Storage::disk('public')->delete($profile->resume);
        Storage::disk('s3')->delete('resume/'.$profile->resume);

        $profileRepo->updateProfile(['resume' => null]);
    
        return redirect()->back()->with('message', '履歴書ファイルを削除しました');
    }

}