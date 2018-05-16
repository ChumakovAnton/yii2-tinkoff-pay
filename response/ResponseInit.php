<?php
/**
 * Created by PhpStorm.
 * User: anton
 * Date: 07.09.17
 * Time: 15:34
 */

namespace chumakovanton\tinkoffPay\response;


class ResponseInit extends AbstractResponse
{
    /**
     * Сумма в копейках
     * @return null|int
     */
    public function getAmount(): ?int
    {
        return $this->_response['Amount'];
    }

    /**
     * Ссылка на страницу оплаты. По умолчанию ссылка доступна в течении 24 часов.
     * @return null|string(100)
     */
    public function getPaymentUrl(): ?string
    {
        return $this->_response['PaymentURL'];
    }
}