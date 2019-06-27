<?php

namespace chumakovanton\tinkoffPay\response;


abstract class AbstractResponse implements ResponseInterface
{
    protected $response;
    private $statusCode;

    public function __construct(int $statusCode, array $response)
    {
        $this->statusCode = $statusCode;
        $this->response = $response;
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * Успешность операции
     * @return bool
     */
    public function isSuccess(): bool
    {
        return isset($this->response['Success']) && (bool)$this->response['Success'];
    }

    /**
     * Получить статус транзакции
     * @return null|string
     */
    public function getStatus(): ?string
    {
        return $this->response['Status'] ?? null;
    }

    /**
     * Уникальный идентификатор транзакции в сервисе оплаты
     * @return null|int
     */
    public function getPaymentId(): ?int
    {
        return $this->response['PaymentId'] ?? null;
    }

    /**
     * Идентификатор терминала
     * @return null|string
     */
    public function getTerminalKey(): ?string
    {
        return $this->response['TerminalKey'] ?? null;
    }

    /**
     * Номер заказа в системе
     * @return null|string
     */
    public function getOrderId(): ?string
    {
        return $this->response['OrderId'] ?? null;
    }

    /**
     * Краткое описание ошибки
     * @return string|null
     */
    public function getMessage(): ?string
    {
        return $this->response['Message'] ?? null;
    }

    /**
     * Подробное описание ошибки
     * @return null|string
     */
    public function getDetails(): ?string
    {
        return $this->response['Details'] ?? null;
    }
}