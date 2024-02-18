<?php
namespace App\Helpers;

class StringHelper
{
    public static function extractValue($string)
    {
        $parts = explode("=", $string);
        return $parts[1] ?? null;
    }
}
