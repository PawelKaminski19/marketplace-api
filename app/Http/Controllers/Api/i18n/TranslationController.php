<?php

namespace App\Http\Controllers\Api\i18n;

use App\Http\Controllers\Api\BaseApiController;
use App\Services\i18nServices\i18nTranslationService;
use Illuminate\Http\Request;

class TranslationController extends BaseApiController
{
    /** @var $translationService i18nTranslationService */
    protected $translationService;

    public function __construct(i18nTranslationService $translationService)
    {
        $this->translationService = $translationService;
    }

    public function index(Request $request, $language = '')
    {
        $modules = $request->get('modules', []);
        return response()->json($this->translationService->getSiteTranslations(
            true, $language, is_array($modules) ? $modules : explode(',', $modules))
        );
    }


}
