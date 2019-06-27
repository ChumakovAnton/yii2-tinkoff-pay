<?php

namespace chumakovanton\tinkoffPay\response;

class HttpResponse
{
    private $statusCode;
    private $body;

    public function __construct(int $statusCode, ?string $body = null)
    {
        $this->statusCode = $statusCode;
        $this->body = $body;
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function getBody(): ?string
    {
        return $this->body;
    }
}
