<?php

namespace Up2date\FlowPhpSdk\Service;

use Up2date\FlowPhpSdk\Exception\ApiErrorException;
use Up2date\FlowPhpSdk\Exception\InvalidArgumentException;
use Up2date\FlowPhpSdk\FlowClientInterface;
use Up2date\FlowPhpSdk\FlowObject;

abstract class AbstractService
{
    /**
     * @var FlowClientInterface
     */
    protected $client;

    /**
     * Initializes a new instance of the {@link AbstractService} class.
     *
     * @param FlowClientInterface $client
     */
    public function __construct($client)
    {
        $this->client = $client;
    }

    /**
     * Gets the client used by this service to send requests.
     *
     * @return FlowClientInterface
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Translate null values to empty strings. For service methods,
     * we interpret null as a request to unset the field, which
     * corresponds to sending an empty string for the field to the
     * API.
     *
     * @param null|array $params
     */
    private static function formatParams($params)
    {
        if (null === $params) {
            return null;
        }
        \array_walk_recursive($params, function (&$value, $key) {
            if (null === $value) {
                $value = '';
            }
        });

        return $params;
    }

    /**
     * @param $method
     * @param $path
     * @param $params
     * @param $opts
     *
     * @throws ApiErrorException if the request fails
     *
     * @return FlowObject
     */
    protected function request($method, $path, $params, $opts)
    {
        return $this->getClient()->request($method, $path, self::formatParams($params), $opts);
    }

    protected function requestCollection($method, $path, $params, $opts)
    {
        // TODO (MAJOR): Add this method to FlowClientInterface
        // @phpstan-ignore-next-line
        return $this->getClient()->requestCollection($method, $path, self::formatParams($params), $opts);
    }

    protected function requestSearchResult($method, $path, $params, $opts)
    {
        // TODO (MAJOR): Add this method to FlowClientInterface
        // @phpstan-ignore-next-line
        return $this->getClient()->requestSearchResult($method, $path, self::formatParams($params), $opts);
    }

    protected function buildPath($basePath, ...$ids)
    {
        foreach ($ids as $id) {
            if (null === $id || '' === \trim($id)) {
                $msg = 'The resource ID cannot be null or whitespace.';

                throw new InvalidArgumentException($msg);
            }
        }

        return \sprintf($basePath, ...\array_map('\urlencode', $ids));
    }
}