<?php

namespace chumakovanton\tinkoffPay\request;

use chumakovanton\tinkoffPay\response\ResponseInterface;

interface RequestInterface
{
    public function setCredentials(string $apiUrl, string $terminalKey, string $secretKey): RequestInterface;

    /**
     * Отправить запрос
     * @return ResponseInterface
     */
    public function send(): ResponseInterface;
}