<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Library\CustomValidator;
use App\Models\Profile;
use App\Job\Users\User;
use App\Job\Users\Repositories\UserRepository;
use App\Job\Users\Repositories\Interfaces\UserRepositoryInterface;
use App\Job\JobItems\JobItem;
use App\Job\JobItems\Repositories\Interfaces\JobItemRepositoryInterface;
use App\Job\Applies\Apply;
use App\Job\Applies\Repositories\Interfaces\ApplyRepositoryInterface;
use App\Job\Users\Requests\UpdateUserPasswordRequest;
use App\Job\Users\Requests\UpdateUserProfileRequest;
use Illuminate\Support\Facades\Auth;
use DB;
use Storage;
use Hash;
use Illuminate\Support\Facades\Input;

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
        $this->middleware('auth');
        $this->userRepo = $userRepository;
        $this->jobItemRepo = $jobItemRepository;
        $this->applyRepo = $applyRepository;
    }

    public function index() 
    {
        return view('mypages.index');
    }

    //mypage password change
    public function getChangePasswordForm()
    {
        return view('auth.passwords.changepassword');
    }

    public function postChangePassword(UpdateUserPasswordRequest $request) 
    {

        $user = $this->userRepo->findUserById(auth()->user()->id);
        $update = new userRepository($user);

        $msgData = [];

        //現在のパスワードが正しいかを調べる
        if(!(Hash::check($request->get('current-password'), $user->password))) {
            return redirect()->back()->with('change_password_error', '現在のパスワードが間違っています。');
        }

        //現在のパスワードと新しいパスワードが違っているかを調べる
        if(strcmp($request->get('current-password'), $request->get('new-password')) == 0) {
            return redirect()->back()->with('change_password_error', '新しいパスワードが現在のパスワードと同じです。違うパスワードを設定してください。');
        }

        $passData = [
            'password' => bcrypt($request->get('new-password')),
        ];
        
        $updated = $update->updateUser($passData);

        if($updated) {
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

        $user = $this->userRepo->findUserById(auth()->user()->id);
        $update = new userRepository($user);

        $validated_data = $request->validate([
            'email' => 'required|email|string|max:191|unique:employers|unique:users',
        ]);

        $passData = [
            'email' => $request->get('email'),
        ];
        
        $updated = $update->updateUser($passData);

        if($updated) {
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

    public function create() 
    {
        $user = $this->userRepo->findUserById(auth()->user()->id);
        $profile = $user->profile;

        $postcode = str_replace("-", "", $profile['postcode']);
        $postcode1 = substr($postcode,0,3);
        $postcode2 = substr($postcode,3);

        $exists = Storage::disk('s3')->exists('resume/' . $profile->resume);
        if($exists) {
            $resumePath =  Storage::disk('s3')->url('resume/'.$profile->resume);
            if(config('app.env') == 'production') {
                $resumePath = str_replace('s3.ap-northeast-1.amazonaws.com/', '', $resumePath);
            } 
            
        } else {
            $resumePath = '';
        }

        return view('mypages.edit', compact('postcode1', 'postcode2', 'resumePath'));
    }

    public function careerCreate() 
    {
        return view('mypages.career_edit');
    }

    public function store(UpdateUserProfileRequest $request)
    {

        $user = $this->userRepo->findUserById(auth()->user()->id);

        if($request->zip31 && $request->zip32) {
            $postal_code = $request->zip31."-".$request->zip32;
        } else {
            $postal_code  = '';
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

    public function careerStore(Request $request)
    {
        $user = $this->userRepo->findUserById(auth()->user()->id);

        Profile::where('user_id',$user->id)->update([
            'occupation' => request('occupation'),
            'final_education' => request('final_education'),
            'work_start_date' => request('work_start_date'),
        ]);

        return redirect()->back()->with('message','現在の状況・希望を更新しました');
    }

    public function resume(Request $request)
    {
        $this->validate($request,[
            'resume' => 'required | max:20000' ,
        ]);

        $user = $this->userRepo->findUserById(auth()->user()->id);
        $user_id = $user->id;

        if($user->profile->resume) {
            Storage::disk('public')->delete($user->profile->resume);
            Storage::disk('s3')->delete('resume/'.$user->profile->resume);;
        }

        $filename = $request->file('resume')->hashName();
        $path = $request->file('resume')->storeAs('public/files/'.$user_id, $filename);
       
        $contents = Storage::get('public/files/'.$user_id.'/'.$filename);

        Storage::disk('s3')->put('resume/files/'.$user_id.'/'.$filename, $contents, 'public');
        Profile::where('user_id', $user_id)->update([
            'resume' => 'files/'.$user_id.'/'.$filename,
        ]);
        return redirect()->back()->with('message','履歴書を更新しました');
    }

    public function resumeDelete(Request $request)
    {
        $user = $this->userRepo->findUserById(auth()->user()->id);
        $user_id = $user->id;
        if (is_null($user->profile->resume)) {
            return redirect()->back()->with('error', '削除する履歴書ファイルがありません');
        }

        Storage::disk('public')->delete($user->profile->resume);

        Storage::disk('s3')->delete('resume/'.$user->profile->resume);
        Profile::where('user_id', $user_id)->update([
            'resume' => null,
        ]);
        return redirect()->back()->with('message', '履歴書ファイルを削除しました');
    }

    public function jobAppManage() 
    {
        $user = $this->userRepo->findUserById(auth()->user()->id);
        $appliedJobitems = $this->userRepo->listAppliedJobItem($user);
    
        return view('mypages.app_manage', compact('appliedJobitems'));
    }
    
    public function getJobAppReport($applyId) 
    {

        $appliedJobitem = [];
        $apply = [];

        $user = $this->userRepo->findUserById(auth()->user()->id);
        $apply = $user->applies()->where('id', $applyId)->first();

        if($apply !== null) {
            $appliedJobitem = $this->applyRepo->findJobItems($apply)->first();
        }
        
        if($appliedJobitem === []) {
            return redirect()->route('mypage.jobapp.manage');
        }

        return view('mypages.app_report', compact('appliedJobitem'));
        
    }

    public function getAppFesMoney($applyJobItemId)
    {

        $applyJobItem = DB::table('apply_job_item')->where('id', $applyJobItemId)->first();

        if($applyJobItem === null) {
            return redirect()->route('mypage.jobapp.manage');
        }
        
        $jobitem = $this->jobItemRepo->findJobItemById($applyJobItem->job_item_id);

       

        return view('mypages.app_fes_money', compact('applyJobItem', 'jobitem'));

    }

    public function postAppFesMoney(Request $request, $applyJobItemId)
    {
        
        $applyJobItemQuery = DB::table('apply_job_item')->where('id', $applyJobItemId);
        $applyJobItem = $applyJobItemQuery->first();

        if($applyJobItem === null) {
            return redirect()->back();
        }

        if($applyJobItem->s_status !== 1){

            if (Input::get('adopt_submit1')){
                
                $this->validate($request,[
                    'year' => 'numeric|digits:4',
                    'month' => 'numeric|digits:2',
                    'date' => 'numeric|digits:2',
                    'oiwaikin' => 'nullable',
                ]);
                $firstAttendance = $request->year."-".$request->month."-".$request->date;
            
                $applyJobItemQuery->update([
                    's_status' => 1,
                    'first_attendance' => $firstAttendance,
                    'oiwaikin' => $request->oiwaikin,
                ]);
                
            } elseif (Input::get('adopt_submit2')){
                $this->validate($request,[
                    'app_oiwai_text' => 'string|max:1000',
                    'oiwaikin' => 'nullable',
                ]);
            
                $applyJobItemQuery->update([
                    's_status' => 1,
                    'no_first_attendance' => $request->app_oiwai_text,
                    'oiwaikin' => $request->oiwaikin,
                ]);
            }

            session()->flash('flash_message_success', 'ご報告ありがとうございました！');
            return redirect()->route('mypage.jobapp.manage');

        } elseif($applyJobItem->s_status === 1 && $applyJobItem->first_attendance === null){
            if (Input::get('adopt_submit1')){

                $this->validate($request,[
                    'year' => 'numeric|digits:4',
                    'month' => 'numeric|digits:2',
                    'date' => 'numeric|digits:2',
                ]);
                $firstAttendance = $request->year."-".$request->month."-".$request->date;
            
                $applyJobItemQuery->update([
                    'first_attendance' => $firstAttendance,
                ]);

            } elseif (Input::get('adopt_submit2')) {

                $this->validate($request,[
                    'app_oiwai_text' => 'string|max:1000',
                ]);
            
                $applyJobItemQuery->update([
                    'no_first_attendance' => $request->app_oiwai_text,
                ]);
            }

            session()->flash('flash_message_success', 'ご報告ありがとうございました！');
            return redirect()->route('mypage.jobapp.manage');
        } else {
            session()->flash('flash_message_danger', 'すでにご報告済みです');
            return redirect()->route('mypage.jobapp.manage');
        }
    }

    public function unAdoptJob($applyJobItemId)
    {

        $applyJobItemQuery = DB::table('apply_job_item')->where('id', $applyJobItemId);
        $applyJobItemQuery->update([
            's_status' => 2,
        ]);

        return redirect()->route('mypage.jobapp.manage')->with('flash_message_success', 'ご報告ありがとうございました！');
    }

    public function adoptCancelJob($applyJobItemId)
    {
        $applyJobItemQuery = DB::table('apply_job_item')->where('id', $applyJobItemId);
        $applyJobItemQuery->update([
            's_status' => 0,
        ]);

        return redirect()->route('mypage.jobapp.manage')->with('flash_message_success', '報告を取り消しました。');

    }

    public function jobDecline($applyJobItemId)
    {
        $applyJobItemQuery = DB::table('apply_job_item')->where('id', $applyJobItemId);
        $applyId = $applyJobItemQuery->first()->apply_id;

        $apply = $this->applyRepo->findApplyById($applyId);

        DB::beginTransaction();
        try {

            $applyJobItemQuery->delete();
            $apply->delete();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }

        

        return redirect()->route('mypage.jobapp.manage')->with('flash_message_success', '応募を辞退しました');
    }

    public function userDelete()
    {
        $user = $this->userRepo->findUserById(auth()->user()->id);
        $userRepo = new UserRepository($user);
        // $applies = $this->userRepo->findApplies($user);
        // $appliedJobItems = $this->userRepo->listAppliedJobItem($user);

        DB::beginTransaction();
        try {
            if ($user->profile->resume) {
                Storage::disk('public')->delete($user->profile->resume);
                Storage::disk('s3')->delete('resume/'.$user->profile->resume);
                Profile::where('user_id', $user->id)->update([
                    'resume' => null,
                ]);
            }
            
            Profile::where('user_id', $user->id)->delete();
            $userRepo->deleteUser();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }

        return redirect()->to('/');
    }

}
