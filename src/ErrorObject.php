<?php

namespace Up2date\FlowPhpSdk;

class ErrorObject extends FlowObject
{
    const CODE_ACCOUNT_CLOSED = 'account_closed';

    /**
     * Refreshes this object using the provided values.
     *
     * @param array $values
     * @param null|array|string|Util\RequestOptions $opts
     * @param bool $partial defaults to false
     */
    public function refreshFrom($values, $opts, $partial = false): void
    {
        // Unlike most other API resources, the API will omit attributes in
        // error objects when they have a null value. We manually set default
        // values here to facilitate generic error handling.
        $values = \array_merge([
            'code' => null,
            'message' => null,
            'param' => null,
        ], $values);
        parent::refreshFrom($values, $opts, $partial);
    }
}