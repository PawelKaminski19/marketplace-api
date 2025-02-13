<?php

namespace App\Services\i18nServices\Import\Dashboard;

use App\Services\i18nServices\Import\Exceptions\i18nAlreadyStarted;
use App\Services\i18nServices\Import\Generic;
use App\Services\i18nServices\Import\StepInterface;

class UnzipDashboard extends Generic implements StepInterface
{
    public function __construct()
    {
        @mkdir(storage_path('repos/'.DownloadDashboard::REPO_NAME), 0755, true);

        parent::__construct();
    }

    public function process()
    {
        $file = storage_path('repos/'.DownloadDashboard::REPO_NAME.'.zip');
        $zip = new \ZipArchive();
        $isValid = $zip->open($file);
        if ($isValid === true) {
            $zip->extractTo(storage_path('repos/'.DownloadDashboard::REPO_NAME));
        }
        $zip->close();
        return true;
    }
}
