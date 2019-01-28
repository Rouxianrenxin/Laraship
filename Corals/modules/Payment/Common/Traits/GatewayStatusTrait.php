<?php

namespace Corals\Modules\Payment\Traits;


use Corals\Modules\Payment\Models\GatewayStatus;
use Corals\Modules\Payment\Payment;

trait GatewayStatusTrait
{
    public function gatewayStatus()
    {
        return $this->morphMany(GatewayStatus::class, 'objectType', 'object_type', 'object_id');
    }

    /**
     * @param $gateway
     * @param $status
     * @param null $message
     * @param null $reference
     */
    public function setGatewayStatus($gateway, $status, $message = null, $reference = null)
    {
        $gateway_status = $this->gatewayStatus()->updateOrCreate([
            'object_id' => $this->getKey(),
            'object_type' => get_class($this),
            'gateway' => $gateway
        ], array_merge([
            'status' => $status,
            'message' => $message
        ], $reference ? ['object_reference' => $reference] : []));
    }

    public function getGatewayStatus($gateway = null)
    {
        $gateways = $this->gatewayStatus();

        if ($gateway) {
            $gateways = $gateways->where('gateway', $gateway)->get();
        } else {
            $gateways = $gateways->get();
        }

        $status = '<ul>';

        if ($gateways->count()) {
            foreach ($gateways as $gateway) {
                $status .= "<li>{$gateway->gateway}: " . $this->formatGatewayStatus($gateway) . '</li>';
            }
        } else {
            $status .= "<li>NA</li>";
        }

        $status = $status . '</ul>';

        return $status;
    }


    public function getGatewayActions($url, $object, $gateway = null)
    {
        $gateways = $this->gatewayStatus();
        $object_class = strtolower(class_basename(get_class($object)));
        if ($gateway) {
            $gateways = $gateways->where('gateway', $gateway)->get();
        } else {
            $gateways = $gateways->get();
        }

        $supported_gateways = \Payments::getAvailableGateways();

        $actions = [];
        if ($gateways->count()) {
            foreach ($gateways as $gateway) {

                if (isset($supported_gateways[$gateway->gateway])) {
                    unset($supported_gateways[$gateway->gateway]);
                }
                if (!in_array($gateway->status, ['NA', 'CREATE_FAILED'])) {
                    continue;
                }

                $actions = array_merge(['create_' . $gateway->gateway => [
                    'icon' => 'fa fa-fw fa-thumbs-o-up',
                    'href' => url($url . '/' . $object->hashed_id . '/create-gateway-' . $object_class . '?gateway=' . $gateway->gateway),
                    'label' => trans('Payment::labels.gateways.create', ['gateway' => $gateway->gateway, 'class' => class_basename($this)]),
                    'data' => [
                        'action' => 'post',
                        'table' => '.dataTableBuilder'
                    ]
                ]], $actions);
            }
        }

        foreach ($supported_gateways as $gateway => $gateway_title) {

            $gatewayObj = Payment::create($gateway);
            if (!$gatewayObj->getConfig('manage_remote_' . $object_class)) {
                continue;
            }

            $actions = array_merge(['create_' . $gateway => [
                'icon' => 'fa fa-fw fa-thumbs-o-up',
                'href' => url($url . '/' . $object->hashed_id . '/create-gateway-' . $object_class . '?gateway=' . $gateway),
                'label' => trans('Payment::labels.gateways.create_title', ['gateway' => $gateway_title, 'class' => class_basename($this)]),
                'data' => [
                    'action' => 'post',
                    'table' => '.dataTableBuilder'
                ]
            ]], $actions);
        }

        return $actions;
    }

    private function formatGatewayStatus($gateway)
    {
        $formatted = $gateway->status;

        switch ($gateway->status) {
            case 'CREATED':
            case 'UPDATED':
            case 'DELETED':
                $formatted = '<i class="fa fa-check-circle-o text-success"></i> ' . ucfirst($gateway->status);
                break;
            case 'CREATE_FAILED':
            case 'UPDATE_FAILED':
            case 'DELETE_FAILED':
                $formatted = generatePopover($gateway->message, ucfirst($gateway->status), 'fa fa-times-circle-o text-danger');
                break;
        }

        return $formatted;
    }
}