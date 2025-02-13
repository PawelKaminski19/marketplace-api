<?php

namespace App\Exceptions;

class UserNotFoundException extends \Exception
{
	 public function __construct($message)
    {
        parent::__construct($message);
    }
}
