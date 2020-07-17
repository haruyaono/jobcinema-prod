<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Job\Contacts\Contact;
use App\Job\Contacts\Repositories\Interfaces\ContactRepositoryInterface;
use App\Job\Contacts\Requests\ContactRequestForSeeker;
use App\Job\Contacts\Requests\ContactRequestForEmployer;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class ContactsController extends Controller
{

    /**
     * @var ContactRepositoryInterface;
     */
    private $contactRepo;

    /**
     * ContactController constructor
     * @param ContactRepositoryInterface $contactRepository
     */
    public function __construct(
        ContactRepositoryInterface $contactRepository
    ) {
        $this->contactRepo = $contactRepository;
    }


    public function getContactSeeker()
    {
        if(Auth::user()) {
            $user = auth()->user();
         
            $profile = $user->profile;
            if($profile['phone1'] && $profile['phone2'] && $profile['phone3']) {
                $user_phone = $profile['phone1']."-".$profile['phone2']."-".$profile['phone3'];
            } else {
                $user_phone = '';
            }
        } else {
            $user = '';
            $user_phone = '';
        }

        return view('contacts.top', compact('user', 'user_phone'))->with('c_flag', 'seeker');
    }

    public function getContactEmployer()
    {
        
        if(Auth::guard('employer')->user()) {
            $employer = auth('employer')->user();
         
            $company = $employer->company;
            if($employer['phone1'] && $employer['phone2'] && $employer['phone3']) {
                $employer_phone = $employer['phone1']."-".$employer['phone2']."-".$employer['phone3'];
            } else {
                $employer_phone = '';
            }
        } else {
            $employer = '';
            $employer_phone = '';
        }

        return view('contacts.top', compact('employer', 'employer_phone'))->with('c_flag', 'employer');
    }

    public function postContactSeeker(ContactRequestForSeeker $request)
    {

        $requestData = $request->except('_method', '_token', 'c_flag');
        $requestData['division'] = $request->c_flag;

        $this->contactRepo->createContact($requestData);

        $mailSendData = [
            'to' => $request->email,
            'to_name' => $request->name,
            'from' => 'no-reply@job-cinema.com',
            'from_name' => 'JOBCiNEMA',
            'to_reply' => 'official@job-cinema.com',
            'subject' => '【JOBCiNEMA】お問い合わせ受付のお知らせ',
            'email' => $request->email,
            'name' => $request->name,
            'name_ruby' => $request->name_ruby,
            'category' => $request->category,
            'phone' => $request->phone,
            'content' => $request->content,
            'c_flag' => $request->c_flag,
        ];
        // 送信メール
        $this->contactRepo->sendEmailToSeeker($mailSendData);

        $mailReceiveData = [
            'to' => 'official@job-cinema.com',
            'to_name' => 'JOBCiNEMA',
            'from' => 'no-reply@job-cinema.com',
            'from_name' => $request->name,
            'to_reply' => $request->email,
            'subject' => '【JOBCiNEMA】サイトからのお問い合わせ',
            'email' => $request->email,
            'name' => $request->name,
            'name_ruby' => $request->name_ruby,
            'category' => $request->category,
            'phone' => $request->phone,
            'content' => $request->content,
            'c_flag' => $request->c_flag,
        ];
        // 受信メール
        $this->contactRepo->sendEmailToAdmin($mailReceiveData, 'from');

        $request->session()->regenerateToken();

        return view('contacts.complete');
    }

    public function postContactEmployer(ContactRequestForEmployer $request)
    {

        $requestData = $request->except('_method', '_token', 'c_flag');
        $requestData['division'] = $request->c_flag;

        $this->contactRepo->createContact($requestData);

        $mailSendData = [
            'to' => $request->email,
            'to_name' => $request->name,
            'from' => 'no-reply@job-cinema.com',
            'from_name' => 'JOBCiNEMA',
            'to_reply' => 'official@job-cinema.com',
            'subject' => '【JOBCiNEMA】お問い合わせ受付のお知らせ',
            'cname' => $request->c_name,
            'cname_katakana' => $request->c_name_ruby,
            'email' => $request->email,
            'name' => $request->name,
            'name_ruby' => $request->name_ruby,
            'category' => $request->category,
            'phone' => $request->phone,
            'content' => $request->content,
            'c_flag' => $request->c_flag,
        ];
        // 送信メール
        $this->contactRepo->sendEmailToEmployer($mailSendData);

        $mailReceiveData = [
            'to' => 'official@job-cinema.com',
            'to_name' => 'JOBCiNEMA',
            'from' => 'no-reply@job-cinema.com',
            'from_name' => $request->name,
            'to_reply' => $request->email,
            'subject' => '【JOBCiNEMA】サイトからのお問い合わせ',
            'cname' => $request->c_name,
            'cname_katakana' => $request->c_name_ruby,
            'email' => $request->email,
            'name' => $request->name,
            'name_ruby' => $request->name_ruby,
            'category' => $request->category,
            'phone' => $request->phone,
            'content' => $request->content,
            'c_flag' => $request->c_flag,
        ];
        // 受信メール
        $this->contactRepo->sendEmailToAdmin($mailReceiveData, 'from');
        
        $request->session()->regenerateToken();

        return view('contacts.complete');
    }

}
