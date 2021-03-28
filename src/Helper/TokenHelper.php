<?php

namespace App\Helper;

class TokenHelper
{
    public static function generateToken(int $length = 32): string
    {
        return bin2hex(random_bytes($length / 2));
    }
}