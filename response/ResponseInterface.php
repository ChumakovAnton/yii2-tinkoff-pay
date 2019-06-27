<?php

namespace chumakovanton\tinkoffPay\response;


/**
 * Interface ResponseInterface
 * @package chumakovanton\tinkoffPay\response
 */
interface ResponseInterface
{
    /**
     * Код ответа
     * @return int
     */
    public function getStatusCode(): int;

    /**
     * Успешность операции
     * @return bool
     */
    public function isSuccess(): bool;

    /**
     * Получить статус транзакции
     * @return string
     */
    public function getStatus(): ?string;

    /**
     * Уникальный идентификатор транзакции в сервисе оплаты
     * @return int
     */
    public function getPaymentId(): ?int;

    /**
     * Идентификатор терминала
     * @return string
     */
    public function getTerminalKey(): ?string;

    /**
     * Номер заказа в системе
     * @return string
     */
    public function getOrderId(): ?string;
}