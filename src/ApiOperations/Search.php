<?php

namespace Up2date\FlowPhpSdk\ApiOperations;


use Up2date\FlowPhpSdk\Exception\ApiErrorException;
use Up2date\FlowPhpSdk\Exception\UnexpectedValueException;
use Up2date\FlowPhpSdk\SearchResult;
use Up2date\FlowPhpSdk\Util\Util;

/**
 * Trait for searchable resources.
 *
 * This trait should only be applied to classes that derive from FlowObject.
 */
trait Search
{
    /**
     * @param string $searchUrl
     * @param null|array $params
     * @param null|array|string $opts
     *
     * @throws ApiErrorException if the request fails
     *
     * @return SearchResult of ApiResources
     */
    protected static function _searchResource($searchUrl, $params = null, $opts = null)
    {
        self::_validateParams($params);

        list($response, $opts) = static::_staticRequest('get', $searchUrl, $params, $opts);
        $obj = Util::convertToFlowObject($response->json, $opts);
        if (!($obj instanceof SearchResult)) {
            throw new UnexpectedValueException(
                'Expected type ' . SearchResult::class . ', got "' . \get_class($obj) . '" instead.'
            );
        }
        $obj->setLastResponse($response);
        $obj->setFilters($params);

        return $obj;
    }
}