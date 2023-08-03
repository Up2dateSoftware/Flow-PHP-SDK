<?php

namespace Up2date\FlowPhpSdk;

use Up2date\FlowPhpSdk\Service\CoreServiceFactory;
use Up2date\FlowPhpSdk\Service\CustomerService;
use Up2date\FlowPhpSdk\Service\LoyaltyService;

/**
 * Client used to send requests to Flow's API.
 * @property CustomerService $customers
 * @property LoyaltyService $loyalty
 */
class FlowClient extends BaseFlowClient
{
    /**
     * @var CoreServiceFactory
     */
    private $coreServiceFactory;

    public function __get(string $name)
    {
        return $this->getService($name);
    }

    public function getService($name)
    {
        if (null == $this->coreServiceFactory) {
            $this->coreServiceFactory = new CoreServiceFactory($this);
        }
        return $this->coreServiceFactory->getService($name);
    }
}