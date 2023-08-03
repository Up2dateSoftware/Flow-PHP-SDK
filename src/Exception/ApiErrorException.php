<?php

namespace Up2date\FlowPhpSdk\Exception;

use Up2date\FlowPhpSdk\ErrorObject;
use Up2date\FlowPhpSdk\Util\CaseInsensitiveArray;

abstract class ApiErrorException extends \Exception implements ExceptionInterface
{
    protected $error;
    protected $httpBody;
    protected $httpHeaders;
    protected $httpStatus;
    protected $jsonBody;

    /**
     * Creates a new API error exception.
     *
     * @param string $message the exception message
     * @param null|int $httpStatus the HTTP status code
     * @param null|string $httpBody the HTTP body as a string
     * @param null|array $jsonBody the JSON deserialized body
     * @param null|array|CaseInsensitiveArray $httpHeaders the HTTP headers array
     *
     * @return static
     */
    public static function factory(
        $message,
        $httpStatus = null,
        $httpBody = null,
        $jsonBody = null,
        $httpHeaders = null
    ) {
        $instance = new static($message);
        $instance->setHttpStatus($httpStatus);
        $instance->setHttpBody($httpBody);
        $instance->setJsonBody($jsonBody);
        $instance->setHttpHeaders($httpHeaders);
        $instance->setError($instance->constructErrorObject());

        return $instance;
    }

    /**
     * Gets the Stripe error object.
     *
     * @return null|ErrorObject
     */
    public function getError(): ?ErrorObject
    {
        return $this->error;
    }

    /**
     * Sets the Stripe error object.
     *
     * @param null|ErrorObject $error
     */
    public function setError($error): void
    {
        $this->error = $error;
    }

    /**
     * Gets the HTTP body as a string.
     *
     * @return null|string
     */
    public function getHttpBody()
    {
        return $this->httpBody;
    }

    /**
     * Sets the HTTP body as a string.
     *
     * @param null|string $httpBody
     */
    public function setHttpBody($httpBody)
    {
        $this->httpBody = $httpBody;
    }

    /**
     * Gets the HTTP headers array.
     *
     * @return null|array|CaseInsensitiveArray
     */
    public function getHttpHeaders()
    {
        return $this->httpHeaders;
    }

    /**
     * Sets the HTTP headers array.
     *
     * @param null|array|CaseInsensitiveArray $httpHeaders
     */
    public function setHttpHeaders($httpHeaders)
    {
        $this->httpHeaders = $httpHeaders;
    }

    /**
     * Gets the HTTP status code.
     *
     * @return null|int
     */
    public function getHttpStatus()
    {
        return $this->httpStatus;
    }

    /**
     * Sets the HTTP status code.
     *
     * @param null|int $httpStatus
     */
    public function setHttpStatus($httpStatus)
    {
        $this->httpStatus = $httpStatus;
    }

    /**
     * Gets the JSON deserialized body.
     *
     * @return null|array<string, mixed>
     */
    public function getJsonBody()
    {
        return $this->jsonBody;
    }

    /**
     * Sets the JSON deserialized body.
     *
     * @param null|array<string, mixed> $jsonBody
     */
    public function setJsonBody($jsonBody)
    {
        $this->jsonBody = $jsonBody;
    }


    /**
     * Returns the string representation of the exception.
     *
     * @return string
     */
    public function __toString()
    {
        $statusStr = (null === $this->getHttpStatus()) ? '' : "(Status {$this->getHttpStatus()}) ";

        return "{$statusStr}{$this->getMessage()}";
    }

    protected function constructErrorObject(): ?ErrorObject
    {
        if (null === $this->jsonBody || !\array_key_exists('error', $this->jsonBody)) {
            return null;
        }

        return ErrorObject::constructFrom($this->jsonBody['error']);
    }
}