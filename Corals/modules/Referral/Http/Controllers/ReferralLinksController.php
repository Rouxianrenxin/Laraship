<?php

namespace Corals\Modules\Referral\Http\Controllers;

use Corals\Foundation\Http\Controllers\BaseController;
use Corals\Modules\Referral\Http\Requests\ReferralLinkRequest;
use Corals\Modules\Referral\Models\ReferralLink;
use Corals\Modules\Referral\Models\ReferralProgram;

class ReferralLinksController extends BaseController
{
    public function __construct()
    {
        $this->resource_url = route(
            config('referral_program.models.referral_link.resource_route'),
            ['referral_program' => request()->route('referral_program')]
        );

        $this->title = 'ReferralProgram::module.referral_link.title';
        $this->title_singular = 'ReferralProgram::module.referral_link.title_singular';

        parent::__construct();
    }

    /**
     * @param ReferralLinkRequest $request
     * @param ReferralProgram $referral_program
     * @return $this
     */
    public function create(ReferralLinkRequest $request, ReferralProgram $referral_program)
    {
        $referral_link = new ReferralLink();

        $referral_link->referral_program_id = $referral_program->id;

        $this->setViewSharedData(['title_singular' => trans('Corals::labels.create_title', ['title' => $this->title_singular])]);

        return view('ReferralProgram::referral_links.create_edit')->with(compact('referral_link', 'referral_program'));
    }

    /**
     * @param ReferralLinkRequest $request
     * @param ReferralProgram $referral_program
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(ReferralLinkRequest $request, ReferralProgram $referral_program)
    {
        try {
            $data['user_id'] = user()->id;
            $data['referral_program_id'] = $referral_program->id;

            $referral_program->referral_links()->create($data);

            flash(trans('Corals::messages.success.created', ['item' => $this->title_singular]))->success();
        } catch (\Exception $exception) {
            log_exception($exception, ReferralLink::class, 'store');
        }

        return redirectTo(config('referral_program.models.referral_program.resource_url'));
    }
}