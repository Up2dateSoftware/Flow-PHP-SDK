<?php

namespace Up2date\FlowPhpSdk\ApiOperations;

use Up2date\FlowPhpSdk\Collection;
use Up2date\FlowPhpSdk\Exception\ApiErrorException;
use Up2date\FlowPhpSdk\Exception\UnexpectedValueException;
use Up2date\FlowPhpSdk\Util\Util;

/**
 * Trait for listable resources. Adds a `all()` static method to the class.
 *
 * This trait should only be applied to classes that derive from FlowObject.
 */
trait All
{
    /**
     * @param null|array $params
     * @param null|array|string $opts
     *
     * @throws ApiErrorException if the request fails
     *
     * @return Collection of ApiResources
     */
    public static function all($params = null, $opts = null)
    {
        self::_validateParams($params);
        $url = static::classUrl();

        list($response, $opts) = static::_staticRequest('get', $url, $params, $opts);
        $obj = Util::convertToFlowObject($response->json, $opts);
        if (!($obj instanceof Collection)) {
            throw new UnexpectedValueException(
                'Expected type ' . Collection::class . ', got "' . \get_class($obj) . '" instead.'
            );
        }
        $obj->setLastResponse($response);
        $obj->setFilters($params);

        return $obj;
    }
}