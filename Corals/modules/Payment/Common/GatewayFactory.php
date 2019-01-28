<?php
/**
 * Payment Gateway Factory class
 */

namespace Corals\Modules\Payment\Common;

use Corals\Modules\Payment\Common\Http\ClientInterface;
use Corals\Modules\Payment\Common\Exception\RuntimeException;
use Symfony\Component\HttpFoundation\Request as HttpRequest;

/**
 * Payment Gateway Factory class
 *
 * This class abstracts a set of gateways that can be independently
 * registered, accessed, and used.
 *
 * Note that static calls to the Payment class are routed to this class by
 * the static call router (__callStatic) in Payment.
 *
 * Example:
 *
 * <code>
 *   // Create a gateway for the PayPal ExpressGateway
 *   // (routes to GatewayFactory::create)
 *   $gateway = Payment::create('ExpressGateway');
 * </code>
 *
 * @see Corals\Modules\Payment\Corals\Modules\Payment
 */
class GatewayFactory
{
    /**
     * Internal storage for all available gateways
     *
     * @var array
     */
    private $gateways = array();

    /**
     * All available gateways
     *
     * @return array An array of gateway names
     */
    public function all()
    {
        return $this->gateways;
    }

    /**
     * Replace the list of available gateways
     *
     * @param array $gateways An array of gateway names
     */
    public function replace(array $gateways)
    {
        $this->gateways = $gateways;
    }

    /**
     * Register a new gateway
     *
     * @param string $className Gateway name
     */
    public function register($className)
    {
        if (!in_array($className, $this->gateways)) {
            $this->gateways[] = $className;
        }
    }

    /**
     * Create a new gateway instance
     *
     * @param string $class Gateway name
     * @param ClientInterface|null $httpClient A HTTP Client implementation
     * @param HttpRequest|null $httpRequest A Symfony HTTP Request implementation
     * @throws RuntimeException                 If no such gateway is found
     * @return GatewayInterface                 An object of class $class is created and returned
     */
    public function create($class, ClientInterface $httpClient = null, HttpRequest $httpRequest = null)
    {
        $class = Helper::getGatewayClassName($class);

        if (!class_exists($class)) {
            throw new RuntimeException(trans('Payment::exception.messages_exception_common.class_not_found', ['class' => $class]));
        }

        return new $class($httpClient, $httpRequest);
    }

    /**
     * Get a list of supported gateways which may be available
     *
     * @return array
     */
    public function getSupportedGateways()
    {
        $package = json_decode(file_get_contents(__DIR__ . '/../../../composer.json'), true);

        return $package['extra']['gateways'];
    }
}
