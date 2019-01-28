<?php

namespace Corals\Modules\Referral\DataTables;

use Corals\Foundation\DataTables\BaseDataTable;
use Corals\Modules\Referral\Models\ReferralProgram;
use Corals\Modules\Referral\Transformers\ReferralProgramTransformer;
use Yajra\DataTables\EloquentDataTable;

class ReferralProgramsDataTable extends BaseDataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $this->setResourceUrl(config('referral_program.models.referral_program.resource_url'));

        $dataTable = new EloquentDataTable($query);

        return $dataTable->setTransformer(new ReferralProgramTransformer());
    }

    /**
     * Get query source of dataTable.
     * @param ReferralProgram $model
     * @return \Illuminate\Database\Eloquent\Builder|static
     */
    public function query(ReferralProgram $model)
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
            'name' => ['title' => trans('ReferralProgram::attributes.referral_program.name')],
            'uri' => ['title' => trans('ReferralProgram::attributes.referral_program.uri')],
            'referral_action' => ['title' => trans('Corals::labels.action')],
            'status' => ['title' => trans('Corals::attributes.status')],
            'title' => ['title' => trans('ReferralProgram::attributes.referral_program.title')],
            'created_at' => ['title' => trans('Corals::attributes.created_at')],
            'updated_at' => ['title' => trans('Corals::attributes.updated_at')],
        ];
    }
}
