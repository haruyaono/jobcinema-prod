<?php

namespace App\Traits;

trait IsMobile
{
    public function isMobile($request): string
    {
        $user_agent = $request->header('User-Agent');
        if ((strpos($user_agent, 'iPhone') !== false)
            || (strpos($user_agent, 'iPod') !== false)
            || (strpos($user_agent, 'Android') !== false)
        ) {
            $terminal = 'mobile';
        } else {
            $terminal = 'pc';
        }
        return $terminal;
    }
}
