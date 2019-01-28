<?php

namespace Corals\Modules\Referral\Http\Controllers;

use Corals\Foundation\Http\Controllers\BaseController;
use Corals\Modules\Referral\DataTables\ReferralRelationshipsDataTable;
use Corals\Modules\Referral\Http\Requests\ReferralRelationshipRequest;
use Corals\Modules\Referral\Models\ReferralProgram;
use Corals\Modules\Referral\Models\ReferralRelationship;
use Corals\Modules\Referral\DataTables\MyReferralsDataTable;
use Illuminate\Http\Request;

class ReferralRelationshipsController extends BaseController
{
    public function __construct()
    {
        $this->resource_url = route(
            config('referral_program.models.referral_relationship.resource_route'),
            ['referral_program' => request()->route('referral_program')]
        );

        $this->title = 'ReferralProgram::module.referral_relationship.title';
        $this->title_singular = 'ReferralProgram::module.referral_relationship.title_singular';

        parent::__construct();
    }

    /**
     * @param ReferralRelationshipRequest $request
     * @param ReferralProgram $referral_program
     * @param ReferralRelationshipsDataTable $dataTable
     * @return mixed
     */
    public function index(ReferralRelationshipRequest $request, ReferralProgram $referral_program, ReferralRelationshipsDataTable $dataTable)
    {
        $this->setViewSharedData(['title' => trans('ReferralProgram::labels.index_title',['name' => $referral_program->name ,'title' => $this->title])]);

        return $dataTable->setResourceUrl($this->resource_url)->render('ReferralProgram::referral_relationships.index', compact('referral_program'));
    }


    /**
     * @param ReferralRelationshipRequest $request
     * @param ReferralRelationship $referralRelationship
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(ReferralRelationshipRequest $request, ReferralRelationship $referralRelationship)
    {
        try {
            $referralRelationship->delete();

            $message = ['level' => 'success', 'message' => trans('Corals::messages.success.deleted', ['item' => trans('ReferralProgram::module.referral_relationship.relationship')])];
        } catch (\Exception $exception) {
            log_exception($exception, ReferralRelationship::class, 'destroy');
            $message = ['level' => 'error', 'message' => $exception->getMessage()];
        }

        return response()->json($message);
    }

    /**
     * @param Request $request
     * @param MyReferralsDataTable $dataTable
     * @return mixed
     */
    public function getUserReferrals(Request $request, MyReferralsDataTable $dataTable)
    {
        $this->setViewSharedData(['title' => $this->title]);

        return $dataTable->setResourceUrl(url('referral/my-referrals'))->render('ReferralProgram::referral_relationships.index');
    }

}