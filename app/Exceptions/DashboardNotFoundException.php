<?php

namespace App\Exceptions;

class DashboardNotFoundException extends \Exception
{
	 public function __construct($message)
    {
        parent::__construct($message);
    }
}
