<?php

namespace Corals\User\Classes;

use Corals\User\Contracts\Provider;
use Corals\User\Contracts\TwoFactorAuthenticatableContract;

class TwoFactorAuth implements Provider
{
    protected $provider;

    public function __construct($provider = null)
    {
        $this->provider = $provider;
    }

    /**
     * Get specific TwoFactor auth provider object to use.
     *
     */
    public function getProvider()
    {
        return $this->provider;
    }

    /**
     * Determine if the given user has two-factor authentication enabled.
     *
     * @param TwoFactorAuthenticatableContract $user
     *
     * @return bool
     */
    public function isEnabled(TwoFactorAuthenticatableContract $user)
    {
        return $this->provider ? $this->provider->isEnabled($user) : false;
    }

    /**
     * Determine if the given user registered in two-factor authentication.
     *
     * @param TwoFactorAuthenticatableContract $user
     *
     * @return bool
     */
    public function isRegistered(TwoFactorAuthenticatableContract $user)
    {
        return $this->provider ? $this->provider->isRegistered($user) : false;
    }

    /**
     * Register the given user with the provider.
     * @param TwoFactorAuthenticatableContract $user
     * @return null|array
     */
    public function register(TwoFactorAuthenticatableContract $user)
    {
        return $this->provider ? $this->provider->register($user) : null;
    }

    /**
     * Determine if the given token is valid for the given user.
     *
     * @param TwoFactorAuthenticatableContract $user
     * @param string $token
     *
     * @return bool
     */
    public function tokenIsValid(TwoFactorAuthenticatableContract $user, $token)
    {
        return $this->provider ? $this->provider->tokenIsValid($user, $token) : false;
    }

    /**
     * Delete the given user from the provider.
     *
     * @param TwoFactorAuthenticatableContract $user
     *
     * @return bool
     */
    public function delete(TwoFactorAuthenticatableContract $user)
    {
        return $this->provider ? $this->provider->delete($user) : false;
    }

    /**
     * @param TwoFactorAuthenticatableContract $user
     * @throws \Exception
     */
    public function sendToken(TwoFactorAuthenticatableContract $user)
    {
        if (!$this->provider) {
            return;
        }

        $userAuthProviderOptions = $user->getTwoFactorAuthProviderOptions();

        $userTokenChannel = is_array($userAuthProviderOptions) ? array_get($userAuthProviderOptions, 'channel') : null;

        if ($userTokenChannel) {
            $methodName = 'send' . ucfirst($userTokenChannel) . 'Token';
            if (method_exists($this->provider, $methodName)) {
                return $this->provider->{$methodName}($user);
            }
        }

        throw new \Exception(trans('User::exceptions.invalid_send_token_channel'));
    }

    public function getSupportedChannels()
    {
        return $this->provider ? $this->provider->supportedChannels : [];
    }

    public function isActive()
    {
        $is_two_factor_auth_enabled = \Settings::get('two_factor_auth_enabled', false);

        $providerKey = \Settings::get('two_factor_auth_provider');

        $providerKey = ucfirst($providerKey);

        if ($is_two_factor_auth_enabled && class_exists("Corals\User\Services\\$providerKey")) {
            return true;
        }

        return false;
    }
}
