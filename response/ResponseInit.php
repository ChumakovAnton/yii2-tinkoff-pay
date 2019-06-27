<?php

namespace chumakovanton\tinkoffPay\response;


class ResponseInit extends AbstractResponse
{
    /**
     * Сумма в копейках
     * @return null|int
     */
    public function getAmount(): ?int
    {
        return $this->response['Amount'] ?? null;
    }

    /**
     * Ссылка на страницу оплаты. По умолчанию ссылка доступна в течении 24 часов.
     * @return null|string(100)
     */
    public function getPaymentUrl(): ?string
    {
        return $this->response['PaymentURL'] ?? null;
    }
}