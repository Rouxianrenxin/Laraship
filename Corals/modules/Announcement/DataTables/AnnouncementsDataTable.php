<?php

namespace Corals\Modules\Announcement\DataTables;

use Corals\Foundation\DataTables\BaseDataTable;
use Corals\Modules\Announcement\Models\Announcement;
use Corals\Modules\Announcement\Transformers\AnnouncementTransformer;
use Yajra\DataTables\EloquentDataTable;

class AnnouncementsDataTable extends BaseDataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $this->setResourceUrl(config('announcement.models.announcement.resource_url'));

        $dataTable = new EloquentDataTable($query);

        return $dataTable->setTransformer(new AnnouncementTransformer());
    }

    /**
     * Get query source of dataTable.
     * @param Announcement $model
     * @return \Illuminate\Database\Eloquent\Builder|static
     */
    public function query(Announcement $model)
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
            'title' => ['title' => trans('Announcement::attributes.announcement.title')],
            'starts_at' => ['title' => trans('Announcement::attributes.announcement.starts_at')],
            'ends_at' => ['title' => trans('Announcement::attributes.announcement.ends_at')],
            'is_public' => ['title' => trans('Announcement::attributes.announcement.is_public')],
            'show_immediately' => ['title' => trans('Announcement::attributes.announcement.show_immediately')],
            'show_in_url' => ['title' => trans('Announcement::attributes.announcement.show_in_url')],
            'created_at' => ['title' => trans('Corals::attributes.created_at')],
            'updated_at' => ['title' => trans('Corals::attributes.updated_at')],
        ];
    }
}
