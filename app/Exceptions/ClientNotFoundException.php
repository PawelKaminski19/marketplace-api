<?php

namespace App\Exceptions;

class ClientNotFoundException extends \Exception
{
	 public function __construct($message)
    {
        parent::__construct($message);
    }
}
