<?php

namespace chumakovanton\tinkoffPay\response;

class HttpResponse
{
    private $statusCode;
    private $payload;

    public function __construct(int $statusCode, array $payload = null)
    {
        $this->statusCode = $statusCode;
        $this->payload = $payload;
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function getPayload(): ?array
    {
        return $this->payload;
    }
}
