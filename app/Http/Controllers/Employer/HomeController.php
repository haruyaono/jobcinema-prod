<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employer;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth:employer']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // if(Auth::guard('employer')->check()){
        //     return view('employer.home');
        // }

        return view('employer.home');
    }
}
