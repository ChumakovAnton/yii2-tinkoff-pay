<?php
/**
 * Created by PhpStorm.
 * User: anton
 * Date: 07.09.17
 * Time: 15:35
 */

namespace chumakovanton\tinkoffPay\response;


use yii\helpers\Json;

abstract class AbstractResponse implements ResponseInterface
{
    /**
     * @var array
     */
    protected $_response;

    public function __construct(string $jsonResponse)
    {
        $this->_response = Json::decode($jsonResponse);
    }

    /**
     * Успешность операции
     * @return bool
     */
    public function getSuccess(): bool
    {
        return !empty($this->_response) && $this->_response['Success'];
    }

    /**
     * Получить ошибку, которую вернул сервис оплаты
     * @return ErrorResponse|null
     */
    public function getError(): ?ErrorResponse
    {
        $error = null;
        if ($this->_response['ErrorCode'] !== '0') {
            $error = new ErrorResponse($this->_response['ErrorCode']);
        }
        return $error;
    }

    /**
     * Получить статус транзакции
     * @return null|string
     */
    public function getStatus(): ?string
    {
        return $this->_response['Status'];
    }

    /**
     * Уникальный идентификатор транзакции в сервисе оплаты
     * @return null|int
     */
    public function getPaymentId(): ?int
    {
        return $this->_response['PaymentId'];
    }

    /**
     * Идентификатор терминала
     * @return null|string
     */
    public function getTerminalKey(): ?string
    {
        return $this->_response['TerminalKey'];
    }

    /**
     * Номер заказа в системе
     * @return null|string
     */
    public function getOrderId(): ?string
    {
        return $this->_response['OrderId'];
    }

    /**
     * Краткое описание ошибки
     * @return string|null
     */
    private function getMessage(): ?string
    {
        return $this->_response['Message'];
    }

    /**
     * Подробное описание ошибки
     * @return null|string
     */
    private function getDetails(): ?string
    {
        return $this->_response['Details'];
    }
}