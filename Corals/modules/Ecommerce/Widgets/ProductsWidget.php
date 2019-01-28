<?php

namespace Corals\Modules\Ecommerce\Widgets;

use \Corals\Modules\Ecommerce\Models\Product;

class ProductsWidget
{

    function __construct()
    {
    }

    function run($args)
    {

        $products = Product::count();
        return ' <!-- small box -->
                <div class="card">
                <div class="small-box bg-green card-body">
                    <div class="inner">
                        <h3>' . $products . '</h3>
                        <p>' . trans('Ecommerce::labels.widget.product') . '</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-product-hunt"></i>
                    </div>
                    <a href="' . url('e-commerce/products') . '" class="small-box-footer">
                        ' . trans('Corals::labels.more_info') . '
                    </a>
                </div>
                </div>';
    }

}