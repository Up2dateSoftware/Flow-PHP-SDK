<?php

namespace Up2date\FlowPhpSdk;

use Up2date\FlowPhpSdk\Exception\ApiErrorException;
use Up2date\FlowPhpSdk\Util\RequestOptions;

interface FlowClientInterface extends BaseFlowClientInterface
{
    /**
     * Sends a request to Flow's API.
     *
     * @param 'delete'|'get'|'post' $method the HTTP method
     * @param string $path the path of the request
     * @param array $params the parameters of the request
     * @param array|RequestOptions $opts the special modifiers of the request
     *
     * @throws ApiErrorException if the request fails
     *
     * @return FlowObject the object returned by Stripe's API
     */
    public function request($method, $path, $params, $opts);
}