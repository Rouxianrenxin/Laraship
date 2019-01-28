<?php

namespace Corals\Modules\Directory\Http\Controllers;

use Corals\Foundation\Http\Controllers\BaseController;
use Corals\Modules\Directory\Models\Listing;
use Corals\Modules\Directory\Models\Claim;
use Corals\Modules\Directory\Http\Requests\ClaimRequest;
use Corals\Modules\Directory\DataTables\ClaimsDataTable;
use Illuminate\Http\Request;

class ClaimController extends BaseController
{
    protected $excludedRequestParams = ['claim_file'];

    public function __construct()
    {
        $this->resource_url = config('directory.models.listing.resource_url');

        $this->title = 'Directory::module.claim.title';
        $this->title_singular = 'Directory::module.claim.title_singular';

        parent::__construct();
    }

    /**
     * @param ClaimRequest $request
     * @param ClaimsDataTable $dataTable
     * @return mixed
     */
    public function index(ClaimRequest $request, ClaimsDataTable $dataTable)
    {
        return $dataTable->render('Directory::claims.index');
    }

    public function store(ClaimRequest $request, Listing $listing)
    {
        try {

            $data = $request->except($this->excludedRequestParams);

            $data['created_by'] = user()->id;
            $data['listing_id'] = $listing->id;

            $claim = Claim::create($data);

            if ($request->hasFile('claim_file')) {
                $claim->addMedia($request->file('claim_file'))
                    ->withCustomProperties(['root' => 'user_' . user()->hashed_id])
                    ->toMediaCollection($claim->mediaCollectionName);
            }

            event('notifications.directory.listing_claim', ['listing' => $listing, 'user' => $claim->user, 'claim' => $claim]);

            $message = ['level' => 'success', 'message' => trans('Directory::messages.success.listing_claim', ['item' => $this->title_singular])];
        } catch (\Exception $exception) {
            log_exception($exception, Claim::class, 'store');
            $message = ['level' => 'error', 'message' => $exception->getMessage()];
        }

        return response()->json($message);

    }

    public function show(Claim $claim)
    {
        return view('Directory::claims.show')->with(compact('claim'));
    }

    public function declineReasons(Claim $claim)
    {
        return view('Directory::claims.decline')->with(compact('claim'));
    }

    public function toggleStatus(Request $request, Claim $claim, $status)
    {
        try {
            if (user()->can('updateStatus', [$claim, $status])) {
                $claim->update([
                    'status' => $status,
                ]);
            } else {
                abort(403);
            }

            if ($status == 'approved') {
                $claim->listing->update([
                    'user_id' => $claim->created_by
                ]);

                event('notifications.directory.claim_approved_status', [
                    'claim' => $claim,
                    'user' => $claim->user
                ]);
            } elseif ($status == 'declined') {
                $reasons = $request->get('reasons') ?? null;

                $claim->listing->update([
                    'user_id' => null
                ]);

                event('notifications.directory.claim_decline_status', [
                    'claim' => $claim,
                    'user' => $claim->user,
                    'reasons' => $reasons,
                ]);
            }

            $message = ['level' => 'success', 'message' => trans('Directory::messages.success.claim_status', ['item' => $this->title_singular])];
        } catch (\Exception $exception) {
            log_exception($exception, Claim::class, 'store');
            $message = ['level' => 'error', 'message' => $exception->getMessage()];
        }

        return response()->json($message);
    }

    /**
     * @param ClaimRequest $request
     * @param Claim $claim
     * @return \Illuminate\Http\JsonResponse
     */

    public function destroy(ClaimRequest $request, Claim $claim)
    {
        try {
            $claim->delete();

            $message = ['level' => 'success', 'message' => trans('Corals::messages.success.deleted', ['item' => $this->title_singular])];
        } catch (\Exception $exception) {
            log_exception($exception, Claim::class, 'destroy');
            $message = ['level' => 'error', 'message' => $exception->getMessage()];
        }

        return response()->json($message);
    }
}
