<?php

namespace App\Providers\CustomProvider;

use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Contracts\Auth\UserProvider;

class CustomAuthServiceProvider extends EloquentUserProvider implements UserProvider
{
    /**
     * 与えられた credentials からユーザーのインスタンスを探す
     *
     * @param  array  $credentials
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function retrieveByCredentials(array $credentials)
    {
        $user = parent::retrieveByCredentials($credentials);

        if (!$user) {
            return null;
        }

        // リレーション先の権限テーブルで can_login が true を持つユーザーに制限
        if ($user->where('status', 1)->orWhere('status', 8)->exists()) {
            return $user;
        } else {
            return null;
        }
    }
}
