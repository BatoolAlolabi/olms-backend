<?php


namespace App\Helpers;


use Illuminate\Support\Facades\Auth;

class StrHelper
{
    public static function cleanMobilePhone($mobile_phone)
    {
        if ($mobile_phone == null)
            return $mobile_phone;

        return ltrim(str_replace([' ', '-', '+', '@c.us', '@g.us', '(', ')'], '', $mobile_phone), '0');
    }
    public static function cleanAmount($amount)
    {
        if ($amount == null)
            return $amount;

        return str_replace([' ', ','], '', $amount);
    }

    public static function getAcronym($string)
    {
        $acronym = '';
        foreach (explode(' ', $string) as $word)
            $acronym .= ucfirst($word[0]);

        return $acronym;
    }

    public static function falseToNull($value)
    {
        return strlen($value) > 0 && $value != 'False' ? $value : null;
    }

}
