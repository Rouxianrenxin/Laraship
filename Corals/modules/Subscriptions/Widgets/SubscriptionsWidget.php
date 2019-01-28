<?php

namespace Corals\Modules\Subscriptions\Widgets;

use \Corals\Modules\Subscriptions\Models\Subscription;

class SubscriptionsWidget
{

    function __construct()
    {
    }

    function run($args)
    {

        $subscriptions = Subscription::count();
        return ' <!-- small box -->
                <div class="card">
                    <div class="small-box bg-aqua card-body">
                        <div class="inner">
                            <h3>' . $subscriptions . '</h3>
                            <p>' . trans('Subscriptions::labels.widget.subscription') . '</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-shopping-cart"></i>
                        </div>
                        <a href="' . url('subscriptions') . '" class="small-box-footer">
                            ' . trans('Subscriptions::labels.widget.more_info') . '
                        </a>
                    </div>
               </div>';
    }

}