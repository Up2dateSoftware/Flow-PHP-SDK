<?php

namespace Up2date\FlowPhpSdk\ApiOperations;


use Up2date\FlowPhpSdk\Exception\ApiErrorException;

/**
 * Trait for deletable resources. Adds a `delete()` method to the class.
 *
 * This trait should only be applied to classes that derive from FlowObject.
 */
trait Delete
{
    /**
     * @param null|array $params
     * @param null|array|string $opts
     *
     * @throws ApiErrorException if the request fails
     *
     * @return static the deleted resource
     */
    public function delete($params = null, $opts = null)
    {
        self::_validateParams($params);

        $url = $this->instanceUrl();
        list($response, $opts) = $this->_request('delete', $url, $params, $opts);
        $this->refreshFrom($response, $opts);

        return $this;
    }
}