<?php

namespace Up2date\FlowPhpSdk;

use Up2date\FlowPhpSdk\Util\CaseInsensitiveArray;

class ApiResponse
{
    /**
     * @var null|array|CaseInsensitiveArray
     */
    public array|null|CaseInsensitiveArray $headers;

    /**
     * @var string
     */
    public string $body;

    /**
     * @var null|array
     */
    public ?array $json;

    /**
     * @var int
     */
    public int $code;

    /**
     * @param string $body
     * @param int $code
     * @param array|CaseInsensitiveArray|null $headers
     * @param array|null $json
     */
    public function __construct(string $body, int $code, CaseInsensitiveArray|array|null $headers, ?array $json)
    {
        $this->body = $body;
        $this->code = $code;
        $this->headers = $headers;
        $this->json = $json;
    }
}