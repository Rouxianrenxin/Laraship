<?php

namespace Corals\Modules\Ecommerce\Http\Controllers;

use Corals\Foundation\Http\Controllers\BaseController;
use Corals\Modules\Ecommerce\DataTables\AttributesDataTable;
use Corals\Modules\Ecommerce\Http\Requests\AttributeRequest;
use Corals\Modules\Ecommerce\Models\Attribute;
use Corals\Modules\Ecommerce\Models\AttributeOption;

class AttributesController extends BaseController
{
    public function __construct()
    {
        $this->resource_url = config('ecommerce.models.attribute.resource_url');
        $this->title = 'Ecommerce::module.attribute.title';
        $this->title_singular = 'Ecommerce::module.attribute.title_singular';

        parent::__construct();
    }

    /**
     * @param AttributeRequest $request
     * @param AttributesDataTable $dataTable
     * @return mixed
     */
    public function index(AttributeRequest $request, AttributesDataTable $dataTable)
    {
        return $dataTable->render('Ecommerce::attributes.index');
    }

    /**
     * @param AttributeRequest $request
     * @return $this
     */
    public function create(AttributeRequest $request)
    {
        $attribute = new Attribute();

        $this->setViewSharedData(['title_singular' => trans('Corals::labels.create_title', ['title' => $this->title_singular])]);

        return view('Ecommerce::attributes.create_edit')->with(compact('attribute'));
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

        return view('Ecommerce::attributes.create_edit')->with(compact('attribute'));
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

            $attribute->options()->delete();

            $attribute_options = [];

            foreach ($options as $option) {
                if (!isset($option['option_id'])) {
                    $option['attribute_id'] = $attribute->id;
                    $attribute_option = AttributeOption::create($option);
                } else {
                    $attribute_option = AttributeOption::find($option['option_id']);
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
}