<?php

namespace Corals\Modules\CMS\Http\Controllers;

use Corals\Foundation\Http\Controllers\BaseController;
use Corals\Modules\CMS\DataTables\WidgetsDataTable;
use Corals\Modules\CMS\Http\Requests\WidgetRequest;
use Corals\Modules\CMS\Models\Block;
use Corals\Modules\CMS\Models\Widget;
use Illuminate\Http\Request;

class WidgetsController extends BaseController
{
    public function __construct()
    {

        $this->resource_url = route(
            config('cms.models.widget.resource_route'),
            ['block' => request()->route('block')]
        );
        $this->title = 'CMS::module.widget.title';
        $this->title_singular = 'CMS::module.widget.title_singular';

        parent::__construct();
    }

    /**
     * @param widgetRequest $request
     * @param WidgetsDataTable $dataTable
     * @return mixed
     */
    public function index(widgetRequest $request, Block $block, WidgetsDataTable $dataTable)
    {
        $this->setViewSharedData(['title' => trans('CMS::labels.widget.index_title',['block' => $block->name , 'widget' => $this->title])]);
        return $dataTable->setResourceUrl($this->resource_url)->render('CMS::widgets.index', compact('block'));
    }

    /**
     * @param widgetRequest $request
     * @return $this
     */
    public function create(widgetRequest $request, Block $block)
    {
        $widget = new Widget();

        $widget->block_id = $block->id;

        $this->setViewSharedData(['title_singular' => trans('Corals::labels.create_title', ['title' => $this->title_singular])]);

        return view('CMS::widgets.create_edit')->with(compact('widget', 'block'));
    }

    /**
     * @param widgetRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(widgetRequest $request, Block $block)
    {
        try {
            $data = $request->except([]);

            $widget = $block->widgets()->create($data);

            flash(trans('Corals::messages.success.created', ['item' => $this->title_singular]))->success();
        } catch (\Exception $exception) {
            log_exception($exception, Widget::class, 'store');
        }

        return redirectTo($this->resource_url);
    }

    /**
     * @param widgetRequest $request
     * @param Widget $widget
     * @return $this
     */
    public function edit(widgetRequest $request, Block $block, Widget $widget)
    {
        $this->setViewSharedData(['title_singular' => trans('Corals::labels.update_title', ['title' => $widget->title])]);
        return view('CMS::widgets.create_edit')->with(compact('widget', 'block'));
    }

    /**
     * @param widgetRequest $request
     * @param Widget $widget
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(widgetRequest $request, Block $block, Widget $widget)
    {
        try {
            $data = $request->except([]);

            $widget->update($data);

            flash(trans('Corals::messages.success.updated', ['item' => $this->title_singular]))->success();
        } catch (\Exception $exception) {
            log_exception($exception, Post::class, 'update');
        }

        return redirectTo($this->resource_url);
    }

    /**
     * @param WidgetRequest $request
     * @param Widget $widget
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(WidgetRequest $request, Block $block, Widget $widget)
    {
        try {
            $widget->delete();

            $message = ['level' => 'success', 'message' => trans('Corals::messages.success.deleted', ['item' => $this->title_singular])];
        } catch (\Exception $exception) {
            log_exception($exception, Widget::class, 'destroy');
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
                $widget = Widget::find($id);
                $widget->widget_order = $position;
                if ($widget->save()) {
                    $count++;
                }
            }
            $response = [['message' => trans( 'CMS::messages.widget.widget_record_success'), 'level' => 'success']];
            return response()->json($response);
        } else {
            $response = [['message' => trans('CMS::messages.widget.no_change'), 'level' => 'info']];
            return response()->json($response);
        }
    }
}