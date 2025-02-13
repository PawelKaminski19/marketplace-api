<?php

namespace App\Services\DataTablesServices;

use App\Repositories\i18n\i18nLanguageRepository;
use App\Repositories\i18n\i18nTranslationRepository;
use Illuminate\Database\Eloquent\Builder;
use Yajra\DataTables\DataTables as DT;

class DataTablesService
{
    const MODE_NORMAL = 1;
    const MODE_i18n = 2;

    protected $dataTables;

    protected $mode = self::MODE_NORMAL;

    public function __construct(DT $dataTables)
    {
        $this->dataTables = $dataTables;
        $this->search = request('search');
        if (is_string($this->search)) {
            $this->search = json_decode($this->search, true);
        }
    }

    public function setMode($mode)
    {
        $this->mode = $mode;
        return $this;
    }


    /**
     * Get proper datatables response based on $query and current request.
     *
     * @param Builder $query
     * @return mixed
     */
    public function get($query)
    {
        $dtQuery = $this->dataTables->eloquent($query);
        switch($this->mode) {
            case self::MODE_i18n:
                $response = $this->i18nQuery($dtQuery)->make(true);
                break;
            case self::MODE_NORMAL:
            default:
                $response = $dtQuery->make(true);
                break;
        }

        return json_decode(json_encode($response->getData()), true); // convert to array
    }

    protected function i18nQuery($dtQuery)
    {
        if ($search = $this->search['value']) {
            $dtQuery->filter(function ($query) use ($search) {
                $query->orWhere('key', 'LIKE', '%'.$search.'%');
                if ($ids = $this->getKeyIds($search)) {
                    $query->orWhereIn('i18n_keys.id', $ids);
                }
            });
        }
        if ($moduleId = request('module_id')) {
            $dtQuery->filter(function ($query) use ($moduleId) {
               $query->where('module_id', $moduleId);
            });
        }

        return $dtQuery;
    }

    protected function getKeyIds()
    {
        if ($search = $this->search['value']) {
            /** @var i18nTranslationRepository $repository */
            $repository = app()->make(i18nTranslationRepository::class);
            $keys = $repository->getQuery()->where('translation', 'LIKE', '%'.$search.'%')
                ->select('key_id')->groupBy('key_id')->get();
            if ($keys) {
                return $keys->pluck('key_id')->toArray();
            }
        }
        return false;
    }
}
