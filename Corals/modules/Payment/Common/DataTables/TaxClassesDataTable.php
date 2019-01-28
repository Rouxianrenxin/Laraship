<?php

namespace Corals\Modules\Payment\DataTables;

use Corals\Foundation\DataTables\BaseDataTable;
use Corals\Modules\Payment\Models\TaxClass;
use Corals\Modules\Payment\Common\Transformers\TaxClassTransformer;
use Yajra\DataTables\EloquentDataTable;

class TaxClassesDataTable extends BaseDataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $this->setResourceUrl(config('payment_common.models.tax_class.resource_url'));

        $dataTable = new EloquentDataTable($query);

        return $dataTable->setTransformer(new TaxClassTransformer());
    }

    /**
     * Get query source of dataTable.
     * @param TaxClass $model
     * @return \Illuminate\Database\Eloquent\Builder|static
     */
    public function query(TaxClass $model)
    {
        return $model->newQuery();
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            'id' => ['visible' => false],
            'name' => ['title' => trans('Payment::attributes.tax_class.name')],
            'created_at' => ['title' => trans('Corals::attributes.created_at')],
            'updated_at' => ['title' => trans('Corals::attributes.updated_at')],
        ];
    }
}
