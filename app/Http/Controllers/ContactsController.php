<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use App\Http\Requests\ContactRequestForSeeker;
use App\Http\Requests\ContactRequestForEmployer;
use Auth;

class ContactsController extends Controller
{
    public function getContactSeeker()
    {
        if(Auth::user()) {
            $user = auth()->user();
         
            $profile = $user->profile;
            if($profile['phone1'] && $profile['phone2'] && $profile['phone3']) {
                $user_phone = $profile['phone1']."-".$profile['phone2']."-".$profile['phone3'];
            } else {
                $user_phone = "";
            }
        } else {
            $user = "";
            $user_phone = "";
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
                $employer_phone = "";
            }
        } else {
            $employer = "";
            $employer_phone = "";
        }

        return view('contacts.top', compact('employer', 'employer_phone'))->with('c_flag', 'employer');
    }

    public function postContactSeeker(ContactRequestForSeeker $request)
    {

        // 送信メール
        \Mail::queue(new \App\Mail\Contact([
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
        ]));

        // 受信メール
        \Mail::queue(new \App\Mail\Contact([
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
        ], 'from'));
    
        
        $request->session()->regenerateToken();

        return view('contacts.complete');
    }

    public function postContactEmployer(ContactRequestForEmployer $request)
    {

        // 送信メール
        \Mail::queue(new \App\Mail\Contact([
            'to' => $request->email,
            'to_name' => $request->name,
            'from' => 'no-reply@job-cinema.com',
            'from_name' => 'JOBCiNEMA',
            'to_reply' => 'official@job-cinema.com',
            'subject' => '【JOBCiNEMA】お問い合わせ受付のお知らせ',
            'cname' => $request->cname,
            'cname_katakana' => $request->cname_katakana,
            'email' => $request->email,
            'e_name' => $request->e_name,
            'e_name_ruby' => $request->e_name_ruby,
            'category' => $request->category,
            'phone' => $request->phone,
            'content' => $request->content,
            'c_flag' => $request->c_flag,
        ]));

        // 受信メール
        \Mail::queue(new \App\Mail\Contact([
            'to' => 'official@job-cinema.com',
            'to_name' => 'JOBCiNEMA',
            'from' => 'no-reply@job-cinema.com',
            'from_name' => $request->name,
            'to_reply' => $request->email,
            'subject' => '【JOBCiNEMA】サイトからのお問い合わせ',
            'cname' => $request->cname,
            'cname_katakana' => $request->cname_katakana,
            'email' => $request->email,
            'e_name' => $request->e_name,
            'e_name_ruby' => $request->e_name_ruby,
            'category' => $request->category,
            'phone' => $request->phone,
            'content' => $request->content,
            'c_flag' => $request->c_flag,
        ], 'from'));
    
        
        $request->session()->regenerateToken();

        return view('contacts.complete');
    }


}
