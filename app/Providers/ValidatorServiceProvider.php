<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use app\Library\CustomValidator; //add

class ValidatorServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // Validator::extend('hurigana', function ($attribute, $value, $parameters, $validator) {
        //     return preg_match('/[^ぁ-んー]/u', $value) === 0;
        // });
        // Validator::extend('katakana', function ($attribute, $value, $parameters, $validator) {
        //     return preg_match('/^[ァ-ヾ 　〜ー−]+$/u', $value) === 0;
        // });

        \Validator::resolver(function ($translator, $data, $rules, $messages) {
            return new CustomValidator($translator, $data, $rules, $messages);
        });
    }
}
