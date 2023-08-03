<?php

namespace Up2date\FlowPhpSdk\Service;

class CoreServiceFactory extends AbstractServiceFactory
{
    private static $classMap = [
        'customers' => CustomerService::class,
        'loyalty' => LoyaltyService::class
    ];

    protected function getServiceClass($name)
    {
        return \array_key_exists($name, self::$classMap) ? self::$classMap[$name] : null;
    }
}