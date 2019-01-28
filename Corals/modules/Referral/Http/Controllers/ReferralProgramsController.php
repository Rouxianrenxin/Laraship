<?php

namespace Corals\Modules\Referral\Http\Controllers;

use Corals\Foundation\Http\Controllers\BaseController;
use Corals\Modules\Referral\DataTables\ReferralProgramsDataTable;
use Corals\Modules\Referral\Http\Requests\ReferralProgramRequest;
use Corals\Modules\Referral\Models\ReferralProgram;
use Corals\Modules\Referral\Facades\Referral;

class ReferralProgramsController extends BaseController
{
    public function __construct()
    {
        $this->resource_url = config('referral_program.models.referral_program.resource_url');
        $this->title = 'ReferralProgram::module.referral_program.title';
        $this->title_singular = 'ReferralProgram::module.referral_program.title_singular';

        parent::__construct();
    }

    /**
     * @param ReferralProgramRequest $request
     * @param ReferralProgramsDataTable $dataTable
     * @return mixed
     */
    public function index(ReferralProgramRequest $request, ReferralProgramsDataTable $dataTable)
    {
        if (user()->can('Referral::referral_program.update')) {

            return $dataTable->render('ReferralProgram::referral_programs.index');
        } else {

            $referral_programs = ReferralProgram::active()->get();;
            return view('ReferralProgram::referral_programs.view_all')->with(compact('referral_programs', 'action_parameters'));

        }
    }

    /**
     * @param ReferralProgramRequest $request
     * @return $this
     */
    public function create(ReferralProgramRequest $request)
    {
        $referral_program = new ReferralProgram();

        $this->setViewSharedData(['title_singular' => trans('Corals::labels.create_title', ['title' => $this->title_singular])]);


        return view('ReferralProgram::referral_programs.create_edit')->with(compact('referral_program'));
    }


    public function getActionView($action, $edit_mode, ReferralProgram $referral_program)
    {
        try {

            $action_parameters = Referral::prepareActionParameters($action);
            if (view()->exists('ReferralProgram::referral_programs.' . $action . '_action_template')) {
                return view('ReferralProgram::referral_programs.' . $action . '_action_template')->with(compact('referral_program', 'action', 'action_parameters', 'edit_mode'));

            } else {
                return '';
            }
        } catch (\Exception $exception) {
            log_exception($exception, ReferralProgram::class, 'action_template');

        }
    }


    /**
     * @param ReferralProgramRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(ReferralProgramRequest $request)
    {
        try {
            $data = $request->all();
            $referral_program = ReferralProgram::create($data);

            flash(trans('Corals::messages.success.created', ['item' => $this->title_singular]))->success();
        } catch (\Exception $exception) {
            log_exception($exception, ReferralProgram::class, 'store');
        }

        return redirectTo($this->resource_url);
    }

    /**
     * @param ReferralProgramRequest $request
     * @param ReferralProgram $referral_program
     * @return ReferralProgram
     */
    public function show(ReferralProgramRequest $request, ReferralProgram $referral_program)
    {
        $action_parameters = Referral::prepareActionParameters($referral_program->referral_action);
        $this->setViewSharedData(['title_singular' => trans('Corals::labels.show_title', ['title' => $referral_program->name])]);
        $this->setViewSharedData(['edit_url' => $this->resource_url . '/' . $referral_program->hashed_id . '/edit']);
        return view('ReferralProgram::referral_programs.show')->with(compact('referral_program', 'action_parameters'));
    }

    /**
     * @param ReferralProgramRequest $request
     * @param ReferralProgram $referral_program
     * @return $this
     */
    public function edit(ReferralProgramRequest $request, ReferralProgram $referral_program)
    {
        $this->setViewSharedData(['title_singular' => trans('Corals::labels.update_title', ['title' => $referral_program->name])]);


        return view('ReferralProgram::referral_programs.create_edit')->with(compact('referral_program'));
    }

    /**
     * @param ReferralProgramRequest $request
     * @param ReferralProgram $referral_program
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(ReferralProgramRequest $request, ReferralProgram $referral_program)
    {
        try {
            $data = $request->all();

            $referral_program->update($data);

            flash(trans('Corals::messages.success.updated', ['item' => $this->title_singular]))->success();
        } catch (\Exception $exception) {
            log_exception($exception, ReferralProgram::class, 'update');
        }

        return redirectTo($this->resource_url);
    }

    /**
     * @param ReferralProgramRequest $request
     * @param ReferralProgram $referral_program
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(ReferralProgramRequest $request, ReferralProgram $referral_program)
    {
        try {
            $referral_program->delete();

            $message = ['level' => 'success', 'message' => trans('Corals::messages.success.deleted', ['item' => $this->title_singular])];
        } catch (\Exception $exception) {
            log_exception($exception, ReferralProgram::class, 'destroy');
            $message = ['level' => 'error', 'message' => $exception->getMessage()];
        }

        return response()->json($message);
    }
}