<?php

namespace Up2date\FlowPhpSdk\Service;

use Up2date\FlowPhpSdk\Exception\ApiErrorException;
use Up2date\FlowPhpSdk\LoyaltyRules;

class LoyaltyService extends AbstractService
{
    /**
     * Get the loyalty rules from Flow API
     * @throws ApiErrorException
     *
     * @return LoyaltyRules
     */
    public function getRules($params = null, $opts = null)
    {
        return $this->request('get','/marketing/loyalty/rules', $params, $opts);
    }
}