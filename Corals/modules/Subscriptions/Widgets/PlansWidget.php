<?php

namespace Corals\Modules\Subscriptions\Widgets;

use \Corals\Modules\Subscriptions\Models\Plan;

class PlansWidget
{

    function __construct()
    {
    }

    function run($args)
    {

        $plans = Plan::count();
        return ' <!-- small box -->
                 <div class="card">
                <div class="small-box bg-green card-body">
                    <div class="inner">
                        <h3>' . $plans . '</h3>
                        <p>' . trans('Subscriptions::labels.widget.plan') . '</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-tasks"></i>
                    </div>
                    <a href="' . url('subscriptions/products') . '" class="small-box-footer">
                        ' . trans('Subscriptions::labels.widget.more_info') . '
                    </a>
                </div>
                </div>';
    }

}