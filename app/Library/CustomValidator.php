<?php
namespace app\Library;

class CustomValidator extends \Illuminate\Validation\Validator
{

    public function validateKana($attribute, $value, $parameters)
    {
        if (preg_match('/[^ぁ-んーァ-ヶー]+$/u', $value) !== 0) {
            return false;
        }
        return true;
    }

    public function validateKatakana($attribute, $value, $parameters)
    {
        if (preg_match('/^[ァ-ヾ 　〜ー−]+$/u', $value) === 0) {
            return false;
        }
        return true;
    }
}