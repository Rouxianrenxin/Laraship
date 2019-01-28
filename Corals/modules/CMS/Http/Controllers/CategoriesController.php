<?php

namespace Corals\Modules\CMS\Http\Controllers;

use Corals\Foundation\Http\Controllers\BaseController;
use Corals\Modules\CMS\DataTables\CategoriesDataTable;
use Corals\Modules\CMS\Http\Requests\CategoryRequest;
use Corals\Modules\CMS\Models\Category;

class CategoriesController extends BaseController
{
    public function __construct()
    {
        $this->resource_url = config('cms.models.category.resource_url');
        $this->title = 'CMS::module.category.title';
        $this->title_singular = 'CMS::module.category.title_singular';

        parent::__construct();
    }

    /**
     * @param CategoryRequest $request
     * @param CategoriesDataTable $dataTable
     * @return mixed
     */
    public function index(CategoryRequest $request, CategoriesDataTable $dataTable)
    {
        return $dataTable->render('CMS::categories.index');
    }

    /**
     * @param CategoryRequest $request
     * @return $this
     */
    public function create(CategoryRequest $request)
    {
        $category = new Category();

        $this->setViewSharedData(['title_singular' => trans('Corals::labels.create_title', ['title' => $this->title_singular])]);

        return view('CMS::categories.create_edit')->with(compact('category'));
    }

    /**
     * @param CategoryRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(CategoryRequest $request)
    {
        try {
            $data = $request->except('subscription_plans');

            $category = Category::create($data);

            if (\Modules::isModuleActive('corals-subscriptions')) {
                $plans = [];

                $subscribable_plans = $request->input('subscription_plans');
                if (is_array($subscribable_plans)) {

                    foreach ($subscribable_plans as $subscribable_plan) {
                        $plans[] = [
                            'plan_id' => $subscribable_plan,
                            'subscribable_id' => $category->id,
                            'subscribable_type' => get_class($category),

                        ];

                    }

                }
                $category->subscribable_plans()->sync($plans);

            }

            flash(trans('Corals::messages.success.created', ['item' => $this->title_singular]))->success();
        } catch (\Exception $exception) {
            log_exception($exception, Category::class, 'store');
        }

        return redirectTo($this->resource_url);
    }

    /**
     * @param CategoryRequest $request
     * @param Category $category
     * @return Category
     */
    public function show(CategoryRequest $request, Category $category)
    {
        return $category;
    }

    /**
     * @param CategoryRequest $request
     * @param Category $category
     * @return $this
     */
    public function edit(CategoryRequest $request, Category $category)
    {
        $this->setViewSharedData(['title_singular' => trans('Corals::labels.update_title', ['title' => $category->name])]);

        return view('CMS::categories.create_edit')->with(compact('category'));
    }

    /**
     * @param CategoryRequest $request
     * @param Category $category
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(CategoryRequest $request, Category $category)
    {
        try {
            $data = $request->except('subscription_plans');


            $category->update($data);

            if (\Modules::isModuleActive('corals-subscriptions')) {
                $plans = [];

                $subscribable_plans = $request->input('subscription_plans');
                if (is_array($subscribable_plans)) {

                    foreach ($subscribable_plans as $subscribable_plan) {
                        $plans[] = [
                            'plan_id' => $subscribable_plan,
                            'subscribable_id' => $category->id,
                            'subscribable_type' => get_class($category),

                        ];

                    }

                }
                $category->subscribable_plans()->sync($plans);

            }


            flash(trans('Corals::messages.success.updated', ['item' => $this->title_singular]))->success();
        } catch (\Exception $exception) {
            log_exception($exception, Category::class, 'update');
        }

        return redirectTo($this->resource_url);
    }

    /**
     * @param CategoryRequest $request
     * @param Category $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(CategoryRequest $request, Category $category)
    {
        try {
            $category->delete();

            $message = ['level' => 'success', 'message' => trans('Corals::messages.success.deleted', ['item' => $this->title_singular])];
        } catch (\Exception $exception) {
            log_exception($exception, Category::class, 'destroy');
            $message = ['level' => 'error', 'message' => $exception->getMessage()];
        }

        return response()->json($message);
    }
}