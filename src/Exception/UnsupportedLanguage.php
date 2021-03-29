<?php

namespace App\Exception;

use Throwable;

class UnsupportedLanguage extends \Exception
{
    public function __construct($message = 'Unsupported language', $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
