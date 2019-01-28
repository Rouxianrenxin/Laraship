<?php

namespace Corals\Modules\Payment\Common\Http\Exception;

use Corals\Modules\Payment\Common\Http\Exception;
use Psr\Http\Client\Exception\RequestException as PsrRequestException;

class RequestException extends Exception implements PsrRequestException
{
}
