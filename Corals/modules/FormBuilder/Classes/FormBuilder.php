<?php

namespace Corals\Modules\FormBuilder\Classes;

use Corals\Modules\FormBuilder\Models\Form;
use Guzzle\Http\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FormBuilder
{
    /**
     * FormBuilder constructor.
     */
    function __construct()
    {
    }

    public function fillActionData($action, $data)
    {
        if (!$action) {
            abort(400);
        }

        foreach ($data as $key => $field) {
            $action['fields'][$key]['value'] = $field;
        }

        return $action;
    }

    public function getSubmissionValue($submission, $type, $key)
    {
        if (empty($submission)) {
            return null;
        }

        $type = array_get($submission, $type, []);

        $value = array_get($type, $key, null);

        return $value;
    }

    /**
     * @param Request $request
     * @param Form $form
     * @return mixed
     */
    public function submit(Request $request, Form $form)
    {
        try {
            $rules = [];

            foreach ($request->all() as $key => $value) {
                if ($request->hasFile($key)) {
                    $rules[$key] = 'mimes:' . config('form_builder.mimes');
                }
            }

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                $errors = $validator->errors()->toArray();

                $validationMessage = '';

                foreach ($errors as $key => $error) {
                    $error = join('<br/>', $error);
                    $validationMessage .= "{$key}: {$error}<br/>";
                }

                throw new \Exception($validationMessage);
            }

            foreach ($form->actions as $key => $actions) {
                foreach ($actions as $action) {
                    $this->{$key . 'ActionHandler'}($action, $request, $form);
                }
            }

            $success_submission_action = $this->getSubmissionValue($form->submission, 'on_success', 'action');
            $success_submission_content = $this->getSubmissionValue($form->submission, 'on_success', 'content');

            if ($success_submission_action == 'show_message') {
                return response()->json(['message' => $success_submission_content, 'class' => 'alert-success']);
            } elseif ($success_submission_action == 'redirect_to') {
                return redirectTo($success_submission_content);
            }
        } catch (\Exception $exception) {
            $failure_submission_action = $this->getSubmissionValue($form->submission, 'on_failure', 'action');
            $failure_submission_content = $this->getSubmissionValue($form->submission, 'on_failure', 'content');

            if ($failure_submission_action == 'show_message') {
                logger($exception->getTraceAsString());
                $failure_submission_content .= '<br/>' . $exception->getMessage();
                return response()->json(['message' => $failure_submission_content, 'class' => 'alert-danger'], 422);
            } elseif ($failure_submission_action == 'redirect_to') {
                logger($exception->getTraceAsString());
                return redirectTo($failure_submission_content);
            }

            return response()->json(['message' => trans('FormBuilder::exception.form_builder.something_went_wrong'), 'class' => 'alert-danger'], 422);
        }
    }

    /**
     * @param $action
     * @param $request
     * @param $form
     * @throws \Exception
     */
    protected function aweberActionHandler($action, $request, $form)
    {
        $data = $request->except('_token');


        $email_field = array_get($action, 'email_field', null);
        $email = array_get($data, $email_field, null);
        $name_field = array_get($action, 'name_field', null);
        $name = array_get($data, $name_field, null);
        $list = array_get($action, 'list', null);


        if (empty($email_field) || empty($name_field) || empty($list)) {
            throw new \Exception(trans('FormBuilder::exception.form_builder.invalid_parameter'));
        }

        Aweber::subscribe($email, $name, $list);

    }


    /**
     * @param $action
     * @param $request
     * @param $form
     * @throws \Exception
     */
    protected function mailchimpActionHandler($action, $request, $form)
    {
        $data = $request->except('_token');


        $email_field = array_get($action, 'email_field', null);
        $email = array_get($data, $email_field, null);
        $name_field = array_get($action, 'name_field', null);
        $name = array_get($data, $name_field, null);
        $list = array_get($action, 'list', null);


        if (empty($email_field) || empty($name_field) || empty($list)) {
            throw new \Exception(trans('FormBuilder::exception.form_builder.invalid_parameter'));
        }

        Mailchimp::subscribe($email, $name, $list);

    }

    /**
     * @param $action
     * @param $request
     * @param $form
     * @throws \Exception
     */
    protected function covert_commissionsActionHandler($action, $request, $form)
    {
        $data = $request->except('_token');


        $email_field = array_get($action, 'email_field', null);
        $email = array_get($data, $email_field, null);
        $name_field = array_get($action, 'name_field', null);
        $name = array_get($data, $name_field, null);
        $list = array_get($action, 'list', null);


        if (empty($email_field) || empty($name_field) || empty($list)) {
            throw new \Exception(trans('FormBuilder::exception.form_builder.invalid_parameter'));
        }

        CovertCommissions::subscribe($email, $name, $list);

    }


    /**
     * @param $action
     * @param $request
     * @param $form
     * @throws \Exception
     */
    protected function constant_contactActionHandler($action, $request, $form)
    {
        $data = $request->except('_token');


        $email_field = array_get($action, 'email_field', null);
        $email = array_get($data, $email_field, null);
        $name_field = array_get($action, 'name_field', null);
        $name = array_get($data, $name_field, null);
        $list = array_get($action, 'list', null);


        if (empty($email_field) || empty($name_field) || empty($list)) {
            throw new \Exception(trans('FormBuilder::exception.form_builder.invalid_parameter'));
        }

        ConstantContact::subscribe($email, $name, $list);

    }

    /**
     * @param $action
     * @param $request
     * @param $form
     * @throws \Exception
     */
    protected function get_responseActionHandler($action, $request, $form)
    {
        $data = $request->except('_token');


        $email_field = array_get($action, 'email_field', null);
        $email = array_get($data, $email_field, null);
        $name_field = array_get($action, 'name_field', null);
        $name = array_get($data, $name_field, null);
        $list = array_get($action, 'list', null);


        if (empty($email_field) || empty($name_field) || empty($list)) {
            throw new \Exception(trans('FormBuilder::exception.form_builder.invalid_parameter'));
        }

        GetResponse::subscribe($email, $name, $list);

    }

    /**
     * @param $action
     * @param $request
     * @param $form
     * @throws \Exception
     */
    protected function emailActionHandler($action, $request, $form)
    {
        $data = $request->except('_token');

        $to = explode(',', array_get($action, 'to', []));

        $subject = array_get($action, 'subject', null);

        $body = array_get($action, 'body', null);

        if (empty($to) || empty($subject) || empty($body)) {
            throw new \Exception(trans('FormBuilder::exception.form_builder.invalid_parameter'));
        }

        $body = $this->replaceFieldsInContent($body, $data);

        \Mail::send('FormBuilder::emails.submission_email_template', compact('body'),
            function ($message) use ($to, $subject) {
                $message->to($to)
                    ->subject($subject);
            });
    }

    /**
     * @param $action
     * @param $request
     * @param $form
     * @throws \Exception
     */
    protected function apiActionHandler($action, $request, $form)
    {
        $data = $request->except('_token');

        $end_point = array_get($action, 'end_point', null);

        $method = array_get($action, 'method', null);

        $body = array_get($action, 'body', null);

        if (empty($end_point) || empty($method) || empty($body)) {
            throw new \Exception(trans('FormBuilder::exception.form_builder.invalid_parameter'));
        }

        $body = $this->replaceFieldsInContent($body, $data);

        $body = json_decode($body, true);

        $httpClient = new Client();

        if ($method == 'GET') {
            $httpRequest = $httpClient->createRequest($method, $end_point . '?' . http_build_query($body),
                array('Accept' => 'application/json', 'Content-type' => 'application/json'));
        } else {
            $httpRequest = $httpClient->createRequest($method, $end_point,
                array('Accept' => 'application/json', 'Content-type' => 'application/json'),
                json_encode($body, JSON_UNESCAPED_SLASHES)
            );
        }

        $httpResponse = $httpRequest->send();
        // Empty response body should be parsed also as and empty array
//        $responses = $httpResponse->getBody(true);
//        $jsonToArrayResponse = !empty($responses) ? $httpResponse->json() : array();
    }

    /**
     * @param $action
     * @param $request
     * @param $form
     * @throws \Exception
     */
    protected function databaseActionHandler($action, $request, $form)
    {
        $data = $request->except('_token');

        $unique_field = array_get($action, 'unique_field');

        $submissionData = [
            'unique_identifier' => null
        ];

        if (!empty($unique_field)) {
            $unique_field_data = array_get($data, $unique_field, null);

            $unique_submission = $form->submissions()->where('unique_identifier', $unique_field_data)->first();

            if (!$unique_field_data || $unique_submission) {
                throw new \Exception(trans('FormBuilder::exception.form_builder.unique_is_required', ['unique' => $unique_field]));
            }

            $submissionData['unique_identifier'] = $unique_field_data;
        }

        $submissionData['content'] = $data;

        $submissionRecord = $form->submissions()->create($submissionData);

        foreach ($request->all() as $key => $value) {
            if ($request->hasFile($key)) {
                $originalName = $request->file($key)->getClientOriginalName();
                $filename = time() . '-' . $originalName;

                $path = 'uploads/submissions/' . $submissionRecord->id;

                $request->file($key)->move(public_path($path), $filename);

                $content = $submissionRecord->content;

                $content[$key] = '<a href="' . asset($path . '/' . $filename) . '" target="_blank">' . $originalName . '</a>';

                $submissionRecord->content = $content;

                $submissionRecord->save();
            }
        }
    }

    protected function replaceFieldsInContent($content, $data)
    {
        foreach ($data as $key => $field) {
            if (is_array($field)) {
                $field = join(', ', $field);
            }
            $content = preg_replace('/\[' . $key . '\]/', $field, $content);
        }

        return $content;
    }

    /**
     * @param Form $form
     * @return array
     */
    public function getFormFieldsLabel(Form $form, $showOnListOnly = false)
    {
        $labels = [];
        $form_fields = [];
        $formContent = json_decode($form->content, true);

        foreach ($formContent as $formSection) {
            $form_fields = array_merge($form_fields, $formSection);
        }


        $content = collect($form_fields);

        $labeledContent = $content->filter(function ($element) use($showOnListOnly) {
            $type = array_get($element, 'type', false);
            if($showOnListOnly){
                $showInListing = array_get($element, 'showInListing', false);
                return ($type && in_array($type, ['text', 'autocomplete', 'checkbox-group', 'date', 'file', 'number',
                        'radio-group', 'select', 'textarea', 'starRating']) && $showInListing);
            }else{
                return ($type && in_array($type, ['text', 'autocomplete', 'checkbox-group', 'date', 'file', 'number',
                        'radio-group', 'select', 'textarea', 'starRating']) );
            }


        });

        $unLabeledContent = $content->filter(function ($element) {
            $type = array_get($element, 'type', false);
            return ($type && in_array($type, ['hidden']));
        });

        $labels = array_merge($labels, $unLabeledContent->pluck('name', 'name')->toArray());
        $labels = array_merge($labels, $labeledContent->pluck('label', 'name')->toArray());

        return $labels;
    }

    /**
     * @param Form $form
     * @param $attribute
     * @return mixed
     */
    public function getFormFieldsAttribute(Form $form, $attribute)
    {
        $content = collect(json_decode($form->content, true));

        $inputContent = $content->filter(function ($element) {
            $type = array_get($element, 'type', false);
            return ($type && in_array($type, ['text', 'autocomplete', 'checkbox-group', 'date', 'file', 'number',
                    'radio-group', 'select', 'textarea', 'starRating', 'hidden']));
        });

        return $inputContent->pluck($attribute, 'name')->toArray();
    }

    /**
     * @param Form $form
     * @param $attribute
     * @return mixed
     */
    public function getFormEmbedCode(Form $form)
    {
        $code = '<div data-embed-src="' . url('forms/' . $form->hashed_id . '/embed') . '"></div><script type="text/javascript" src="' . asset('assets/corals/plugins/formbuilder/js/embed.js') . '"></script>';

        return '<pre><code id="embed_' . $form->id . '">' . htmlentities($code, ENT_COMPAT, 'UTF-8') . '</code> <a href="#" onclick="event.preventDefault();" class="copy-button"data-clipboard-target="#embed_' . $form->id . '"><i class="fa fa-clipboard"></i></a></pre>';

    }


}