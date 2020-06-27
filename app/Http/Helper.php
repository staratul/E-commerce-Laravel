<?php

namespace App\Http;

use DateTime;
use Illuminate\Support\Str;

class Helper
{
    static function explode($data) {
        return explode(",", $data);
    }

    static function implode($data) {
        return implode(",", $data);
    }

    static function dateFormat($date)
    {
        $createDate = new DateTime($date);
        $strip = $createDate->format('Y-m-d');
        $d = date(DATE_RFC2822, strtotime($strip));
        $variable = substr($d, 0, strpos($d, ' 00:00:00'));
        return $variable;
    }

    static function slug($text)
    {
        return Str::slug($text);
    }
}
