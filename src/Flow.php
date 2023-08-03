<?php

namespace Up2date\FlowPhpSdk;

/**
 * Class Flow.
 */
class Flow
{
    /** @var string The Flow API key to be used for requests. */
    static $apiKey;

    /** @var string The base URL for the Flow API. */
    static $apiBase = 'https://flow.up2date.ro';

    /** @var null|string The version of the Flow API to use for requests. */
    static $apiVersion = null;

    /** @var array The application's information (name, version, URL) */
    static $appInfo = null;

    /**
     * @var null|Util\LoggerInterface the logger to which the library will
     *   produce messages
     */
    static $logger = null;

    /** @var int Maximum number of request retries */
    static $maxNetworkRetries = 0;

    /** @var bool Whether client telemetry is enabled. Defaults to true. */
    static $enableTelemetry = true;

    /** @var float Maximum delay between retries, in seconds */
    private static $maxNetworkRetryDelay = 2.0;

    /** @var float Maximum delay between retries, in seconds, that will be respected from the Flow API */
    private static $maxRetryAfter = 60.0;

    /** @var float Initial delay between retries, in seconds */
    private static $initialNetworkRetryDelay = 0.5;

    const VERSION = '2023-08-02';

    /**
     * @return string the API key used for requests
     */
    public static function getApiKey()
    {
        return self::$apiKey;
    }

    /**
     * @return Util\LoggerInterface the logger to which the library will
     *   produce messages
     */
    public static function getLogger()
    {
        if (null === self::$logger) {
            return new Util\DefaultLogger();
        }

        return self::$logger;
    }

    /**
     * @param Util\LoggerInterface $logger the logger to which the library
     *   will produce messages
     */
    public static function setLogger($logger)
    {
        self::$logger = $logger;
    }

    /**
     * Sets the API key to be used for requests.
     *
     * @param string $apiKey
     */
    public static function setApiKey($apiKey)
    {
        self::$apiKey = $apiKey;
    }

    /**
     * @return string The API version used for requests. null if we're using the
     *    latest version.
     */
    public static function getApiVersion()
    {
        return self::$apiVersion;
    }

    /**
     * @param string $apiVersion the API version to use for requests
     */
    public static function setApiVersion($apiVersion)
    {
        self::$apiVersion = $apiVersion;
    }

    /**
     * @return null|array The application's information
     */
    public static function getAppInfo()
    {
        return self::$appInfo;
    }

    /**
     * @param string $appName The application's name
     * @param null|string $appVersion The application's version
     * @param null|string $appUrl The application's URL
     */
    public static function setAppInfo($appName, $appVersion = null, $appUrl = null)
    {
        self::$appInfo = self::$appInfo ?: [];
        self::$appInfo['name'] = $appName;
        self::$appInfo['url'] = $appUrl;
        self::$appInfo['version'] = $appVersion;
    }

    /**
     * @return int Maximum number of request retries
     */
    public static function getMaxNetworkRetries()
    {
        return self::$maxNetworkRetries;
    }

    /**
     * @param int $maxNetworkRetries Maximum number of request retries
     */
    public static function setMaxNetworkRetries($maxNetworkRetries)
    {
        self::$maxNetworkRetries = $maxNetworkRetries;
    }

    /**
     * @return float Maximum delay between retries, in seconds
     */
    public static function getMaxNetworkRetryDelay()
    {
        return self::$maxNetworkRetryDelay;
    }

    /**
     * @return float Maximum delay between retries, in seconds, that will be respected from the Stripe API
     */
    public static function getMaxRetryAfter()
    {
        return self::$maxRetryAfter;
    }

    /**
     * @return float Initial delay between retries, in seconds
     */
    public static function getInitialNetworkRetryDelay()
    {
        return self::$initialNetworkRetryDelay;
    }

    /**
     * @return bool Whether client telemetry is enabled
     */
    public static function getEnableTelemetry()
    {
        return self::$enableTelemetry;
    }

    /**
     * @param bool $enableTelemetry Enables client telemetry.
     *
     * Client telemetry enables timing and request metrics to be sent back to Flow as an HTTP Header
     * with the current request. This enables Stripe to do latency and metrics analysis without adding extra
     * overhead (such as extra network calls) on the client.
     */
    public static function setEnableTelemetry($enableTelemetry)
    {
        self::$enableTelemetry = $enableTelemetry;
    }
}