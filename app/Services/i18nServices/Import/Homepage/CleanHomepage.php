<?php

namespace App\Services\i18nServices\Import\Homepage;

use App\Services\i18nServices\Import\Exceptions\i18nAlreadyStarted;
use App\Services\i18nServices\Import\Generic;
use App\Services\i18nServices\Import\Homepage\DownloadHomepage;
use App\Services\i18nServices\Import\StepInterface;

class CleanHomepage extends Generic implements StepInterface
{
    public function process()
    {
        $dir = storage_path('repos/'.DownloadHomepage::REPO_NAME);
        \File::deleteDirectory($dir);

        $file = storage_path('repos/'.DownloadHomepage::REPO_NAME.'.zip');
        @unlink($file);

        return true;
    }
}
