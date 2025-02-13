<?php

namespace App\Http\Controllers\Api\Admin\i18n;

use App\Models\i18n\i18nLanguage;
use App\Services\i18nServices\Adapters\DatatablesAdapter;
use App\Services\i18nServices\i18nImportService;
use App\Services\i18nServices\i18nLanguageService;
use App\Services\i18nServices\i18nRepositoryService;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\Admin\BaseAdminController;
use App\Models\i18n\i18nKey;
use App\Repositories\i18n\i18nKeysRepository;
use App\Repositories\i18n\i18nLanguageRepository;
use App\Repositories\i18n\i18nModuleRepository;
use App\Services\DataTablesServices\DataTablesService;
use App\Services\i18nServices\i18nKeyService;
use App\Services\i18nServices\i18nModuleService;
use App\Services\i18nServices\i18nTranslationService;

class i18nImportController extends BaseAdminController
{
    /** @var i18nImportService */
    protected $i18nImportService;

    public function __construct(i18nImportService $i18nImportService)
    {
        $this->i18nImportService = $i18nImportService;
    }

    public function begin()
    {
        try {
            return response()->json($this->i18nImportService->begin());
        }
        catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'code' => $e->getCode(),
                'timeout' => $e->getTimeout()
            ], 422);
        }

    }

    public function step(Request $request)
    {
        try {
            return response()->json($this->i18nImportService->step());
        }
        catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'code' => $e->getCode()
            ], 422);
        }
    }

    public function commit()
    {
        return response()->json($this->i18nImportService->commit());
    }
}
