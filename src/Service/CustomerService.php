<?php

namespace Up2date\FlowPhpSdk\Service;

use Up2date\FlowPhpSdk\Customer;
use Up2date\FlowPhpSdk\Exception\ApiErrorException;
use Up2date\FlowPhpSdk\FlowObject;
use Up2date\FlowPhpSdk\Util\RequestOptions;

class CustomerService extends AbstractService
{
    /**
     * Creates a new customer object.
     *
     * @param null|array $params
     * @param null|array|RequestOptions $opts
     *
     * @throws ApiErrorException if the request fails
     *
     * @return Customer
     */
    public function create($params = null, $opts = null)
    {
        return $this->request('post', '/customers', $params, $opts);
    }

    /**
     * Finds a Customer object by email address
     *
     * @param string $email
     *
     * @throws ApiErrorException if the requests fails
     *
     * @return Customer
     */
    public function findOne($params = null, $opts = null): Customer | FlowObject
    {
        return $this->request('post', '/customers/findOne', $params, $opts);
    }
}