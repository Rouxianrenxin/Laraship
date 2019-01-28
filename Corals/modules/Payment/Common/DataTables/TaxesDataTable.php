<?php

namespace Corals\Modules\Payment\DataTables;

use Corals\Foundation\DataTables\BaseDataTable;
use Corals\Modules\Payment\Models\Tax;
use Corals\Modules\Payment\Common\Transformers\TaxTransformer;
use Yajra\DataTables\EloquentDataTable;

class TaxesDataTable extends BaseDataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $dataTable = new EloquentDataTable($query);

        return $dataTable->setTransformer(new TaxTransformer());
    }

    /**
     * Get query source of dataTable.
     * @param Tax $model
     * @return \Illuminate\Database\Eloquent\Builder|static
     */
    public function query(Tax $model)
    {
        $tax_class = $this->request->route('tax_class');
        if (!$tax_class) {
            abort('404');
        }

        return $model->newQuery()->where('tax_class_id', $tax_class->id);
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
            'name' => ['title' => trans('Payment::attributes.tax.name')],
            'country' => ['title' => trans('Payment::attributes.tax.country')],
            'state' => ['title' => trans('Payment::attributes.tax.state')],
            'zip' => ['title' => trans('Payment::attributes.tax.zip')],
            'rate' => ['title' => trans('Payment::attributes.tax.rate')],
            'priority' => ['title' => trans('Payment::attributes.tax.priority')],
            'compound' => ['title' => trans('Payment::attributes.tax.compound')],
            'status' => ['title' => trans('Corals::attributes.status')],
            'created_at' => ['title' => trans('Corals::attributes.created_at')],
            'updated_at' => ['title' => trans('Corals::attributes.updated_at')],
        ];
    }
}
