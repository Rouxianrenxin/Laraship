<?php

namespace Corals\Modules\Slider\Http\Controllers;

use Corals\Foundation\Http\Controllers\BaseController;
use Corals\Modules\Slider\DataTables\SlidesDataTable;
use Corals\Modules\Slider\Http\Requests\SlideRequest;
use Corals\Modules\Slider\Models\Slide;
use Corals\Modules\Slider\Models\Slider;

class SlidesController extends BaseController
{
    public function __construct()
    {
        $this->resource_url = route(
            config('slider.models.slide.resource_route'),
            ['slider' => request()->route('slider')]
        );

        $this->title = 'Slider::module.slide.title';
        $this->title_singular = 'Slider::module.slide.title_singular';

        parent::__construct();
    }

    /**
     * @param SlideRequest $request
     * @param Slider $slider
     * @param SlidesDataTable $dataTable
     * @return mixed
     */
    public function index(SlideRequest $request, Slider $slider, SlidesDataTable $dataTable)
    {
        $this->setViewSharedData(['title' => trans('Slider::labels.slide.index_title',['slider' => $slider->name , 'slide' => $this->title])]);

        return $dataTable->setResourceUrl($this->resource_url)->render('Slider::slides.index', compact('slider'));
    }

    /**
     * @param SlideRequest $request
     * @param Slider $slider
     * @return $this
     */
    public function create(SlideRequest $request, Slider $slider)
    {
        $slide = new Slide();

        $slide->slider_id = $slider->id;

        $this->setViewSharedData(['title_singular' => trans('Corals::labels.create_title', ['title' => $this->title_singular])]);

        return view('Slider::slides.create_edit')->with(compact('slide', 'slider'));
    }

    /**
     * @param SlideRequest $request
     * @param Slider $slider
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(SlideRequest $request, Slider $slider)
    {
        try {
            $data = $request->except('link');

            if ($request->has('link')) {
                $data['content'] = $request->link;
            }

            $slide = $slider->slides()->create($data);

            if ($request->hasFile('content')) {
                $media = $slide->addMedia($request->file('content'))->toMediaCollection('slide-content');
                $slide->content = $media->getUrl();
                $slide->save();
            }

            flash(trans('Corals::messages.success.created', ['item' => $this->title_singular]))->success();
        } catch (\Exception $exception) {
            log_exception($exception, Slide::class, 'store');
        }

        return redirectTo($this->resource_url);
    }

    /**
     * @param SlideRequest $request
     * @param Slider $slider
     * @param Slide $slide
     * @return $this
     */
    public function show(SlideRequest $request, Slider $slider, Slide $slide)
    {
        $this->setViewSharedData(['title_singular' => trans('Corals::labels.show_title', ['title' => $slide->name])]);
        $this->setViewSharedData(['edit_url' => $this->resource_url . '/' . $slide->hashed_id . '/edit']);
        return view('Slider::slides.show')->with(compact('slide', 'slider'));
    }

    /**
     * @param SlideRequest $request
     * @param Slider $slider
     * @param Slide $slide
     * @return $this
     */
    public function edit(SlideRequest $request, Slider $slider, Slide $slide)
    {
        $this->setViewSharedData(['title_singular' => trans('Corals::labels.update_title', ['title' => $slide->name])]);

        return view('Slider::slides.create_edit')->with(compact('slide', 'slider'));
    }

    /**
     * @param SlideRequest $request
     * @param Slider $slider
     * @param Slide $slide
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(SlideRequest $request, Slider $slider, Slide $slide)
    {
        try {
            $data = $request->except('link');

            if ($request->has('link')) {
                $data['content'] = $request->link;
            }

            $slide->update($data);

            if ($request->hasFile('content')) {
                $slide->clearMediaCollection('slide-content');

                $media = $slide->addMedia($request->file('content'))->toMediaCollection('slide-content');

                $slide->content = $media->getUrl();
                $slide->save();
            }

            flash(trans('Corals::messages.success.updated', ['item' => $this->title_singular]))->success();
        } catch (\Exception $exception) {
            log_exception($exception, Slide::class, 'update');
        }

        return redirectTo($this->resource_url);
    }

    /**
     * @param SlideRequest $request
     * @param Slider $slider
     * @param Slide $slide
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(SlideRequest $request, Slider $slider, Slide $slide)
    {
        try {
            $slide->clearMediaCollection('slide-content');
            $slide->delete();

            $message = ['level' => 'success', 'message' => trans('Corals::messages.success.deleted', ['item' => $this->title_singular])];
        } catch (\Exception $exception) {
            log_exception($exception, Slide::class, 'destroy');
            $message = ['level' => 'error', 'message' => $exception->getMessage()];
        }

        return response()->json($message);
    }
}