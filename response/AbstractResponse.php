<?php
/**
 * Created by PhpStorm.
 * User: anton
 * Date: 07.09.17
 * Time: 15:35
 */

namespace chumakovanton\tinkoffPay\response;


abstract class AbstractResponse implements ResponseInterface
{
    /**
     * @var array
     */
    protected $_response;

    /**
     * Успешность операции
     * @return bool
     */
    public function getSuccess(): bool
    {
        return $this->_response['Success'];
    }

    /**
     * Получить ошибку, которую вернул сервис оплаты
     * @return ErrorResponse|null
     */
    public function getError(): ?ErrorResponse
    {
        // TODO: Implement getError() method.
    }

    /**
     * Получить статус транзакции
     * @return string
     */
    public function getStatus(): string
    {
        // TODO: Implement getStatus() method.
    }

    /**
     * Уникальный идентификатор транзакции в сервисе оплаты
     * @return int
     */
    public function getPaymentId(): int
    {
        // TODO: Implement getPaymentId() method.
    }

    /**
     * Идентификатор терминала
     * @return string
     */
    public function getTerminalKey(): string
    {
        // TODO: Implement getTerminalKey() method.
    }

    /**
     * Номер заказа в системе
     * @return string
     */
    public function getOrderId(): string
    {
        // TODO: Implement getOrderId() method.
    }

    /**
     * Краткое описание ошибки
     * @return string|null
     */
    public function getMessage(): ?string
    {
        // TODO: Implement getMessage() method.
    }

    /**
     * Подробное описание ошибки
     * @return null|string
     */
    public function getDetails(): ?string
    {
        // TODO: Implement getDetails() method.
    }
}