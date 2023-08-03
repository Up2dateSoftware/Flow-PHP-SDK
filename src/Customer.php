<?php

namespace Up2date\FlowPhpSdk;

use Up2date\FlowPhpSdk\Exception\ApiErrorException;
use Up2date\FlowPhpSdk\Util\RequestOptions;

/**
 * This object represents a customer of your business.
 *
 *
 * @property int $id Unique identifier for the object.
 * @property string $object String representing the object's type. Objects of the same type share the same value.
 * @property string $created_at Time at which the object was created. Measured in seconds since the Unix epoch.
 * @property null|string $email The customer's email address.
 * @property null|string $firstName The customer's first name.
 * @property null|string $lastName The customer's first name.
 * @property null|string $phone The customer's phone number.
 * @property null|int $countryCode The customer's phone number.
 * @property null|float $loyaltyPoints The customer's phone number.
 */

class Customer extends ApiResource
{
    const OBJECT_NAME = 'customer';

    use ApiOperations\All;
    use ApiOperations\Create;
    use ApiOperations\Delete;
    use ApiOperations\NestedResource;
    use ApiOperations\Update;

    use ApiOperations\Retrieve {
        retrieve as protected _retrieve;
    }


    public static function getSavedNestedResources()
    {
        static $savedNestedResources = null;
        if (null === $savedNestedResources) {
            $savedNestedResources = new Util\Set([
            ]);
        }

        return $savedNestedResources;
    }

    /**
     * @param array $params
     * @param null|array|RequestOptions $opts
     * @throws ApiErrorException if the request fails
     * @return Customer
     */

    public function addLoyaltyFromAmount($params, $opts = null)
    {
        list($response, $opts) = $this->_request('post', "/marketing/loyalty/earn/{$this->id}", $params, $opts);
        $this->refreshFrom($response, $opts);
        return $this;
    }

    /**
     * @param array $params
     * @param null|array|RequestOptions $opts
     * @throws ApiErrorException if the request fails
     * @return Customer
     */

    public function removeLoyaltyFromAmount($params, $opts = null)
    {
        list($response, $opts) = $this->_request('post', "/marketing/loyalty/spend/{$this->id}", $params, $opts);
        $this->refreshFrom($response, $opts);
        return $this;
    }

}