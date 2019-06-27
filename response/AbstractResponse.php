<?php

namespace chumakovanton\tinkoffPay\response;


use yii\helpers\Json;

abstract class AbstractResponse implements ResponseInterface
{
    protected $response;
    private $statusCode;
    private $jsonResponse;

    public function __construct(int $statusCode, string $jsonResponse)
    {
        $this->statusCode = $statusCode;
        $this->jsonResponse = $jsonResponse;
        $this->response = Json::decode($jsonResponse);
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * Успешность операции
     * @return bool
     */
    public function getSuccess(): bool
    {
        return !empty($this->response) && $this->response['Success'];
    }

    /**
     * Получить ошибку, которую вернул сервис оплаты
     * @return ErrorResponse|null
     */
    public function getError(): ?ErrorResponse
    {
        $error = null;
        if ($this->response['ErrorCode'] !== '0') {
            $error = new ErrorResponse((int)$this->response['ErrorCode']);
        }
        return $error;
    }

    /**
     * Получить статус транзакции
     * @return null|string
     */
    public function getStatus(): ?string
    {
        return $this->response['Status'];
    }

    /**
     * Уникальный идентификатор транзакции в сервисе оплаты
     * @return null|int
     */
    public function getPaymentId(): ?int
    {
        return $this->response['PaymentId'];
    }

    /**
     * Идентификатор терминала
     * @return null|string
     */
    public function getTerminalKey(): ?string
    {
        return $this->response['TerminalKey'];
    }

    /**
     * Номер заказа в системе
     * @return null|string
     */
    public function getOrderId(): ?string
    {
        return $this->response['OrderId'];
    }

    /**
     * Краткое описание ошибки
     * @return string|null
     */
    public function getMessage(): ?string
    {
        return $this->response['Message'];
    }

    /**
     * Подробное описание ошибки
     * @return null|string
     */
    public function getDetails(): ?string
    {
        return $this->response['Details'];
    }
}