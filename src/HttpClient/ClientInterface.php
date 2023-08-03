<?php

namespace Up2date\FlowPhpSdk\HttpClient;

use Up2date\FlowPhpSdk\Exception\ApiConnectionException;
use Up2date\FlowPhpSdk\Exception\UnexpectedValueException;

interface ClientInterface
{
    /**
     * @param 'delete'|'get'|'post' $method The HTTP method being used
     * @param string $absUrl The URL being requested, including domain and protocol
     * @param array $headers Headers to be used in the request (full strings, not KV pairs)
     * @param array $params KV pairs for parameters. Can be nested for arrays and hashes
     * @param bool $hasFile Whether or not $params references a file (via an @ prefix or
     *                         CURLFile)
     *
     * @throws ApiConnectionException
     * @throws UnexpectedValueException
     *
     * @return array an array whose first element is raw request body, second
     *    element is HTTP status code and third array of HTTP headers
     */
    public function request($method, $absUrl, $headers, $params, $hasFile);
}