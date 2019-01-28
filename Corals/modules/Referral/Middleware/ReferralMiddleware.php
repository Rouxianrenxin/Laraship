<?php

namespace Corals\Modules\Referral\Middleware;

use Closure;
use Corals\Modules\Referral\Models\ReferralLink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class ReferralMiddleware
{
    /**
     * @param $request
     * @param Closure $next
     * @param null $guard
     * @return mixed
     */
    public function handle(Request $request, \Closure $next)
    {

        if ($request->has('ref')) {
            $referralLink = ReferralLink::whereCode($request->get('ref'))->first();

            if (!empty($referralLink)) {
                if ($referralLink->program->status == "active") {
                    return redirect($request->url())->cookie('ref', $referralLink->id , 7 * 24 * 60);

                }
            }
        }

        return $next($request);
    }
}
