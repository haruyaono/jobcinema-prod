<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobItem;
use App\Models\User;
use Auth;

class FavouriteController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            
            $before1month = date('Y-m-d H:i:s', strtotime("-1 month"));
            $delJobs = Auth::user()->favourites()->where('favourites.created_at','<',$before1month)->get();
            if($delJobs) {
                foreach($delJobs as $delJob){
                    Auth::user()->favourites()->detach($delJob->job_item_id);
                }
            }
    
            $jobs = Auth::user()->favourites()->where('favourites.created_at','>',$before1month)->limit(3)->orderBy('favourites.created_at', 'desc')->get();

            $result_count = $jobs->count();
        
            return view('jobs.keeplist', compact('jobs', 'result_count'));
        } 
        return view('jobs.keeplist');
    }

    public function saveJob($id)
    {
        $jobid = JobItem::find($id);
        $jobid->favourites()->attach(auth()->user()->id);
        return redirect()->back();
    }

    public function unSaveJob($id)
    {
        $jobid = JobItem::find($id);
        $jobid->favourites()->detach(auth()->user()->id);
        return redirect()->back();
    }
}
