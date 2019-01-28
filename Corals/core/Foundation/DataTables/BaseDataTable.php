<?php

namespace Corals\Foundation\DataTables;

use Yajra\DataTables\Services\DataTable;

abstract class BaseDataTable extends DataTable
{
    protected $resource_url;

    public function __construct()
    {
        $this->addScope(new CoralsScope($this->getFilters()));
    }

    public function renderAjaxAndActions()
    {
        if ($this->request()->ajax() && $this->request()->wantsJson()) {
            return app()->call([$this, 'ajax']);
        }

        if ($action = $this->request()->get('action') and in_array($action, $this->actions)) {
            if ($action == 'print') {
                return app()->call([$this, 'printPreview']);
            }

            return app()->call([$this, $action]);
        }
    }

    /**
     * @param $resource_url
     * @return $this
     */
    public function setResourceUrl($resource_url)
    {
        $this->resource_url = url($resource_url);
        return $this;
    }

    /**
     * Get DataTables Html Builder instance.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function builder()
    {
        return app(CoralsBuilder::class);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        $language = \Language::getNameEnglish(\App::getLocale());

        $i18nArray = \Cache::remember('datatable_i18n_' . $language, 1440, function () use ($language) {
            $languagePath = "assets/corals/plugins/datatables.net/i18n/$language.lang";

            if (file_exists(public_path($languagePath))) {
                $languagePath = public_path($languagePath);

                $content = \File::get($languagePath, true);

                $data = json_decode(cleanJSONFileContent($content), true);

                return $data;
            } else {
                return '';
            }
        });

        return $this->builder()
            ->setFilters($this->getFilters())
            ->setBulkActions($this->getBulkActions())
            ->setOptions($this->getOptions())
            ->setTableId($this->getTableId())
            ->columns($this->getColumns())
            ->minifiedAjax($this->resource_url,
                '$.each(filters("#' . $this->getTableId() . '"), function(name,value){
                        data[name] = value;
                    });')
            ->addCheckbox(['datatable_id' => $this->getTableId()], true)
            ->addAction(['width' => '80px'])
            ->parameters(array_merge([
                'language' => $i18nArray,
                'order' => [[0, 'desc']],
                'pageLength' => 10,
                "dom" => "Blfrtip",
                'buttons' => ['excel', 'csv', 'print', 'reload'],
                'rowReorder' => ['selector' => 'tr>td:not(:last-child)', // I allow all columns for dragdrop except the last
                    'dataSrc' => 'sortsequence',
                    'update' => false // this is key to prevent DT auto update
                ]
            ], $this->getBuilderParameters()));
    }

    /**
     * Apply query scopes.
     *
     * @param \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder $query
     * @return mixed
     */
    protected function applyScopes($query)
    {
        $queryClass = strtolower(class_basename($query->getModel()));

        $scopes = \Filters::do_filter('datatable_scopes_' . $queryClass, $this->scopes, $queryClass);

        foreach ($scopes as $scope) {
            $scope->apply($query);
        }

        return $query;
    }

    protected function getFilters()
    {
        return [];
    }

    protected function getColumns()
    {
        return [];
    }


    protected function getBulkActions()
    {
        return [];
    }

    protected function getOptions()
    {
        return [];
    }

    protected function getTableId()
    {
        return class_basename($this);
    }

    protected function getBuilderParameters()
    {
        return [];
    }
}
