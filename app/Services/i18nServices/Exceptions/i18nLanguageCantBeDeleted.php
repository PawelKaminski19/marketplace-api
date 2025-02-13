<?php

namespace App\Services\i18nServices\Exceptions;

use Exception;

class i18nLanguageCantBeDeleted extends Exception
{
    public function __construct()
    {
        parent::__construct();
    }
}
