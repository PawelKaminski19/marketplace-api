<?php

namespace App\Services\i18nServices\Exceptions\Import;

use Carbon\Carbon;
use Exception;

class i18nAlreadyStarted extends Exception
{
    public $timeout;

    public function __construct()
    {
        $this->message = 'Process already started.';
        $this->code = 1;

        parent::__construct();
    }

    public function setTimeout($timeout)
    {
        $this->timeout = Carbon::createFromTimestamp($timeout)->format('Y-m-d H:i:s');
        return $this;
    }

    public function getTimeout()
    {
        return $this->timeout;
    }
}
