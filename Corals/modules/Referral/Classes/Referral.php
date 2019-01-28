<?php

namespace Corals\Modules\Referral\Classes;


use Corals\Modules\Referral\Models\ReferralLink;
use Corals\Modules\Subscriptions\Models\Product;

class Referral
{
    /**
     * FooBar constructor.
     */
    function __construct()
    {
    }

    public function getActions()
    {

        $actions = ['registration' => trans('ReferralProgram::attributes.referral_action.registration')];
        if (\Modules::isModuleActive('corals-subscriptions')) {
            $actions ['subscription'] = trans('ReferralProgram::attributes.referral_action.subscription');
        }
        if (\Modules::isModuleActive('corals-ecommerce')) {
            $actions ['ecommerce'] = trans('ReferralProgram::attributes.referral_action.ecommerce');
        }
        $actions = \Filters::do_filter('referral_action', $actions);
        return $actions;
    }

    public function prepareActionParameters($action)
    {

        $action_parameters = [];

        if ($action == 'subscription') {
            if (!\Modules::isModuleActive('corals-subscriptions')) {
                throw new \Exception(trans('ReferralProgram::exception.subscription_not_active'));

            }
            $action_parameters['products'] = Product::all();

        }
        $action_parameters = \Filters::do_filter('referral_program_action_parameters', $action_parameters, $action, $this);
        return $action_parameters;
    }

    public static function getReferral($user, $program)
    {
        return ReferralLink::where([
            'user_id' => $user->id,
            'referral_program_id' => $program->id
        ])->first();
    }

}