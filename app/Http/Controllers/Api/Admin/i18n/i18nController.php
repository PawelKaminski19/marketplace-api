<?php

namespace App\Http\Controllers\Api\Admin\i18n;

use App\Models\i18n\i18nLanguage;
use App\Services\i18nServices\Adapters\DatatablesAdapter;
use App\Services\i18nServices\i18nLanguageService;
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

class i18nController extends BaseAdminController
{
    /** @var i18nModuleRepository */
    protected $i18nModuleRepository;

    /** @var i18nKeysRepository */
    protected $i18nKeysRepository;

    /** @var i18nTranslationService */
    protected $i18nTranslationService;

    /** @var i18nModuleService */
    protected $i18nModuleService;

    /** @var i18nKeyService */
    protected $i18nKeyService;

    /** @var i18nLanguageRepository */
    protected $i18nLanguageRepository;

    /** @var DataTablesService */
    protected $dataTablesService;

    public function __construct(i18nModuleRepository $i18nModuleRepository,
                                i18nKeysRepository $i18nKeysRepository,
                                i18nTranslationService $i18nTranslationService,
                                i18nModuleService $i18nModuleService,
                                i18nKeyService $i18nKeyService,
                                i18nLanguageRepository $i18nLanguageRepository,
                                DataTablesService $dataTablesService)
    {
        $this->i18nModuleRepository = $i18nModuleRepository;
        $this->i18nKeysRepository = $i18nKeysRepository;
        $this->i18nTranslationService = $i18nTranslationService;
        $this->i18nModuleService = $i18nModuleService;
        $this->i18nKeyService = $i18nKeyService;
        $this->i18nLanguageRepository = $i18nLanguageRepository;
        $this->dataTablesService = $dataTablesService;
    }

    public function index()
    {
        //only a UberAdmin can list ALL users
        //if ($this->usersAccountService->checkIfUserIsSystemowner(auth()->user())) {
        //    $this->usersResource->setData($this->usersService->getAll());
        //   return $this->usersResource;
        //}
        //throw new NoPermissionException;
    }

    // --------------------------
    public function modules()
    {
        return response()->json(
            $this->i18nModuleRepository->all()
        );
    }

    public function setTranslation(Request $request)
    {
        return response()->json(
            $this->i18nTranslationService->setTranslation($request->get('data'))
        );
    }

    public function changeKey(Request $request)
    {
        return response()->json(
            $this->i18nTranslationService->changeKey($request->get('data'))
        );
    }

    public function saveKey(Request $request)
    {
        $data = $request->get('data');
        $key = !empty($data['id']) ? $this->i18nKeysRepository->find($data['id']) : null;

        return response()->json(
            $model = $this->i18nKeyService->make($key)->save($request->get('data'))
        );
    }

    public function saveModules(Request $request)
    {
        return response()->json(
            $this->i18nModuleService->saveRaw($request->get('data'))
        );
    }

    public function remove(Request $request, i18nKey $key)
    {
        return response()->json(
            $model = $this->i18nKeyService->make($key)->delete()
        );
    }

    public function languages()
    {
        return response()->json(
            $this->i18nLanguageRepository->all()
        );
    }

    public function saveLanguage(Request $request,
                                 i18nLanguageService $i18nLanguageService,
                                 i18nLanguage $language = null)
    {
        return response()->json(
            $i18nLanguageService->make($language)->save($request->all())
        );
    }

    public function deleteLanguage(i18nLanguageService $i18nLanguageService,
                                   i18nLanguage $language)
    {
        return response()->json(
            $i18nLanguageService->make($language)->delete()
        );
    }

    public function keyExist(Request $request)
    {
        return response()->json(
            $this->i18nKeysRepository->isKeyExist($request->all())
        );
    }

    public function datatables(Request $request)
    {
        $additionalData = [
            'module_id' => $request->get('module_id'),
            'show_only_untranslated' => $request->get('show_only_untranslated') === 'true',
            'language1' => $request->get('language1'),
            'language2' => $request->get('language2'),
        ];

        return response()->json(
            (new DatatablesAdapter(
                $this->dataTablesService->setMode(DataTablesService::MODE_i18n)->get(
                    $this->i18nKeysRepository->setAdditionalQueryData($additionalData)->allQuery()
                )
            ))->get($additionalData)
        );
    }
}
