<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Library\CustomValidator;
use App\Models\Profile;
use App\Models\User;
use App\Job\JobItems\JobItem;
use DB;
use Storage;
use Hash;
use Illuminate\Support\Facades\Input;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    //mypage password change
    public function getChangePasswordForm() {
        return view('auth.passwords.changepassword');
    }
    public function postChangePassword(Request $request) {
        //現在のパスワードが正しいかを調べる
        if(!(Hash::check($request->get('current-password'), auth()->user()->password))) {
            return redirect()->back()->with('change_password_error', '現在のパスワードが間違っています。');
        }

        //現在のパスワードと新しいパスワードが違っているかを調べる
        if(strcmp($request->get('current-password'), $request->get('new-password')) == 0) {
            return redirect()->back()->with('change_password_error', '新しいパスワードが現在のパスワードと同じです。違うパスワードを設定してください。');
        }

        //パスワードのバリデーション。新しいパスワードは6文字以上、new-password_confirmationフィールドの値と一致しているかどうか。
        $validated_data = $request->validate([
            'current-password' => 'required',
            'new-password' => 'required|string|min:6|confirmed',
        ]);

        //パスワードを変更
        $user = auth()->user();
        $user->password = bcrypt($request->get('new-password'));
        $user->save();

        return redirect()->back()->with('change_password_success', 'パスワードを変更しました。');
    }

    //mypage email change
    public function getChangeEmail() {
        return view('auth.passwords.change_email');
    }
    public function postChangeEmail(Request $request) {
        $validated_data = $request->validate([
            'email' => 'required|email|string|max:191|unique:employers|unique:users',
        ]);

        $user = auth()->user();
        $user->email = $request->get('email');
        $user->save();

        return redirect()->back()->with('change_email_success', 'メールアドレスを変更しました。');
    }

    public function index() 
    {
        return view('mypages.index');
    }

    public function create() 
    {
        $user = auth()->user();
        $user_id = $user->id;
        $profile = Profile::where('user_id',$user_id)->first();

        $postcode = $profile['postcode'];
        $postcode = str_replace("-", "", $postcode);
        $postcode1 = substr($postcode,0,3);
        $postcode2 = substr($postcode,3);

        $exists = Storage::disk('s3')->exists('resume/'.$user->profile->resume);
        if($exists) {
            $resumePath =  Storage::disk('s3')->url('resume/'.$user->profile->resume);
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

    public function store(Request $request)
    {
        $this->validate($request,[
            'last_name' => 'required | max:191 | kana',
            'first_name' => 'required | max:191 | kana' ,
            'phone1' => 'required|numeric|digits_between:2,5',
            'phone2' => 'required|numeric|digits_between:1,4',
            'phone3' => 'required|numeric|digits_between:3,4',
            'age' => 'nullable|numeric|between:15,99',
            'zip31' => 'nullable|numeric|digits:3',
            'zip32' => 'nullable|numeric|digits:4',
            'pref31' => 'nullable|string|max:191',
            'addr31' => 'nullable|string|max:191',
        ]);

        $user_id = auth()->user()->id;
        if($request->zip31 && $request->zip32) {
            $postal_code = $request->zip31."-".$request->zip32;
        } else {
            $postal_code  = '';
        }
        

        Profile::where('user_id',$user_id)->update([

            'phone1' => request('phone1'),
            'phone2' => request('phone2'),
            'phone3' => request('phone3'),
            'age' => request('age'),
            'gender' => request('gender'),
            'postcode' => $postal_code,
            'prefecture' => $request->pref31,
            'city' => $request->addr31,
        ]);
        DB::table('users')->where('id', $user_id)->update([
            'last_name' => request('last_name'),
            'first_name' => request('first_name'),
        ]);
        return redirect()->back()->with('message','会員情報を更新しました');
    }

    public function careerStore(Request $request)
    {
        $user_id = auth()->user()->id;
        Profile::where('user_id',$user_id)->update([

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

        $user = auth()->user();
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
        $user = auth()->user();
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

        $jobs = JobItem::all();
       
        return view('mypages.app_manage', compact('jobs'));
    }
    public function getJobAppReport($id) 
    {
        $job = JobItem::findOrFail($id);
        $appjob = $job->users()->where('user_id', auth()->user()->id)->first();
        return view('mypages.app_report', compact('job','appjob'));
    }

    // public function saveJob($id)
    // {
    //     $jobid = JobItem::find($id);
    //     $jobid->favourites()->attach(auth()->user()->id);
    //     return redirect()->back();
    // }

    public function getAppFesMoney($id)
    {
        $job = JobItem::findOrFail($id);
        $appjob = $job->users()->where('user_id', auth()->user()->id)->first();
        return view('mypages.app_fes_money', compact('job','appjob'));
    }
    public function postAppFesMoney(Request $request, $id)
    {
        
        $jobid = JobItem::findOrFail($id);
        $appjobItem = $jobid->users()->where('user_id', auth()->user()->id)->first();

        if($appjobItem->pivot->s_status != 1){

            if (Input::get('adopt_submit1')){

                $this->validate($request,[
                    'year' => 'numeric|digits:4',
                    'month' => 'numeric|digits:2',
                    'date' => 'numeric|digits:2',
                    'oiwaikin' => 'nullable',
                ]);
                $firstAttendance = $request->year."-".$request->month."-".$request->date;
            
                $appJob = DB::table('job_item_user')
                    ->where('user_id', auth()->user()->id)
                    ->where('job_item_id', $jobid->id)
                    ->update([
                        's_status' => 1,
                        'first_attendance' => $firstAttendance,
                        'oiwaikin' => $request->oiwaikin,
                    ]);
                    session()->flash('flash_message_success', 'ご報告ありがとうございました！');
                return redirect()->route('mypage.jobapp.manage');
                
            } elseif (Input::get('adopt_submit2')){
                $this->validate($request,[
                    'app_oiwai_text' => 'string|max:1000',
                    'oiwaikin' => 'nullable',
                ]);
            
                
                $appJob = DB::table('job_item_user')
                    ->where('user_id', auth()->user()->id)
                    ->where('job_item_id', $jobid->id)
                    ->update([
                        's_status' => 1,
                        'no_first_attendance' => $request->app_oiwai_text,
                        'oiwaikin' => $request->oiwaikin,
                    ]);
                    session()->flash('flash_message_success', 'ご報告ありがとうございました！');
                return redirect()->route('mypage.jobapp.manage');
            }
        } elseif($appjobItem->pivot->s_status == 1 && $appjobItem->pivot->first_attendance == null){
            if (Input::get('adopt_submit1')){

                $this->validate($request,[
                    'year' => 'numeric|digits:4',
                    'month' => 'numeric|digits:2',
                    'date' => 'numeric|digits:2',
                    'oiwaikin' => 'nullable',
                ]);
                $firstAttendance = $request->year."-".$request->month."-".$request->date;
            
                $appJob = DB::table('job_item_user')
                    ->where('user_id', auth()->user()->id)
                    ->where('job_item_id', $jobid->id)
                    ->update([
                        's_status' => 1,
                        'first_attendance' => $firstAttendance,
                        'oiwaikin' => $request->oiwaikin,
                    ]);
                    session()->flash('flash_message_success', 'ご報告ありがとうございました！');
                return redirect()->route('mypage.jobapp.manage');
            } else {
                session()->flash('flash_message_danger', '不正なリクエストです');
                return redirect()->route('mypage.jobapp.manage');
            }
        } else {
            session()->flash('flash_message_danger', '不正なリクエストです');
            return redirect()->route('mypage.jobapp.manage');
        }
    }

    public function unAdoptJob($id)
    {
        $jobid = JobItem::findOrFail($id);
        $appJob = DB::table('job_item_user')
            ->where('user_id', auth()->user()->id)
            ->where('job_item_id', $jobid->id)
            ->update([
                's_status' => 2,
            ]);
        return redirect()->to('mypage/application')->with('flash_message_success', 'ご報告ありがとうございました！');
    }

    public function adoptCancelJob($id)
    {
        $jobid = JobItem::findOrFail($id);
        $appJob = DB::table('job_item_user')
            ->where('user_id', auth()->user()->id)
            ->where('job_item_id', $jobid->id)
            ->update([
                's_status' => 0,
            ]);

        return redirect()->to('mypage/application')->with('flash_message_success', '報告を取り消しました。');

    }

    public function jobDecline($id)
    {
        $jobid = JobItem::findOrFail($id);
        $appJob = DB::table('job_item_user')
            ->where('user_id', auth()->user()->id)
            ->where('job_item_id', $jobid->id)
            ->delete();

        return redirect()->to('mypage/application')->with('flash_message_success', '応募を辞退しました');
    }

    public function userDelete()
    {
        $user = auth()->user();

        DB::beginTransaction();
        try {
            if ($user->profile->resume) {
                Storage::disk('public')->delete($user->profile->resume);
                Profile::where('user_id', $user->id)->update([
                    'resume' => null,
                ]);
            }
            
            Profile::where('user_id', $user->id)->delete();
            DB::table('job_item_user')->where('user_id', $user->id)->delete();
            User::find($user->id)->delete();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }

        return redirect()->to('/');
    }

}
