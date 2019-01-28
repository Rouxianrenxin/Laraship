<?php

namespace Corals\Modules\Amazon\Transformers;

use Corals\Foundation\Transformers\BaseTransformer;
use Corals\Modules\Amazon\Models\Import;

class ImportTransformer extends BaseTransformer
{
    public function __construct()
    {
        $this->resource_url = config('amazon.models.import.resource_url');

        parent::__construct();
    }

    /**
     * @param Import $import
     * @return array
     * @throws \Throwable
     */
    public function transform(Import $import)
    {

        $levels = [
            'pending' => 'info',
            'in_progress' => 'success',
            'completed' => 'primary',
            'failed' => 'danger',
            'canceled' => 'warning'
        ];

        $show_url = url($this->resource_url . '/' . $import->hashed_id);

        return [
            'id' => $import->id,
            'title' => '<a href="' . $show_url . '">' . str_limit($import->title, 50) . '</a>',
            'status' => formatStatusAsLabels($import->status, ['level' => $levels[$import->status], 'text' => trans('Amazon::attributes.import.status_options.' . $import->status)]),
            'categories' => formatArrayAsLabels($import->categories->pluck('name'), 'success', '<i class="fa fa-folder-open"></i>'),
            'keywords' => formatArrayAsLabels($import->keywords, 'success', '<i class="fa fa-tag"></i>'),
            'imported_products_count' => $import->products->count(),
            'created_at' => format_date($import->created_at),
            'updated_at' => format_date($import->updated_at),
            'action' => $this->actions($import)
        ];
    }
}