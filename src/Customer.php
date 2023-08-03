<?php

namespace Up2date\FlowPhpSdk;

/**
 * This object represents a customer of your business.
 *
 *
 * @property string $id Unique identifier for the object.
 * @property string $object String representing the object's type. Objects of the same type share the same value.
 * @property string $created_at Time at which the object was created. Measured in seconds since the Unix epoch.
 * @property null|string $email The customer's email address.
 * @property null|string $firstName The customer's first name.
 * @property null|string $lastName The customer's first name.
 * @property null|string $phone The customer's phone number.
 * @property null|int $countryCode The customer's phone number.
 */

class Customer extends ApiResource
{
    const OBJECT_NAME = 'customer';

    public static function getSavedNestedResources()
    {
        static $savedNestedResources = null;
        if (null === $savedNestedResources) {
            $savedNestedResources = new Util\Set([
                'source',
            ]);
        }

        return $savedNestedResources;
    }

}