<?php

namespace Corals\Modules\Referral\DataTables;

use Corals\Foundation\DataTables\BaseDataTable;
use Corals\Modules\Referral\Models\ReferralRelationship;
use Corals\Modules\Referral\Transformers\ReferralRelationshipTransformer;
use Yajra\DataTables\EloquentDataTable;

class ReferralRelationshipsDataTable extends BaseDataTable
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

        return $dataTable->setTransformer(new ReferralRelationshipTransformer());
    }

    /**
     * Get query source of dataTable.
     * @param ReferralRelationship $model
     * @return \Illuminate\Database\Eloquent\Builder|static
     */
    public function query(ReferralRelationship $model)
    {
        $referral_program = $this->request->route('referral_program');
        if (!$referral_program) {
            abort('404');
        }

        return $model->newQuery()->whereHas('link', function ($query) use ($referral_program) {
            return $query->where('referral_program_id', $referral_program->id);
        });
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
            'user' => ['title' => trans('ReferralProgram::attributes.referral_data.user'), 'searchable' => false, 'orderable' => false],
            'referred_user' => ['title' => trans('ReferralProgram::attributes.referral_data.referred_user'), 'searchable' => false, 'orderable' => false],
            'reward' => ['title' => trans('ReferralProgram::attributes.referral_data.reward')],
            'created_at' => ['title' => trans('Corals::attributes.created_at')],
        ];
    }
}
