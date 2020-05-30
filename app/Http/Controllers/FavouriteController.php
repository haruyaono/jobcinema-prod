<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Job\JobItems\JobItem;
use App\Job\Users\User;
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
    
            $jobs = Auth::user()->favourites()->where('favourites.created_at','>',$before1month)->limit(20)->orderBy('favourites.created_at', 'desc')->get();

            $result_count = $jobs->count();
        
            return view('jobs.keeplist', compact('jobs', 'result_count'));
        } 
        return view('jobs.keeplist');
    }

    public function saveJob($id)
    {
        $jobid = JobItem::find($id);
        $user = Auth::user();
        if($jobid->favourites()->where('user_id', $user->id)->exists()) {
            return response()->json([
                'fav_save_status' => '0'
            ]);
        } else {
            $jobid->favourites()->attach($user->id);
            return response()->json([
                'fav_save_status' => '1'
            ]);
        }
    }

    public function unSaveJob($id)
    {
        $jobid = JobItem::find($id);
        $user = Auth::user();
        if($jobid->favourites()->where('user_id', $user->id)->exists()) {
            $jobid->favourites()->detach($user->id);
            return response()->json([
                'fav_del_status' => '1'
            ]);
        } else {
            return response()->json([
                'fav_del_status' => '0'
            ]);
        }
    }
}
