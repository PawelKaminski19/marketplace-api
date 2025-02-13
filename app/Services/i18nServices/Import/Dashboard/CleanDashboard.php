<?php

namespace App\Services\i18nServices\Import\Dashboard;

use App\Services\i18nServices\Import\Exceptions\i18nAlreadyStarted;
use App\Services\i18nServices\Import\Generic;
use App\Services\i18nServices\Import\StepInterface;

class CleanDashboard extends Generic implements StepInterface
{
    public function process()
    {
        $dir = storage_path('repos/'.DownloadDashboard::REPO_NAME);
        \File::deleteDirectory($dir);

        $file = storage_path('repos/'.DownloadDashboard::REPO_NAME.'.zip');
        @unlink($file);

        return true;
    }
}
