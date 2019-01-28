<?php

namespace Corals\Modules\Slider\Http\Controllers;

use Corals\Foundation\Http\Controllers\BaseController;
use Corals\Modules\Slider\DataTables\SlidersDataTable;
use Corals\Modules\Slider\Http\Requests\SliderRequest;
use Corals\Modules\Slider\Models\Slider;

class SlidersController extends BaseController
{
    public function __construct()
    {
        $this->resource_url = config('slider.models.slider.resource_url');
        $this->title = 'Slider::module.slider.title';
        $this->title_singular = 'Slider::module.slider.title_singular';

        parent::__construct();
    }

    /**
     * @param SliderRequest $request
     * @param SlidersDataTable $dataTable
     * @return mixed
     */
    public function index(SliderRequest $request, SlidersDataTable $dataTable)
    {
        return $dataTable->render('Slider::sliders.index');
    }

    /**
     * @param SliderRequest $request
     * @return $this
     */
    public function create(SliderRequest $request)
    {
        $slider = new Slider();

        $this->setViewSharedData(['title_singular' => trans('Corals::labels.create_title', ['title' => $this->title_singular])]);

        $options = \Corals\Modules\Slider\Facades\Slider::getSliderDefaultOptions(0);


        return view('Slider::sliders.create_edit')->with(compact('slider', 'options'));
    }

    /**
     * @param SliderRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(SliderRequest $request)
    {
        try {
            $data = $request->all();

            $default_options_default_values = \Corals\Modules\Slider\Facades\Slider::getSliderDefaultOptions(0)->pluck('default', 'key')->toArray();
            $default_options_types = \Corals\Modules\Slider\Facades\Slider::getSliderDefaultOptions(0)->pluck('type', 'key')->toArray();

            foreach ($data['init_options'] as $slider_option_key => $slider_option_value) {
                if (is_null($slider_option_value[$default_options_types[$slider_option_key]])) {
                    $data['init_options'][$slider_option_key][$default_options_types[$slider_option_key]] = $default_options_default_values[$slider_option_key];
                }
            }
            $slider = Slider::create($data);

            flash(trans('Corals::messages.success.created', ['item' => $this->title_singular]))->success();
        } catch (\Exception $exception) {
            log_exception($exception, Slider::class, 'store');
        }

        return redirectTo($this->resource_url);
    }

    /**
     * @param SliderRequest $request
     * @param Slider $slider
     * @return Slider
     */
    public function show(SliderRequest $request, Slider $slider)
    {
        $this->setViewSharedData(['title_singular' =>trans('Corals::labels.show_title', ['title' => $slider->name])]);
        $this->setViewSharedData(['edit_url' => $this->resource_url . '/' . $slider->hashed_id . '/edit']);
        return view('Slider::sliders.show')->with(compact('slider'));
    }

    /**
     * @param SliderRequest $request
     * @param Slider $slider
     * @return $this
     */
    public function edit(SliderRequest $request, Slider $slider)
    {
        $this->setViewSharedData(['title_singular' => trans('Corals::labels.update_title', ['title' => $slider->name])]);

        $options = \Corals\Modules\Slider\Facades\Slider::getSliderDefaultOptions(0);

        return view('Slider::sliders.create_edit')->with(compact('slider', 'options'));
    }

    /**
     * @param SliderRequest $request
     * @param Slider $slider
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(SliderRequest $request, Slider $slider)
    {
        try {
            $data = $request->all();
            $default_options_default_values = \Corals\Modules\Slider\Facades\Slider::getSliderDefaultOptions(0)->pluck('default', 'key')->toArray();
            $default_options_types = \Corals\Modules\Slider\Facades\Slider::getSliderDefaultOptions(0)->pluck('type', 'key')->toArray();

            foreach ($data['init_options'] as $slider_option_key => $slider_option_value) {
                if (is_null($slider_option_value[$default_options_types[$slider_option_key]])) {
                    $data['init_options'][$slider_option_key][$default_options_types[$slider_option_key]] = $default_options_default_values[$slider_option_key];
                }
            }

            $slider->update($data);

            flash(trans('Corals::messages.success.updated', ['item' => $this->title_singular]))->success();
        } catch (\Exception $exception) {
            log_exception($exception, Slider::class, 'update');
        }

        return redirectTo($this->resource_url);
    }

    /**
     * @param SliderRequest $request
     * @param Slider $slider
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(SliderRequest $request, Slider $slider)
    {
        try {
            $slider->delete();

            $message = ['level' => 'success', 'message' => trans('Corals::messages.success.deleted', ['item' => $this->title_singular])];
        } catch (\Exception $exception) {
            log_exception($exception, Slider::class, 'destroy');
            $message = ['level' => 'error', 'message' => $exception->getMessage()];
        }

        return response()->json($message);
    }
}