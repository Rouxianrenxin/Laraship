<?php

namespace Corals\Modules\Utility\Http\Controllers\Category;

use Corals\Foundation\Http\Controllers\BaseController;
use Corals\Modules\Classified\Models\Product;
use Corals\Modules\Utility\DataTables\Category\AttributesDataTable;
use Corals\Modules\Utility\Http\Requests\Category\AttributeRequest;
use Corals\Modules\Utility\Models\Category\Attribute;
use Corals\Modules\Utility\Models\Category\AttributeOption;
use Corals\Modules\Utility\Models\Category\Category;

class AttributesController extends BaseController
{
    public function __construct()
    {
        $this->resource_url = config('utility.models.attribute.resource_url');

        $this->title = 'Utility::module.attribute.title';
        $this->title_singular = 'Utility::module.attribute.title_singular';

        parent::__construct();
    }

    /**
     * @param AttributeRequest $request
     * @param AttributesDataTable $dataTable
     * @return mixed
     */
    public function index(AttributeRequest $request, AttributesDataTable $dataTable)
    {
        return $dataTable->render('Utility::category.attributes.index');
    }

    /**
     * @param AttributeRequest $request
     * @return $this
     */
    public function create(AttributeRequest $request)
    {
        $attribute = new Attribute();

        $this->setViewSharedData(['title_singular' => trans('Corals::labels.create_title', ['title' => $this->title_singular])]);

        return view('Utility::category.attributes.create_edit')->with(compact('attribute'));
    }

    /**
     * @param AttributeRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(AttributeRequest $request)
    {
        try {
            $data = $request->except('options');

            $attribute = Attribute::create($data);

            $attribute_options = [];

            $options = $request->get('options', []);

            foreach ($options as $option) {
                $option['attribute_id'] = $attribute->id;
                $attribute_option = AttributeOption::create($option);
                $attribute_options[] = $attribute_option;
            }

            flash(trans('Corals::messages.success.created', ['item' => $this->title_singular]))->success();
        } catch (\Exception $exception) {
            log_exception($exception, Attribute::class, 'store');
        }

        return redirectTo($this->resource_url);
    }

    /**
     * @param AttributeRequest $request
     * @param Attribute $attribute
     * @return Attribute
     */
    public function show(AttributeRequest $request, Attribute $attribute)
    {
        return $attribute;
    }

    /**
     * @param AttributeRequest $request
     * @param Attribute $attribute
     * @return $this
     */
    public function edit(AttributeRequest $request, Attribute $attribute)
    {
        $this->setViewSharedData(['title_singular' => trans('Corals::labels.update_title', ['title' => $attribute->label])]);

        return view('Utility::category.attributes.create_edit')->with(compact('attribute'));
    }

    /**
     * @param AttributeRequest $request
     * @param Attribute $attribute
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(AttributeRequest $request, Attribute $attribute)
    {
        try {
            $data = $request->except('options');

            $attribute->update($data);

            $options = $request->get('options', []);

            $attribute->options()->forceDelete();

            $attribute_options = [];

            foreach ($options as $option) {
                if (!isset($option['option_id'])) {
                    $option['attribute_id'] = $attribute->id;
                    $attribute_option = AttributeOption::create($option);
                } else {
                    $attribute_option = AttributeOption::query()->find($option['option_id']);
                    $attribute_option->update($option);
                }
                $attribute_options[] = $attribute_option;
            }

            flash(trans('Corals::messages.success.updated', ['item' => $this->title_singular]))->success();
        } catch (\Exception $exception) {
            log_exception($exception, Attribute::class, 'update');
        }

        return redirectTo($this->resource_url);
    }

    /**
     * @param AttributeRequest $request
     * @param Attribute $attribute
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(AttributeRequest $request, Attribute $attribute)
    {
        try {
            $attribute->delete();

            $message = ['level' => 'success', 'message' => trans('Corals::messages.success.deleted', ['item' => $this->title_singular])];
        } catch (\Exception $exception) {
            log_exception($exception, Attribute::class, 'destroy');
            $message = ['level' => 'error', 'message' => $exception->getMessage()];
        }

        return response()->json($message);
    }


    public function getCategoryAttributes(AttributeRequest $request, $modelId = null)
    {

        $categories_ids = request()->get('categories_ids', "[]");
        $categories_ids = json_decode(urldecode($categories_ids));
        $modelClass = $request->get('model_class', []);

        if (!is_array($categories_ids)) {
            return '';
        }

        $instance = null;


        $categories = Category::query()->whereIn('id', $categories_ids)->get();

        if (!is_null($modelId) && class_exists($modelClass)) {
            $instance = $modelClass::findByHash($modelId);
        }

        $fields = collect([]);

        foreach ($categories as $category) {
            if ($category->parent_id) {
                $fields = $fields->merge($category->parent->categoryAttributes);
            }
            $fields = $fields->merge($category->categoryAttributes);
        }

        $fields = $fields->unique('id');


        $input = '';
        foreach ($fields as $field) {
            $input .= \Category::renderAttribute($field, $instance, []);
        }

        return response()->json($input);
    }
}