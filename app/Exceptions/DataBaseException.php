<?php

namespace App\Exceptions;

use Exception;


class DataBaseException extends Exception
{
    protected $errCode = 423;

    public function __construct($message = '')
    {
        parent::__construct($message,$this->errCode);
    }
}