<?php

namespace Up2date\FlowPhpSdk\ApiOperations;

use Up2date\FlowPhpSdk\ApiRequester;
use Up2date\FlowPhpSdk\Exception\ApiErrorException;
use Up2date\FlowPhpSdk\Exception\InvalidArgumentException;
use Up2date\FlowPhpSdk\Util\RequestOptions;

/**
 * Trait for resources that need to make API requests.
 *
 * This trait should only be applied to classes that derive from FlowObject.
 */
trait Request
{
    /**
     * @param null|array|mixed $params The list of parameters to validate
     *
     * @throws InvalidArgumentException if $params exists and is not an array
     */
    protected static function _validateParams($params = null): void
    {
        if ($params && !\is_array($params)) {
            $message = 'You must pass an array as the first argument to Flow API '
                . 'method calls.  (HINT: an example call to create a customer '
                . "would be: \"Flow\\Customer::create(['email' => 'test@test.com'])\")";

            throw new InvalidArgumentException($message);
        }
    }

    /**
     * @param 'delete'|'get'|'post' $method HTTP method ('get', 'post', etc.)
     * @param string $url URL for the request
     * @param array $params list of parameters for the request
     * @param null|array|string $options
     *
     * @throws ApiErrorException if the request fails
     *
     * @return array tuple containing (the JSON response, $options)
     */
    protected function _request($method, $url, $params = [], $options = null): array
    {
        $opts = $this->_opts->merge($options);
        list($resp, $options) = static::_staticRequest($method, $url, $params, $opts);
        $this->setLastResponse($resp);

        return [$resp->json, $options];
    }
    /**
     * @param 'delete'|'get'|'post' $method HTTP method ('get', 'post', etc.)
     * @param string $url URL for the request
     * @param array $params list of parameters for the request
     * @param null|array|string $options
     *
     * @throws ApiErrorException if the request fails
     *
     * @return array tuple containing (the JSON response, $options)
     */
    protected static function _staticRequest($method, $url, $params, $options)
    {
        $opts = RequestOptions::parse($options);
        $baseUrl = isset($opts->apiBase) ? $opts->apiBase : static::baseUrl();
        $requestor = new ApiRequester($opts->apiKey, $baseUrl);
        list($response, $opts->apiKey) = $requestor->request($method, $url, $params, $opts->headers);
        $opts->discardNonPersistentHeaders();

        return [$response, $opts];
    }
}