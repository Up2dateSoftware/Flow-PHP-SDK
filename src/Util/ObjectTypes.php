<?php

namespace Up2date\FlowPhpSdk\Util;

use Up2date\FlowPhpSdk\BasicData;
use Up2date\FlowPhpSdk\Customer;
use Up2date\FlowPhpSdk\LoyaltyRules;

class ObjectTypes
{
    /**
     * @var array Mapping from object types to resource classes
     */
    const mapping = [
        Customer::OBJECT_NAME => Customer::class,
        LoyaltyRules::OBJECT_NAME => LoyaltyRules::class,
        BasicData::OBJECT_NAME => BasicData::class
    ];
}