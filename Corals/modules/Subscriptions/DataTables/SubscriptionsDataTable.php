<?php

namespace Corals\Modules\Subscriptions\DataTables;

use Corals\Foundation\DataTables\BaseDataTable;
use Corals\Modules\Subscriptions\Facades\Products;
use Corals\Modules\Subscriptions\Models\Subscription;
use Corals\Modules\Subscriptions\Transformers\SubscriptionTransformer;
use Yajra\DataTables\EloquentDataTable;

class SubscriptionsDataTable extends BaseDataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $this->setResourceUrl(config('subscriptions.models.subscription.resource_url'));
        $dataTable = new EloquentDataTable($query);

        return $dataTable->setTransformer(new SubscriptionTransformer());
    }

    /**
     * Get query source of dataTable.
     * @param Subscription $model
     * @return \Illuminate\Database\Eloquent\Builder|static
     */
    public function query(Subscription $model)
    {
        return $model->with('plan')->with('user')->newQuery();
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
            'subscription_reference' => ['title' => trans('Subscriptions::attributes.subscription.subscription_reference')],
            'product_id' => ['title' => trans('Subscriptions::attributes.subscription.product_id'), 'searchable' => false],
            'gateway' => ['title' => trans('Subscriptions::attributes.subscription.gateway')],
            'plan_id' => ['title' => trans('Subscriptions::attributes.subscription.plan_id'), 'searchable' => false],
            'user_id' => ['title' => trans('Subscriptions::attributes.subscription.user_id'), 'searchable' => false],
            'trial_ends_at' => ['title' => trans('Subscriptions::attributes.subscription.trial_ends_at')],
            'ends_at' => ['title' => trans('Subscriptions::attributes.subscription.ends_at')],
            'status' => ['title' => trans('Corals::attributes.status'), 'searchable' => false, 'orderable' => false],
            'on_trial' => ['title' => trans('Subscriptions::attributes.subscription.on_trial'), 'searchable' => false, 'orderable' => false],
            'created_at' => ['title' => trans('Corals::attributes.created_at')],
        ];
    }

    protected function getFilters()
    {
        return [
            'plan_id' => ['title' => trans('Subscriptions::attributes.subscription.plan_id'), 'class' => 'col-md-2', 'type' => 'select2', 'options' => Products::getPlansList(), 'active' => true],
            'plan.product_id' => ['title' => trans('Subscriptions::attributes.subscription.product_id'), 'class' => 'col-md-2', 'type' => 'select2', 'options' => Products::getProductsList(), 'active' => true],
            'user_id' => ['title' => trans('Subscriptions::attributes.subscription.user_id'), 'class' => 'col-md-2', 'type' => 'select2', 'options' => \Users::getUsersList(), 'active' => true],
            'created_at' => ['title' => trans('Corals::attributes.created_at'), 'class' => 'col-md-4', 'type' => 'date_range', 'active' => true],
        ];
    }

    protected function getOptions()
    {
        return ['has_action' => true];
    }
}
