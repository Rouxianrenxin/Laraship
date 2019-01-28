<?php

namespace Corals\Foundation\Transformers;

use League\Fractal\TransformerAbstract;

class BaseTransformer extends TransformerAbstract
{
    protected $resource_url;
    protected $resource_route;

    public function __construct()
    {
    }

    /**
     * @param $model
     * @return string
     */
    public function generateCheckboxElement($model)
    {
        $modelHashedId = $model->hashed_id;

        return '<div class="custom-control custom-checkbox">
               <input type="checkbox" class="datatable-row-checkbox custom-control-input" name="bulk_selected[]" 
               value="' . $modelHashedId . '" id="' . $modelHashedId . '_checkbox" />
               <label class="custom-control-label" for="' . $modelHashedId . '_checkbox"> </label>
               </div>';
    }

    /**
     * @param $model
     * @param array $actions
     * @param null $url
     * @param bool $merge_actions
     * @return string
     * @throws \Throwable
     */
    protected function actions($model, array $actions = [], $url = null, $merge_actions = true)
    {
        if ($url) {
            $resource_url = $url;
        } else {
            $resource_url = $this->resource_url;
        }
        if ($merge_actions) {
            $defaultActions = [];

            if (user()) {
                if (user()->can('update', $model)) {
                    $defaultActions['edit'] = [
                        'href' => url($resource_url . '/' . $model->hashed_id . '/edit'),
                        'label' => trans('Corals::labels.edit'),
                        'data' => []
                    ];
                }

                if (user()->can('destroy', $model)) {
                    $defaultActions['delete'] = [
                        'href' => url($resource_url . '/' . $model->hashed_id),
                        'label' => trans('Corals::labels.delete'),
                        'data' => [
                            'action' => 'delete',
                            'table' => '.dataTableBuilder'
                        ]
                    ];
                }
            }


            $actions = array_merge($defaultActions, $actions);
        }

        $class_name = strtolower(class_basename(get_class($model)));

        $actions = \Filters::do_filter($class_name . '_actions_menu', $actions, $model);

        $actions = array_filter($actions, 'removeEmptyArrayElement');

        if (view()->exists('components.item_actions')) {
            return view('components.item_actions', ['actions' => $actions])->render();
        } else {
            return '';
        }
    }
}