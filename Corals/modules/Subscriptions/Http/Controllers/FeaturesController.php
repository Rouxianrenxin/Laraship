<?php

namespace Corals\Modules\Subscriptions\Http\Controllers;

use Corals\Foundation\Http\Controllers\BaseController;
use Corals\Modules\Subscriptions\DataTables\FeaturesDataTable;
use Corals\Modules\Subscriptions\Http\Requests\FeatureRequest;
use Corals\Modules\Subscriptions\Models\Feature;
use Corals\Modules\Subscriptions\Models\Product;
use Illuminate\Http\Request;

class FeaturesController extends BaseController
{
    public function __construct()
    {
        $this->resource_url = route(
            config('subscriptions.models.feature.resource_route'),
            ['product' => request()->route('product')]
        );

        $this->title = 'Subscriptions::module.feature.title';
        $this->title_singular ='Subscriptions::module.feature.title_singular';

        parent::__construct();
    }

    /**
     * @param FeatureRequest $request
     * @param Product $product
     * @param FeaturesDataTable $dataTable
     * @return mixed
     */
    public function index(FeatureRequest $request, Product $product, FeaturesDataTable $dataTable)
    {
        $this->setViewSharedData(['title' => trans('Subscriptions::labels.feature.index_title',['name' => $product->name ,'title' => $this->title])]);

        return $dataTable->render('Subscriptions::features.index', compact('product'));
    }

    /**
     * @param FeatureRequest $request
     * @param Product $product
     * @return $this
     */
    public function create(FeatureRequest $request, Product $product)
    {
        $feature = new Feature();

        $this->setViewSharedData(['title_singular' => trans('Corals::labels.create_title', ['title' => $this->title_singular])]);

        return view('Subscriptions::features.create_edit')->with(compact('feature', 'product'));
    }

    /**
     * @param FeatureRequest $request
     * @param Product $product
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(FeatureRequest $request, Product $product)
    {
        try {
            $data = $request->all();

            $feature = $product->features()->create($data);

            flash(trans('Corals::messages.success.created', ['item' => $this->title_singular]))->success();
        } catch (\Exception $exception) {
            log_exception($exception, Feature::class, 'store');
        }

        return redirectTo($this->resource_url);
    }

    /**
     * @param FeatureRequest $request
     * @param Product $product
     * @param Feature $feature
     * @return $this
     */
    public function show(FeatureRequest $request, Product $product, Feature $feature)
    {
        $this->setViewSharedData(['title_singular' => trans('Corals::labels.show_title', ['title' => $feature->name])]);
        $this->setViewSharedData(['edit_url' => $this->resource_url . '/' . $feature->hashed_id . '/edit']);
        return view('Subscriptions::features.show')->with(compact('feature', 'product'));
    }

    /**
     * @param FeatureRequest $request
     * @param Product $product
     * @param Feature $feature
     * @return $this
     */
    public function edit(FeatureRequest $request, Product $product, Feature $feature)
    {
        $this->isEditable($feature);

        $this->setViewSharedData(['title_singular' => trans('Corals::labels.update_title', ['title' => $feature->name])]);

        return view('Subscriptions::features.create_edit')->with(compact('feature', 'product'));
    }

    protected function isEditable(Feature $feature)
    {
        if ($feature->status == 'deleted' || $feature->product->status == 'deleted') {
            abort(404);
        }
    }

    /**
     * @param FeatureRequest $request
     * @param Product $product
     * @param Feature $feature
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(FeatureRequest $request, Product $product, Feature $feature)
    {
        $this->isEditable($feature);

        try {
            $data = $request->all();

            $feature->update($data);

            flash(trans('Corals::messages.success.updated', ['item' => $this->title_singular]))->success();
        } catch (\Exception $exception) {
            log_exception($exception, Feature::class, 'update');
        }

        return redirectTo($this->resource_url);
    }

    /**
     * @param FeatureRequest $request
     * @param Product $product
     * @param Feature $feature
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(FeatureRequest $request, Product $product, Feature $feature)
    {
        try {
            $feature->delete();

            $message = ['level' => 'success', 'message' => trans('Corals::messages.success.deleted', ['item' => $this->title_singular])];
        } catch (\Exception $exception) {
            log_exception($exception, Feature::class, 'destroy');
            $message = ['level' => 'error', 'message' => $exception->getMessage()];
        }

        return response()->json($message);
    }

    public function reorder(Request $request)
    {
        $count = 0;

        if (count($request->json()->all())) {
            $ids = $request->json()->all();
            foreach ($ids as $i => $key) {
                $id = $key['id'];
                $position = $key['position'];
                $feature = Feature::find($id);
                $feature->display_order = $position;
                if ($feature->save()) {
                    $count++;
                }
            }
            $response = [['message' => trans('Subscriptions::labels.feature.feature_record_success'), 'level' => 'success']];
            return response()->json($response);
        } else {
            $response = [['message' => trans('Subscriptions::labels.feature.no_change'), 'level' => 'info']];
            return response()->json($response);
        }
    }
}