<?php

namespace App\Services\i18nServices;

use App\Models\i18n\i18nImportStatus;
use App\Repositories\i18n\i18nImportRepository;
use App\Services\i18nServices\Import\Dashboard\CleanDashboard;
use App\Services\i18nServices\Import\Dashboard\DownloadDashboard;
use App\Services\i18nServices\Import\Dashboard\ScanDashboard;
use App\Services\i18nServices\Import\Dashboard\UnzipDashboard;
use App\Services\i18nServices\Import\Homepage\DownloadHomepage;
use App\Services\i18nServices\Import\Homepage\ScanHomepage;
use App\Services\i18nServices\Import\Homepage\UnzipHomepage;
use App\Services\i18nServices\Import\Homepage\CleanHomepage;
use App\Services\i18nServices\Exceptions\Import\i18nAlreadyStarted;
use Carbon\Carbon;

class i18nImportService
{
    const STATUS_BEGIN = 'begin';
    const STATUS_IN_PROGRESS = 'in_progress';
    const IMPORT_TIMEOUT = 60;

    /** @var i18nImportRepository */
    protected $respository;

    protected $importPath = [
        [
            'description' => 'Download '.DownloadDashboard::REPO_NAME.' repository',
            'class' => DownloadDashboard::class,
            'key' => 'translation.download-dashboard-repository'
        ],
        [
            'description' => 'Unzipping '.DownloadDashboard::REPO_NAME.' repository',
            'class' => UnzipDashboard::class,
            'key' => 'translation.unzipping-dashboard-repository'
        ],
        [
            'description' => 'Extracting phrases from '.DownloadDashboard::REPO_NAME.' repository',
            'class' => ScanDashboard::class,
            'key' => 'translation.extracting-dashboard-repository'
        ],
        [
            'description' => 'Cleaning up '.DownloadDashboard::REPO_NAME.' temporary files',
            'class' => CleanDashboard::class,
            'key' => 'translation.cleaning-dashboard-repository'
        ],

        [
            'description' => 'Download '.DownloadHomepage::REPO_NAME.' repository',
            'class' => DownloadHomepage::class,
            'key' => 'translation.download-homepage-repository'
        ],
        [
            'description' => 'Unzipping '.DownloadHomepage::REPO_NAME.' repository',
            'class' => UnzipHomepage::class,
            'key' => 'translation.unzipping-homepage-repository'
        ],
        [
            'description' => 'Extracting phrases from '.DownloadHomepage::REPO_NAME.' repository',
            'class' => ScanHomepage::class,
            'key' => 'translation.extracting-homepage-repository'
        ],
        [
            'description' => 'Cleaning up '.DownloadHomepage::REPO_NAME.' temporary files',
            'class' => CleanHomepage::class,
            'key' => 'translation.cleaning-homepage-repository'
        ],
    ];

    public function __construct()
    {
        $this->respository = app()->make(i18nImportRepository::class);
    }

    /**
     * Begin the process.
     *
     * @return \Illuminate\Support\Collection
     * @throws i18nAlreadyStarted
     */
    public function begin()
    {
        if ($status = $this->getStatus()) {
            throw ((new i18nAlreadyStarted())->setTimeout(
                $status->updated_at->addSeconds(self::IMPORT_TIMEOUT)->timestamp
            ));
        }
        $this->respository->create(['status' => json_encode(['status' => self::STATUS_BEGIN, 'class' => null])]);

        $info = collect($this->importPath);
        $info = $info->transform(function($e) {
            return \Arr::except($e, 'class');
        });
        return $info;
    }

    /**
     * Process step and save next step data.
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function step()
    {
        $status = $this->getStatus();
        if ($status) {
            $status->touch();
            $data = json_decode($status->status, true);
            $class = $this->getNextClass($data['class']);
        }
        else {
            $status = new i18nImportStatus();
            $class = $this->importPath[0];
        }

        if (is_string($class) && $class == 'commit') {
            $this->commit();
            return ['last' => true, 'result' => true];
        }

        $classObject = app()->make($class['class']);
        $result = $classObject->process();
        if ($result) {
            $status->status = json_encode(['status' => self::STATUS_IN_PROGRESS, 'class' => $class['class']]);
            $status->save();
        }

        return ['last' => false, 'result' => $result];
    }

    /**
     * Get next class.
     *
     * @param null|string $currentClass
     * @return string
     */
    protected function getNextClass($currentClass)
    {
        if (!$currentClass) {
            return $this->importPath[0];
        }

        $index = array_search($currentClass, array_column($this->importPath, 'class'));
        if ($index === false) {
            return $this->importPath[0];
        }

        $index++;
        if (!isset($this->importPath[$index])) {
            return 'commit';
        }

        return $this->importPath[$index];
    }

    /**
     * Finish the translation process.
     *
     * @throws \Exception
     */
    public function commit()
    {
        if ($row = $this->getStatus()) {
            $row->delete();
        }
    }

    /**
     * @return \Illuminate\Database\Eloquent\Model|null
     * @throws \Exception
     */
    public function getStatus()
    {
        $row = $this->respository->query()->first();
        if ($row && Carbon::now()->gt($row->updated_at->addSeconds(self::IMPORT_TIMEOUT))) {
            $row->delete();
            return null;
        }
        return $row;
    }
}
