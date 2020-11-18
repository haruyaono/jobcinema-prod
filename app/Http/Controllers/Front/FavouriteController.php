<?php

namespace App\Http\Controllers\Front;

use App\Models\JobItem;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class FavouriteController extends Controller
{
    private $user;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = \Auth::guard('seeker')->user();
            return $next($request);
        });
    }

    public function index()
    {
        if ($this->user) {

            $before1month = date('Y-m-d H:i:s', strtotime("-1 month"));
            $delJobs = $this->user->favourites()->where('favourites.created_at', '<', $before1month)->get();
            if ($delJobs) {
                foreach ($delJobs as $delJob) {
                    $this->user->favourites()->detach($delJob->job_item_id);
                }
            }

            $jobitems = $this->user->favourites()->where('favourites.created_at', '>', $before1month)->limit(20)->orderBy('favourites.created_at', 'desc')->get();

            $result_count = $jobitems->count();

            return view('front.jobs.keeplist', compact('jobitems', 'result_count'));
        }
        return view('front.jobs.keeplist');
    }

    public function saveJob($id)
    {
        $jobitem = JobItem::find($id);
        if ($jobitem->favourites()->where('user_id', $this->user->id)->exists()) {
            return response()->json([
                'fav_save_status' => '0'
            ]);
        } else {
            $jobitem->favourites()->attach($this->user->id);
            return response()->json([
                'fav_save_status' => '1'
            ]);
        }
    }

    public function unSaveJob($id)
    {
        $jobitem = JobItem::find($id);

        if ($jobitem->favourites()->where('user_id', $this->user->id)->exists()) {
            $jobitem->favourites()->detach($this->user->id);
            return response()->json([
                'fav_del_status' => '1',
                'job' => $jobitem
            ]);
        } else {
            return response()->json([
                'fav_del_status' => '0',
                'job' => $jobitem->favourites
            ]);
        }
    }
}
