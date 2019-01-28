<?php

namespace Corals\Modules\Classified\Http\Controllers;


use Corals\Modules\Classified\DataTables\ProductsDataTable;
use Corals\Modules\Classified\Http\Requests\ProductRequest;
use Corals\Modules\Classified\Models\Product;
use Corals\Settings\Facades\Settings;


class UserProductsController extends ProductsController
{

    public function __construct()
    {
        $this->excludedRequestParams = array_merge($this->excludedRequestParams, [
            'verified', 'is_featured'
        ]);

        parent::__construct();
    }

    public function setVariables()
    {
        $this->resource_url = config('classified.models.product.user_resource_url');
        $this->view_prefix = 'views.products';
    }

    public function setTheme()
    {
        \Theme::set(\Settings::get('active_frontend_theme', config('themes.corals_frontend')));
    }

    /**
     * @param ProductRequest $request
     * @param ProductsDataTable $dataTable
     * @return mixed
     */
    public function index(ProductRequest $request, ProductsDataTable $dataTable)
    {
        $status = $request->get('status');

        $products = Product::query()->authUser();

        if ($status == 'featured') {
            $products = $products->featured();
        } elseif (!empty($status)) {
            $products = $products->byStatus($status);
        }

        $pageLimit = Settings::get('classified_appearance_page_limit', 15);

        $products = $products->paginate($pageLimit);

        return view($this->view_prefix . '.index')->with(compact('products'));
    }
}