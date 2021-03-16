<?php


namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class RewardController extends Controller
{
  private $user;

  public function __construct()
  {
    $this->middleware(function ($request, $next) {
      $this->user = \Auth::guard('seeker')->user();

      return $next($request);
    });
  }

  public function create()
  {
    return view('front.rewards.create', [
      'applies' => $this->user ? $this->user->applies->where('congrats_application_status', 2) : null,
    ]);
  }

  public function store()
  {
    if (!$this->user) return redirect()->back()->with('flash_message_danger', 'ログインして下さい');

    $applies = $this->user->applies->where('congrats_application_status', 2);

    if ($applies->isEmpty()) return redirect()->back()->with('flash_message_danger', 'お祝い金申請可能な応募はありません');

    foreach ($applies as $apply) {
        if ($apply->user_id == null) continue;
        $apply->update([
            'congrats_application_status' => 3
        ]);
        $apply->reward()->create([
            'user_id' => $apply->user_id,
            'status' => 1,
            'billing_amount' => $apply->recruitment_fee
        ]);
    }

//    DB::transaction(function ($applies) {
//      foreach ($applies as $apply) {
//        if ($apply->user_id == null) continue;
//        $apply->update([
//          'congrats_application_status' => 3
//        ]);
//        $apply->reward()->create([
//          'user_id' => $apply->user_id,
//          'status' => 1,
//          'billing_amount' => $apply->recruitment_fee
//        ]);
//      }
//    });

    return redirect()->back()->with('flash_message_success', '申請を受け付けました');
  }
}
