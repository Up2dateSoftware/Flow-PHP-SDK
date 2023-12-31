<?php

namespace Up2date\FlowPhpSdk\Exception;

/**
 * ApiConnection is thrown in the event that the SDK can't connect to Flow's
 * servers. That can be for a variety of different reasons from a downed
 * network to a bad TLS certificate.
 */
class ApiConnectionException extends ApiErrorException
{
}