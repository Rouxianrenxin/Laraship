<?php

namespace Corals\Modules\FormBuilder\Transformers;

use Corals\Foundation\Transformers\BaseTransformer;
use Corals\Modules\FormBuilder\Models\Form;

class FormTransformer extends BaseTransformer
{
    public function __construct()
    {
        $this->resource_url = config('form_builder.models.form.resource_url');

        parent::__construct();
    }

    /**
     * @param Form $form
     * @return array
     * @throws \Throwable
     */
    public function transform(Form $form)
    {
        $show_url = $this->resource_url . '/' . $form->hashed_id;

        $actions = [];

        if (array_has($form->actions, 'database')) {
            $actions['submissions'] = [
                'icon' => 'fa fa-fw fa-send',
                'href' => url($this->resource_url . '/' . $form->hashed_id . '/submissions'),
                'label' => trans('FormBuilder::labels.form.submission.title'),
                'data' => []
            ];
        }

        return [
            'id' => $form->id,
            'name' => '<a href="' . url($show_url) . '">' . $form->name . '</a>',
            'status' => formatStatusAsLabels($form->status),
            'is_public' => $form->is_public ? '<i class="fa fa-check text-success"></i>' : '-',
            'short_code' => $this->getShortcode($form),
            'created_at' => format_date($form->created_at),
            'updated_at' => format_date($form->updated_at),
            'action' => $this->actions($form, $actions)
        ];
    }

    protected function getShortcode($form)
    {
        return '<b id="shortcode_' . $form->id . '">@form(' . $form->short_code . ')</b> 
                <a href="#" onclick="event.preventDefault();" class="copy-button"
                data-clipboard-target="#shortcode_' . $form->id . '"><i class="fa fa-clipboard"></i></a>';
    }
}