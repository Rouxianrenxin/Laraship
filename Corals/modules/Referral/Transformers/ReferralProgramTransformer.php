<?php

namespace Corals\Modules\Referral\Transformers;

use Corals\Foundation\Transformers\BaseTransformer;
use Corals\Modules\Referral\Models\ReferralProgram;

class ReferralProgramTransformer extends BaseTransformer
{
    public function __construct()
    {
        $this->resource_url = config('referral_program.models.referral_program.resource_url');

        parent::__construct();
    }

    /**
     * @param ReferralProgram $referral_program
     * @return array
     * @throws \Throwable
     */
    public function transform(ReferralProgram $referral_program)
    {
        $show_url = url($this->resource_url . '/' . $referral_program->hashed_id);

        return [
            'id' => $referral_program->id,
            'name' => '<a href="' . $show_url . '">' . str_limit($referral_program->name, 50) . '</a>',
            'referral_action' => ucfirst($referral_program->referral_action),
            'title' => $referral_program->title,
            'uri' => '<a target="_blank" href="' . url($referral_program->uri) . '">' . $referral_program->uri . '</a>',
            'status' => formatStatusAsLabels($referral_program->status),
            'created_at' => format_date($referral_program->created_at),
            'updated_at' => format_date($referral_program->updated_at),
            'short_code' => $this->getShortcode($referral_program),
            'action' => $this->actions($referral_program, [
                'referral_links' => [
                    'icon' => 'fa fa-link',
                    'href' => url($this->resource_url . '/' . $referral_program->hashed_id . '/referral-relationships'),
                    'label' => trans('ReferralProgram::module.referral_relationship.title'),
                    'data' => []
                ],
            ])
        ];
    }

    protected function getShortcode($referral_program)
    {
        return '<b id="shortcode_' . $referral_program->id . '">@referral_program(' . $referral_program->key . ')</b> 
                <a href="#" onclick="event.preventDefault();" class="copy-button"
                data-clipboard-target="#shortcode_' . $referral_program->id . '"><i class="fa fa-clipboard"></i></a>';
    }
}