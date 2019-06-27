<?php

namespace chumakovanton\tinkoffPay;


use chumakovanton\tinkoffPay\request\RequestInit;
use yii\base\BaseObject;

/**
 * Class TinkoffPay
 *
 * @author Chumakov Anton <anton.4umakov@yandex.ru>
 *
 * @package chumakovanton\tinkoffPay
 *
 * @property string $terminalKey
 * @property string $secretKey
 * @property string $apiUrl
 */
class TinkoffPay extends BaseObject
{
    /**
     * @var string
     */
    private $_apiUrl;
    /**
     * @var string
     */
    private $_terminalKey;
    /**
     * @var string
     */
    private $_secretKey;

    /**
     * Initialize the payment
     *
     * @param string $orderId
     * @param int $amount
     * @return RequestInit
     */
    public function initPay(string $orderId, int $amount): RequestInit
    {
        $request = new RequestInit($orderId, $amount);

        $request->setCredentials($this->_apiUrl, $this->_terminalKey, $this->_secretKey);

        return $request;
    }

    /**
     * Get state of payment
     *
     * @param mixed $args Can be associative array or string
     *
     * @return mixed
     */
    public function getState($args)
    {
        return $this->buildQuery('GetState', $args);
    }

    /**
     * Confirm 2-staged payment
     *
     * @param mixed $args Can be associative array or string
     *
     * @return mixed
     */
    public function confirm($args)
    {
        return $this->buildQuery('Confirm', $args);
    }

    /**
     * Performs recursive (re) payment - direct debiting of funds from the
     * account of the Buyer's credit card.
     *
     * @param mixed $args Can be associative array or string
     *
     * @return mixed
     */
    public function charge($args)
    {
        return $this->buildQuery('Charge', $args);
    }

    /**
     * Registers in the terminal buyer Seller. (Init do it automatically)
     *
     * @param mixed $args Can be associative array or string
     *
     * @return mixed
     */
    public function addCustomer($args)
    {
        return $this->buildQuery('AddCustomer', $args);
    }

    /**
     * Returns the data stored for the terminal buyer Seller.
     *
     * @param mixed $args Can be associative array or string
     *
     * @return mixed
     */
    public function getCustomer($args)
    {
        return $this->buildQuery('GetCustomer', $args);
    }

    /**
     * Deletes the data of the buyer.
     *
     * @param mixed $args Can be associative array or string
     *
     * @return mixed
     */
    public function removeCustomer($args)
    {
        return $this->buildQuery('RemoveCustomer', $args);
    }

    /**
     * Returns a list of bounded card from the buyer.
     *
     * @param mixed $args Can be associative array or string
     *
     * @return mixed
     */
    public function getCardList($args)
    {
        return $this->buildQuery('GetCardList', $args);
    }

    /**
     * Removes the customer's bounded card.
     *
     * @param mixed $args Can be associative array or string
     *
     * @return mixed
     */
    public function removeCard($args)
    {
        return $this->buildQuery('RemoveCard', $args);
    }

    /**
     * The method is designed to send all unsent notification
     *
     * @return mixed
     * @throws \yii\web\HttpException
     */
    public function resend()
    {
        return $this->buildQuery('Resend', null);
    }

    /**
     * @param string $apiUrl
     * @return TinkoffPay
     */
    public function setApiUrl($apiUrl): TinkoffPay
    {
        $this->_apiUrl = $apiUrl;
        return $this;
    }

    /**
     * @param string $terminalKey
     * @return TinkoffPay
     */
    public function setTerminalKey($terminalKey): TinkoffPay
    {
        $this->_terminalKey = $terminalKey;
        return $this;
    }

    /**
     * @param string $secretKey
     * @return TinkoffPay
     */
    public function setSecretKey($secretKey): TinkoffPay
    {
        $this->_secretKey = $secretKey;
        return $this;
    }
}