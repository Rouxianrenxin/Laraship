<?php

namespace Corals\Modules\FormBuilder\Transformers;

use Corals\Foundation\Transformers\BaseTransformer;
use Corals\Modules\FormBuilder\Models\FormSubmission;

class FormSubmissionTransformer extends BaseTransformer
{
    public function __construct()
    {
        $this->resource_route = config('form_builder.models.form_submission.resource_route');

        parent::__construct();
    }

    /**
     * @param FormSubmission $formSubmission
     * @return array
     * @throws \Throwable
     */
    public function transform(FormSubmission $formSubmission)
    {
        $form = $formSubmission->form;
        $url = route($this->resource_route, ['form' => $form->hashed_id]);
        $actions = ['edit' => '',
            'view' => [
                'icon' => 'fa fa-eye',
                'href' => $url . '/' . $formSubmission->hashed_id,
                'label' => trans('FormBuilder::labels.form.submission.show'),
                'data' => []
            ],
        ];

        $data = [
            'id' => $formSubmission->id,
            'created_at' => format_date($formSubmission->created_at),
            'updated_at' => format_date($formSubmission->updated_at),
            'action' => $this->actions($formSubmission, $actions, $url)
        ];

        $form_inputs = collect(\FormBuilder::getFormFieldsLabel($form));

        $formSubmission_content = $formSubmission->content;

        $form_data = $form_inputs->mapWithKeys(function ($item) use ($form_inputs, $formSubmission_content) {
            $value = array_get($formSubmission_content, array_search($item, $form_inputs->toArray()), '-');
            return [array_search($item, $form_inputs->toArray()) => $value];
        });

        $data = array_merge($form_data->toArray(), $data);

        return $data;
    }
}