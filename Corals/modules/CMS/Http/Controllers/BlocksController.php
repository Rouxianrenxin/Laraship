<?php

namespace Corals\Modules\CMS\Http\Controllers;

use Corals\Foundation\Http\Controllers\BaseController;
use Corals\Modules\CMS\DataTables\BlocksDataTable;
use Corals\Modules\CMS\Http\Requests\BlockRequest;
use Corals\Modules\CMS\Models\Block;

class BlocksController extends BaseController
{
    public function __construct()
    {
        $this->resource_url = config('cms.models.block.resource_url');
        $this->title = 'CMS::module.block.title';
        $this->title_singular = 'CMS::module.block.title_singular';

        parent::__construct();
    }

    /**
     * @param BlockRequest $request
     * @param BlocksDataTable $dataTable
     * @return mixed
     */
    public function index(BlockRequest $request, BlocksDataTable $dataTable)
    {
        $this->setViewSharedData(['hideCreate' => true]);
        return $dataTable->render('CMS::blocks.index');
    }

}