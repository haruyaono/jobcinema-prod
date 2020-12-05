<?php

namespace App\Http\Controllers\Front;

use App\Models\Contact;
use App\Repositories\ContactRepository;
use App\Http\Requests\Front\ContactRequestForSeeker;
use App\Http\Requests\Front\ContactRequestForEmployer;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class ContactsController extends Controller
{
    private $ContactRepository;

    public function __construct(
        ContactRepository $contactRepository
    ) {
        $this->ContactRepository = $contactRepository;
    }

    public function getContactSeeker()
    {
        $user = '';
        $user_phone = '';

        if (Auth::user()) {
            $user = auth()->user();
            $profile = $user->profile;

            if ($profile['phone1'] && $profile['phone2'] && $profile['phone3']) {
                $user_phone = $profile['phone1'] . "-" . $profile['phone2'] . "-" . $profile['phone3'];
            } else {
                $user_phone = '';
            }
        }

        return view('contacts.top', compact('user', 'user_phone'))->with('c_flag', 'seeker');
    }

    public function getContactEmployer()
    {
        $employer = '';
        $employer_phone = '';

        if (Auth::guard('employer')->user()) {
            $employer = auth('employer')->user();

            $company = $employer->company;
            if ($employer['phone1'] && $employer['phone2'] && $employer['phone3']) {
                $employer_phone = $employer['phone1'] . "-" . $employer['phone2'] . "-" . $employer['phone3'];
            } else {
                $employer_phone = '';
            }
        }

        return view('contacts.top', compact('employer', 'employer_phone'))->with('c_flag', 'employer');
    }

    public function postContactSeeker(ContactRequestForSeeker $request)
    {

        $requestData = $request->except('_method', '_token', 'c_flag');
        $requestData['division'] = $request->c_flag;

        Contact::create($requestData);

        $mailSendData = [
            'to' => $request->email,
            'to_name' => $request->name,
            'from' => config('mail.from.address'),
            'from_name' => config('mail.from.name'),
            'to_reply' => config('mail.reply.address'),
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
        $this->ContactRepository->sendEmailToSeeker($mailSendData);

        $mailReceiveData = [
            'to' => config('mail.reply.address'),
            'to_name' => config('mail.from.name'),
            'from' => config('mail.from.address'),
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
        $this->ContactRepository->sendEmailToAdmin($mailReceiveData, 'from');

        $request->session()->regenerateToken();

        return view('contacts.complete');
    }

    public function postContactEmployer(ContactRequestForEmployer $request)
    {

        $requestData = $request->except('_method', '_token', 'c_flag');
        $requestData['division'] = $request->c_flag;

        Contact::create($requestData);

        $mailSendData = [
            'to' => $request->email,
            'to_name' => $request->name,
            'from' => config('mail.from.address'),
            'from_name' => config('mail.from.name'),
            'to_reply' => config('mail.reply.address'),
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
        $this->ContactRepository->sendEmailToEmployer($mailSendData);

        $mailReceiveData = [
            'to' => config('mail.reply.address'),
            'to_name' => config('mail.from.name'),
            'from' => config('mail.from.address'),
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
        $this->ContactRepository->sendEmailToAdmin($mailReceiveData, 'from');

        $request->session()->regenerateToken();

        return view('contacts.complete');
    }
}
