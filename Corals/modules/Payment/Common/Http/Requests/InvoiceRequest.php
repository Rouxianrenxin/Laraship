<?php

namespace Corals\Modules\Payment\Http\Requests;

use Corals\Foundation\Http\Requests\BaseRequest;
use Corals\Modules\Payment\Models\Invoice;

class InvoiceRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $this->setModel(Invoice::class);

        return $this->isAuthorized();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $this->setModel(Invoice::class);
        $rules = parent::rules();

        if ($this->isUpdate() || $this->isStore()) {
            $rules = array_merge($rules, [
                'status' => 'required',
                'currency' => 'required',
                'total' => 'required|numeric|min:0.01',
                'sub_total' => 'required|numeric|min:0.01',
                'user_id' => 'required',
                'due_date' => 'required',
            ]);
        }


        if ($this->isStore()) {
            $rules = array_merge($rules, [
                'code' => 'required|max:191|unique:invoices,code'
            ]);
        }

        if ($this->isUpdate()) {
            $invoice = $this->route('invoice');
            $rules = array_merge($rules, [
                'code' => 'required|max:191|unique:invoices,code,' . $invoice->id,
            ]);
        }

        return $rules;
    }
}
