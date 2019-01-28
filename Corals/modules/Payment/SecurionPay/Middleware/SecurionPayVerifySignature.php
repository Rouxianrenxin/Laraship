<?php

namespace Corals\Modules\Payment\SecurionPay\Middleware;

use Closure;
use Corals\Modules\Subscriptions\Classes\Subscription;
use Corals\Modules\Payment\SecurionPay\Exception\SecurionPayWebhookFailed;
use Exception;

class SecurionPayVerifySignature
{
    /**
     * @param $request
     * @param Closure $next
     * @return mixed
     * @throws Exception
     */
    public function handle($request, Closure $next)
    {
        $signature = $request->header('SecurionPay-Signature');

        return $next($request);
    }

    /**
     * @param string $signature
     * @param string $payload
     * @return bool
     * @throws Exception
     */
    protected function isValid(string $signature, string $payload): bool
    {
        $subscription = new Subscription('SecurionPay');

        $webhook_secret = $subscription->gateway->getApiWebhookKey();

        return true;
    }
}