<?php

namespace Up2date\FlowPhpSdk\Service;

use Up2date\FlowPhpSdk\FlowClientInterface;

abstract class AbstractServiceFactory
{
    /** @var FlowClientInterface */
    private $client;

    /** @var array<string, AbstractService|AbstractServiceFactory> */
    private $services;

    /**
     * @param FlowClientInterface $client
     */
    public function __construct($client)
    {
        $this->client = $client;
        $this->services = [];
    }

    /**
     * @param string $name
     *
     * @return null|string
     */
    abstract protected function getServiceClass($name);

    /**
     * @param string $name
     *
     * @return null|AbstractService|AbstractServiceFactory
     */
    public function __get($name)
    {
        return $this->getService($name);
    }

    /**
     * @param string $name
     *
     * @return null|AbstractService|AbstractServiceFactory
     */
    public function getService($name)
    {
        $serviceClass = $this->getServiceClass($name);
        if (null !== $serviceClass) {
            if (!\array_key_exists($name, $this->services)) {
                $this->services[$name] = new $serviceClass($this->client);
            }

            return $this->services[$name];
        }

        \trigger_error('Undefined property: ' . static::class . '::$' . $name);

        return null;
    }
}