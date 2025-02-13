<?php

namespace App\Http\Controllers\Api\Language;

use App\Http\Controllers\Api\BaseApiController;
use App\Services\i18nServices\i18nLanguageService;
use Illuminate\Http\Request;

class LanguageController extends BaseApiController
{
    /** @var i18nLanguageService */
    protected $i18nLanguageService;

    /**
     * @param i18nLanguageService $i18nLanguageService
     */
    public function __construct(i18nLanguageService $i18nLanguageService)
    {
        $this->i18nLanguageService = $i18nLanguageService;
    }

    public function index()
    {
        return $this->i18nLanguageService->all();
    }
}
