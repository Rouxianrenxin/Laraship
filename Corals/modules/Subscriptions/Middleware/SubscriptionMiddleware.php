<?php

namespace Corals\Modules\Subscriptions\Middleware;

use Closure;

class SubscriptionMiddleware
{
    /**
     * @param $request
     * @param Closure $next
     * @param null $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (user()->hasPermissionTo('Administrations::admin.subscription')) {
            return $next($request);
        }

        if (!user()->hasPermissionTo('Subscriptions::subscriptions.subscribe')) {
            if (!$request->is('dashboard')) {
                return redirect('dashboard');
            }
            return $next($request);
        }

        if (!user()->subscribed() && !$request->is('subscriptions*') && user()->subscriptionRequired()) {
            return redirect('subscriptions/select');
        }

        return $next($request);
    }
}
