<?php

namespace Corals\Modules\Subscriptions\Http\Controllers;

use Corals\Foundation\Http\Controllers\BaseController;
use Corals\Modules\Subscriptions\Classes\Subscription;
use Corals\Modules\Subscriptions\DataTables\PlansDataTable;
use Corals\Modules\Subscriptions\Http\Requests\PlanRequest;
use Corals\Modules\Subscriptions\Models\Plan;
use Corals\Modules\Subscriptions\Models\Product;
use Illuminate\Http\Request;

class PlansController extends BaseController
{
    public function __construct()
    {
        $this->resource_url = route(
            config('subscriptions.models.plan.resource_route'),
            ['product' => request()->route('product')]
        );

        $this->title = 'Subscriptions::module.plan.title';
        $this->title_singular = 'Subscriptions::module.plan.title_singular';

        parent::__construct();
    }

    /**
     * @param PlanRequest $request
     * @param Product $product
     * @param PlansDataTable $dataTable
     * @return mixed
     */
    public function index(PlanRequest $request, Product $product, PlansDataTable $dataTable)
    {
        $this->setViewSharedData(['title' => trans('Subscriptions::labels.plan.index_title', ['name' => $product->name, 'title' => $this->title])]);

        return $dataTable->render('Subscriptions::plans.index', compact('product'));
    }

    /**
     * @param PlanRequest $request
     * @param Product $product
     * @return $this
     */
    public function create(PlanRequest $request, Product $product)
    {
        $plan = new Plan();

        $this->setViewSharedData(['title_singular' => trans('Corals::labels.create_title', ['title' => $this->title_singular])]);

        return view('Subscriptions::plans.create_edit')->with(compact('plan', 'product'));
    }

    /**
     * @param PlanRequest $request
     * @param Product $product
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(PlanRequest $request, Product $product)
    {
        try {
            $data = $request->except('features', 'create_gateway_plan');

            $plan = $product->plans()->create($data);

            $plan->features()->sync($request->features);


            if ($request->has('create_gateway_plan') && !$plan->free_plan) {
                $this->createUpdateGatewayPlanSend($plan);
            }

            flash(trans('Corals::messages.success.created', ['item' => $this->title_singular]))->success();
        } catch (\Exception $exception) {
            log_exception($exception, Plan::class, 'store');
        }

        return redirectTo($this->resource_url);
    }

    public function createGatewayPlan(Request $request, Product $product, Plan $plan)
    {
        $gateway = $request->get('gateway');
        user()->can('Subscriptions::plan.create', Plan::class);

        if ($plan->free_plan) {
            abort(403);
        }

        try {
            $this->createUpdateGatewayPlanSend($plan, $gateway);

            $message = ['level' => 'success', 'message' => trans('Corals::messages.success.created', ['item' => $this->title_singular])];
        } catch (\Exception $exception) {
            log_exception($exception, Plan::class, 'createGatewayPlan');
            $message = ['level' => 'error', 'message' => $exception->getMessage()];
        }

        return response()->json($message);
    }

    /**
     * @param Plan $plan
     * @param null $gateway
     * @return bool
     * @throws \Exception
     */
    protected function createUpdateGatewayPlanSend(Plan $plan, $gateway = null)
    {

        if ($gateway) {
            $subscription = new Subscription($gateway);
            if (!$subscription->gateway->getConfig('manage_remote_plan')) {
                return true;
            }
            if ($subscription->gateway->getPlanIntegrationId($plan)) {
                if (!$subscription->fetchPlan($plan, $gateway)) {
                    $subscription->createPlan($plan);
                } else {
                    $subscription->updatePlan($plan);
                }
            } else {
                $subscription->createPlan($plan);
            }


        } else {
            $exceptionMessage = '';
            foreach (\Payments::getAvailableGateways() as $gateway => $gateway_title) {

                try {
                    $subscription = new Subscription($gateway);
                    if (!$subscription->gateway->getConfig('manage_remote_plan')) {
                        continue;
                    }
                    if (!$subscription->fetchPlan($plan, $gateway)) {
                        $subscription->createPlan($plan);
                    } else {
                        $subscription->updatePlan($plan);
                    }
                } catch (\Exception $exception) {
                    $exceptionMessage .= $exception->getMessage();
                }
            }
            if (!empty($exceptionMessage)) {
                throw new \Exception($exceptionMessage);
            }
        }
    }

    /**
     * @param PlanRequest $request
     * @param Product $product
     * @param Plan $plan
     * @return $this
     */
    public function show(PlanRequest $request, Product $product, Plan $plan)
    {
        $this->setViewSharedData(['title_singular' => trans('Corals::labels.show_title', ['title' => $plan->name])]);
        $this->setViewSharedData(['edit_url' => $this->resource_url . '/' . $plan->hashed_id . '/edit']);
        return view('Subscriptions::plans.show')->with(compact('plan', 'product'));
    }

    /**
     * @param PlanRequest $request
     * @param Product $product
     * @param Plan $plan
     * @return $this
     */
    public function edit(PlanRequest $request, Product $product, Plan $plan)
    {
        $this->isEditable($plan);

        $this->setViewSharedData(['title_singular' => trans('Corals::labels.update_title', ['title' => $plan->name])]);

        return view('Subscriptions::plans.create_edit')->with(compact('plan', 'product'));
    }

    protected function isEditable(Plan $plan)
    {
        if ($plan->status == 'deleted' || $plan->product->status == 'deleted') {
            abort(404);
        }
    }

    /**
     * @param PlanRequest $request
     * @param Product $product
     * @param Plan $plan
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(PlanRequest $request, Product $product, Plan $plan)
    {
        $this->isEditable($plan);

        try {
            $exceptFields = ['code', 'price', 'bill_frequency', 'bill_cycle', 'free_plan', 'features'];

            $data = $request->except($exceptFields);

            $plan->update($data);

            $plan->features()->sync($request->features);

            if (!$plan->free_plan) {
                $this->createUpdateGatewayPlanSend($plan);
            }

            flash(trans('Corals::messages.success.updated', ['item' => $this->title_singular]))->success();
        } catch (\Exception $exception) {
            log_exception($exception, Plan::class, 'update');
        }

        return redirectTo($this->resource_url);
    }

    /**
     * @param PlanRequest $request
     * @param Product $product
     * @param Plan $plan
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(PlanRequest $request, Product $product, Plan $plan)
    {
        try {
            if ($plan->subscriptions->count() > 0) {
                $plan->update(['status' => 'deleted']);
                if (!$plan->free_plan) {

                    foreach (\Payments::getAvailableGateways() as $gateway => $gateway_title) {
                        $subscription = new Subscription($gateway);

                        if (!$subscription->gateway->getConfig('manage_remote_plan')) {
                            continue;
                        }
                        $subscription->deletePlan($plan, $gateway);
                    }
                }

            } else {
                $plan->delete();
            }

            $message = ['level' => 'success', 'message' => trans('Corals::messages.success.deleted', ['item' => $this->title_singular])];


        } catch (\Exception $exception) {
            log_exception($exception, Plan::class, 'destroy');
            $message = ['level' => 'error', 'message' => $exception->getMessage()];
        }

        return response()->json($message);
    }
}
