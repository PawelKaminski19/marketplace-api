<?php

namespace App\Services\i18nServices\Import\Dashboard;

use App\Services\i18nServices\Import\Exceptions\i18nAlreadyStarted;
use App\Services\i18nServices\Import\Generic;
use App\Services\i18nServices\Import\StepInterface;

class ScanDashboard extends Generic implements StepInterface
{
    protected $filesJS;
    protected $filesVUE;

    public function __construct()
    {
        $this->filesJS = $this->getFiles(storage_path('repos/'.DownloadDashboard::REPO_NAME), [
            'ext' => ['js'], // at least one extension needed
            'excludeDir' => []
        ]);

        $this->filesVUE = $this->getFiles(storage_path('repos/'.DownloadDashboard::REPO_NAME), [
            'ext' => ['vue'], // at least one extension needed
            'excludeDir' => []
        ]);

        parent::__construct();
    }

    public function process()
    {
        $this->processJS();
        $this->processVUE();
        $this->processKeys();

        return true;
    }

    protected function processJS()
    {
        // TODO: for now - nothing here
        /*
        foreach($this->filesJS as $file) {
            $content = file_get_contents($file);
        }*/

        $this->uniqueKeys();
    }

    protected function processVUE()
    {
        foreach($this->filesVUE as $file) {
            $content = file_get_contents($file);

            // get from vue
            $result = preg_match_all(self::SCAN_JS_REGEX, $content, $matches);
            if ($result > 0) {
                $this->keys = array_merge($this->keys, $matches[1]);
            }
        }

        $this->uniqueKeys();
    }
}
