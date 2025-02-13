<?php

namespace App\Services\i18nServices\Import\Homepage;

use App\Services\i18nServices\Import\Exceptions\i18nAlreadyStarted;
use App\Services\i18nServices\Import\Generic;
use App\Services\i18nServices\Import\StepInterface;

class ScanHomepage extends Generic implements StepInterface
{
    protected $filesTemplates;
    protected $filesPHP;
    protected $filesVUE;

    protected $keys;

    public function __construct()
    {
        $this->keys = [];

        $this->filesVUE = $this->getFiles(storage_path('repos/'.DownloadHomepage::REPO_NAME), [
            'ext' => ['vue', 'js'], // at least one extension needed
            'includeDir' => ['resources/js']
        ]);

        $this->filesTemplates = $this->getFiles(storage_path('repos/'.DownloadHomepage::REPO_NAME), [
            'ext' => ['php'], // at least one extension needed
            'includeDir' => ['resources/views']
        ]);

        $this->filesPHP = $this->getFiles(storage_path('repos/'.DownloadHomepage::REPO_NAME), [
            'ext' => ['php'], // at least one extension needed
            'includeDir' => ['app/Http', 'app/Services']
        ]);

        parent::__construct();
    }

    /**
     * Fire up main process.
     *
     * @return bool
     */
    public function process()
    {
        $this->processVUE();
        $this->processTemplates();
        $this->processPHP();
        $this->processKeys();

        return true;
    }

    /**
     * Parse Vue files.
     */
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

    /**
     * Parse Blade templates.
     */
    protected function processTemplates()
    {
        foreach($this->filesTemplates as $file) {
            $content = file_get_contents($file);

            $result = preg_match_all(self::SCAN_BLADE_REGEX, $content, $matches);
            if ($result > 0) {
                $this->keys = array_merge($this->keys, $matches[1]);
            }
        }

        $this->uniqueKeys();
    }

    /**
     * Parse PHP files.
     */
    protected function processPHP()
    {
        foreach($this->filesTemplates as $file) {
            $content = file_get_contents($file);

            // get from vue
            $result = preg_match_all(self::SCAN_BLADE_REGEX, $content, $matches);
            if ($result > 0) {
                $this->keys = array_merge($this->keys, $matches[1]);
            }
        }

        $this->uniqueKeys();
    }
}
