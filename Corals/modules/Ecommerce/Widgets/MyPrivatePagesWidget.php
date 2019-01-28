<?php

namespace Corals\Modules\Ecommerce\Widgets;

use \Corals\Modules\Ecommerce\Models\Order;

class MyPrivatePagesWidget
{

    function __construct()
    {
    }

    function run($args)
    {

        $orders = user()->posts->count();
        return ' <!-- small box -->
            <div class="card">
                <div class="small-box bg-blue card-body">
                    <div class="inner">
                        <h3>' . $orders . '</h3>
                        <p>' . trans('Ecommerce::labels.widget.private_page') . '</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-file"></i>
                    </div>
                    <a href="' . url('e-commerce/private-pages/my') . '" class="small-box-footer">
                         ' . trans('Corals::labels.more_info') . '
                    </a>
                </div>
                </div>';
    }

}