<?php

namespace Up2date\FlowPhpSdk;

use Up2date\FlowPhpSdk\Exception\InvalidArgumentException;
use Up2date\FlowPhpSdk\Exception\UnexpectedValueException;
use Up2date\FlowPhpSdk\Util\RequestOptions;
use Up2date\FlowPhpSdk\Util\Util;

class BaseFlowClient implements BaseFlowClientInterface
{
    /** @var string default base URL for Flow's API */
    const DEFAULT_API_BASE = 'https://api.flow.up2date.ro';

    /** @var array<string, null|string> */
    const DEFAULT_CONFIG = [
        'api_key' => null,
        'api_base' => self::DEFAULT_API_BASE,
        'flow_version' => '2023-08-02'
    ];

    /** @var array<string, mixed> */
    private $config;

    /** @var RequestOptions */
    private $defaultOpts;

    /**
     * Initializes a new instance of the {@link BaseFlowClient} class.
     *
     * The constructor takes a single argument. The argument can be a string, in which case it
     * should be the API key. It can also be an array with various configuration settings.
     *
     * Configuration settings include the following options:
     *
     * - api_key (null|string): the Flow API key, to be used in regular API requests.
     * - flow_version (null|string): a Flow API version. If set, all requests sent by the client
     *   will include the {@code Flow-Version} header with that API version.
     *
     * The following configuration settings are also available, though setting these should rarely be necessary
     * (only useful if you want to send requests to a mock server like flow-mock):
     *
     * - api_base (string): the base URL for regular API requests. Defaults to
     *   {@link DEFAULT_API_BASE}.
     *
     * @param array<string, mixed>|string $config the API key as a string, or an array containing
     *   the client configuration settings
     */
    public function __construct(array|string $config = [])
    {
        if (\is_string($config)) {
            $config = ['api_key' => $config];
        } elseif (!\is_array($config)) {
            throw new InvalidArgumentException('$config must be a string or an array');
        }

        $config = \array_merge(self::DEFAULT_CONFIG, $config);
        $this->validateConfig($config);

        $this->config = $config;

        $this->defaultOpts = RequestOptions::parse([
            'flow_version' => $config['flow_version'],
        ]);
    }

    /**
     * Gets the API key used by the client to send requests.
     *
     * @return null|string the API key used by the client to send requests
     */
    public function getApiKey(): ?string
    {
        return $this->config['api_key'];
    }


    /**
     * Gets the base URL for Flow's API.
     *
     * @return string the base URL for Flow's API
     */
    public function getApiBase(): string
    {
        return $this->config['api_base'];
    }

    /**
     * Sends a request to Flow's API.
     *
     * @param 'delete'|'get'|'post' $method the HTTP method
     * @param string $path the path of the request
     * @param array $params the parameters of the request
     * @param array|RequestOptions $opts the special modifiers of the request
     *
     * @return FlowObject the object returned by Stripe's API
     */
    public function request($method, $path, $params, $opts)
    {
        $opts = $this->defaultOpts->merge($opts, true);
        $baseUrl = $opts->apiBase ?: $this->getApiBase();
        $requestor = new ApiRequester($this->apiKeyForRequest($opts), $baseUrl);
        list($response, $opts->apiKey) = $requestor->request($method, $path, $params, $opts->headers);
        $opts->discardNonPersistentHeaders();
        $obj = Util::convertToFlowObject($response->json, $opts);
        $obj->setLastResponse($response);

        return $obj;
    }

    /**
     * Sends a request to Flow's API.
     *
     * @param 'delete'|'get'|'post' $method the HTTP method
     * @param string $path the path of the request
     * @param array $params the parameters of the request
     * @param array|RequestOptions $opts the special modifiers of the request
     *
     * @return Collection of ApiResources
     */
    public function requestCollection($method, $path, $params, $opts)
    {
        $obj = $this->request($method, $path, $params, $opts);
        if (!($obj instanceof Collection)) {
            $received_class = \get_class($obj);
            $msg = "Expected to receive `Collection` object from Flow API. Instead received `{$received_class}`.";

            throw new UnexpectedValueException($msg);
        }
        $obj->setFilters($params);

        return $obj;
    }

    /**
     * Sends a request to Flow's API.
     *
     * @param 'delete'|'get'|'post' $method the HTTP method
     * @param string $path the path of the request
     * @param array $params the parameters of the request
     * @param array|RequestOptions $opts the special modifiers of the request
     *
     * @return SearchResult of ApiResources
     */
    public function requestSearchResult($method, $path, $params, $opts)
    {
        $obj = $this->request($method, $path, $params, $opts);
        if (!($obj instanceof SearchResult)) {
            $received_class = \get_class($obj);
            $msg = "Expected to receive `SearchResult` object from Flow API. Instead received `{$received_class}`.";

            throw new UnexpectedValueException($msg);
        }
        $obj->setFilters($params);

        return $obj;
    }

    /**
     * @param RequestOptions $opts
     *
     * @throws \Exception
     *
     * @return string
     */
    private function apiKeyForRequest($opts)
    {
        $apiKey = $opts->apiKey ?: $this->getApiKey();

        if (null === $apiKey) {
            $msg = 'No API key provided. Set your API key when constructing the '
                . 'FlowClient instance, or provide it on a per-request basis '
                . 'using the `api_key` key in the $opts argument.';

            throw new \Exception($msg);
        }

        return $apiKey;
    }


    /**
     * @param array<string, mixed> $config
     *
     * @throws InvalidArgumentException
     */
    private function validateConfig(array $config): void
    {
        // api_key
        if (null == $config['api_key'] && !\is_string($config['api_key'])) {
            throw new InvalidArgumentException('api_key must be null or a string');
        }
        if (('' === $config['api_key'])) {
            $msg = 'api_key cannot be the empty string';

            throw new InvalidArgumentException($msg);
        }

        if (null !== $config['api_key'] && (\preg_match('/\s/', $config['api_key']))) {
            $msg = 'api_key cannot contain whitespace';

            throw new InvalidArgumentException($msg);
        }

        // flow
        if (null !== $config['flow_version'] && !\is_string($config['flow_version'])) {
            throw new InvalidArgumentException('flow_version must be null or a string');
        }

        // api_base
        if (!\is_string($config['api_base'])) {
            throw new \InvalidArgumentException('api_base must be a string');
        }

        $extraConfigKeys = \array_diff(\array_keys($config), \array_keys(self::DEFAULT_CONFIG));
        if (!empty($extraConfigKeys)) {
            // Wrap in single quote to more easily catch trailing spaces errors
            $invalidKeys = "'" . \implode("', '", $extraConfigKeys) . "'";

            throw new \InvalidArgumentException('Found unknown key(s) in configuration array: ' . $invalidKeys);
        }
    }
}