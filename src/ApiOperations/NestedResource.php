<?php

namespace Up2date\FlowPhpSdk\ApiOperations;


use Up2date\FlowPhpSdk\Exception\ApiErrorException;
use Up2date\FlowPhpSdk\FlowObject;
use Up2date\FlowPhpSdk\Util\Util;

/**
 * Trait for resources that have nested resources.
 *
 * This trait should only be applied to classes that derive from FlowObject.
 */
trait NestedResource
{
    /**
     * @param 'delete'|'get'|'post' $method
     * @param string $url
     * @param null|array $params
     * @param null|array|string $options
     *
     * @return FlowObject
     */
    protected static function _nestedResourceOperation($method, $url, $params = null, $options = null)
    {
        self::_validateParams($params);

        list($response, $opts) = static::_staticRequest($method, $url, $params, $options);
        $obj = Util::convertToFlowObject($response->json, $opts);
        $obj->setLastResponse($response);

        return $obj;
    }

    /**
     * @param string $id
     * @param string $nestedPath
     * @param null|string $nestedId
     *
     * @return string
     */
    protected static function _nestedResourceUrl($id, $nestedPath, $nestedId = null)
    {
        $url = static::resourceUrl($id) . $nestedPath;
        if (null !== $nestedId) {
            $url .= "/{$nestedId}";
        }

        return $url;
    }

    /**
     * @param string $id
     * @param string $nestedPath
     * @param null|array $params
     * @param null|array|string $options
     *
     * @throws ApiErrorException if the request fails
     *
     * @return FlowObject
     */
    protected static function _createNestedResource($id, $nestedPath, $params = null, $options = null)
    {
        $url = static::_nestedResourceUrl($id, $nestedPath);

        return self::_nestedResourceOperation('post', $url, $params, $options);
    }

    /**
     * @param string $id
     * @param string $nestedPath
     * @param null|string $nestedId
     * @param null|array $params
     * @param null|array|string $options
     *
     * @throws ApiErrorException if the request fails
     *
     * @return FlowObject
     */
    protected static function _retrieveNestedResource($id, $nestedPath, $nestedId, $params = null, $options = null)
    {
        $url = static::_nestedResourceUrl($id, $nestedPath, $nestedId);

        return self::_nestedResourceOperation('get', $url, $params, $options);
    }

    /**
     * @param string $id
     * @param string $nestedPath
     * @param null|string $nestedId
     * @param null|array $params
     * @param null|array|string $options
     *
     * @throws ApiErrorException if the request fails
     *
     * @return FlowObject
     */
    protected static function _updateNestedResource($id, $nestedPath, $nestedId, $params = null, $options = null)
    {
        $url = static::_nestedResourceUrl($id, $nestedPath, $nestedId);

        return self::_nestedResourceOperation('post', $url, $params, $options);
    }

    /**
     * @param string $id
     * @param string $nestedPath
     * @param null|string $nestedId
     * @param null|array $params
     * @param null|array|string $options
     *
     * @throws ApiErrorException if the request fails
     *
     * @return FlowObject
     */
    protected static function _deleteNestedResource($id, $nestedPath, $nestedId, $params = null, $options = null)
    {
        $url = static::_nestedResourceUrl($id, $nestedPath, $nestedId);

        return self::_nestedResourceOperation('delete', $url, $params, $options);
    }

    /**
     * @param string $id
     * @param string $nestedPath
     * @param null|array $params
     * @param null|array|string $options
     *
     * @throws ApiErrorException if the request fails
     *
     * @return FlowObject
     */
    protected static function _allNestedResources($id, $nestedPath, $params = null, $options = null)
    {
        $url = static::_nestedResourceUrl($id, $nestedPath);

        return self::_nestedResourceOperation('get', $url, $params, $options);
    }
}