<?php

namespace App\Traits;

trait ExtendExplode
{
    function double_explode($word1, $word2, $str)
    {
        $return = array();

        $array = explode($word1, $str);

        foreach ($array as $value) {
            $return = array_merge($return, explode($word2, $value));
        }

        return array_filter($return, function ($value) {
            return !is_string($value) || strlen($value);
        });
    }
}
