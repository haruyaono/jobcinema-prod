<?php 

namespace App\Traits;
use Illuminate\Http\Request;

trait IsMobile
{
    public function isMobile($res) : string
    {
        $user_agent =  $res->header('User-Agent');
        if ((strpos($user_agent, 'iPhone') !== false)
            || (strpos($user_agent, 'iPod') !== false)
            || (strpos($user_agent, 'Android') !== false)) {
            $terminal ='mobile';
        } else {
            $terminal = 'pc';
        }
        return $terminal;
    }
}