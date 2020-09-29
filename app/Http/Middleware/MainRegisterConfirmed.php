<?php

namespace App\Http\Middleware;

use Closure;
use App\Job\Employers\Employer;

class MainRegisterConfirmed
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $employer = Employer::where('email', '=', $request->input('email'))->first();
        if ($employer) {
            if (!$employer->isMainRegistered()) {
                \Session::flash(
                    'flash_message_danger',
                    '本登録が終わっておりません。
                    送付された仮登録完了メールから本登録をしてください。'
                );
                return redirect()->back()->withInput($request->only('email'));
            }
        }

        return $next($request);
    }
}
