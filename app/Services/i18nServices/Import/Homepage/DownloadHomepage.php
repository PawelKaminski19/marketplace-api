<?php

namespace App\Services\i18nServices\Import\Homepage;

use App\Services\i18nServices\Import\Exceptions\i18nAlreadyStarted;
use App\Services\i18nServices\Import\Generic;
use App\Services\i18nServices\Import\StepInterface;

class DownloadHomepage extends Generic implements StepInterface
{
    const REPO_NAME = 'shopway-frontend-homepage';

    public function __construct()
    {
        @mkdir(storage_path('repos'), 0755, true);

        parent::__construct();
    }

    public function process()
    {
        $this->downloadRepository(self::REPO_NAME, storage_path('repos/'.self::REPO_NAME.'.zip'));
        return true;
    }
}
