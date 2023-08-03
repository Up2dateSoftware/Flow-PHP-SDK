<?php

namespace Up2date\FlowPhpSdk\ApiOperations;


use Up2date\FlowPhpSdk\Exception\ApiErrorException;
use Up2date\FlowPhpSdk\Util\RequestOptions;

/**
 * Trait for retrievable singleton resources. Adds a `retrieve()` static method to the
 * class.
 *
 * This trait should only be applied to classes that derive from SingletonApiResource.
 */
trait SingletonRetrieve
{
    /**
     * @param null|array|string $opts the ID of the API resource to retrieve,
     *     or an options array containing an `id` key
     *
     * @throws ApiErrorException if the request fails
     *
     * @return static
     */
    public static function retrieve($opts = null)
    {
        $opts = RequestOptions::parse($opts);
        $instance = new static(null, $opts);
        $instance->refresh();

        return $instance;
    }
}