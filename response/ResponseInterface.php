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
    public function getSuccess(): bool;

    /**
     * Получить ошибку, которую вернул сервис оплаты
     * @return ErrorResponse|null
     */
    public function getError(): ?ErrorResponse;

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