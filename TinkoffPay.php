<?php
/**
 * Created by PhpStorm.
 * User: anton
 * Date: 07.09.17
 * Time: 11:24
 */

namespace chumakovanton\tinkoffPay;


use chumakovanton\tinkoffPay\request\RequestInit;
use chumakovanton\tinkoffPay\request\RequestInterface;
use chumakovanton\tinkoffPay\response\ResponseInit;
use RuntimeException;
use yii\base\Object;

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
class TinkoffPay extends Object
{
    /**
     * @var string
     */
    private $_api_url;
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
     * @param RequestInit $request mixed You could use associative array or url params string
     *
     * @return ResponseInit
     * @throws RuntimeException
     */
    public function initPay(RequestInit $request): ResponseInit
    {
        return new ResponseInit($this->buildQuery('Init', $request));
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
     * Builds a query string and call sendRequest method.
     * Could be used to custom API call method.
     *
     * @param string $path API method name
     * @param RequestInterface $request query params
     *
     * @return string JSON string response
     * @throws RuntimeException
     */
    protected function buildQuery(string $path, RequestInterface $request): string
    {
        $url = $this->_api_url;

        $url = $this->_combineUrl($url, $path);

        $postData = $request->setSecretKey($this->_secretKey)
            ->setTerminalKey($this->_terminalKey)
            ->serialize();

        return $this->_sendRequest($url, $postData);
    }

    /**
     * Combines parts of URL. Simply gets all parameters and puts '/' between
     *
     * @return string
     */
    protected function _combineUrl(): string
    {
        $args = func_get_args();
        $url = '';
        foreach ($args as $arg) {
            if (is_string($arg)) {
                if ($arg[strlen($arg) - 1] !== '/') {
                    $arg .= '/';
                }
                $url .= $arg;
            } else {
                continue;
            }
        }

        return $url;
    }

    /**
     * Main method. Call API with params
     *
     * @param string $api_url API Url
     * @param string $postData Data in JSON string
     * @return string JSON string response
     * @throws RuntimeException
     *
     */
    protected function _sendRequest(string $api_url, string $postData): string
    {
        if ($curl = curl_init()) {
            curl_setopt($curl, CURLOPT_URL, $api_url);
            curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_POST, true);
            if (!empty($postData)) {
                curl_setopt($curl, CURLOPT_POSTFIELDS, $postData);
            }
            $out = curl_exec($curl);
            curl_close($curl);

            return $out;
        }

        throw new RuntimeException(
            'Can not create connection to ' . $api_url . ' with args '
            . $postData, 404
        );
    }

    /**
     * @param string $api_url
     * @return TinkoffPay
     */
    public function setApiUrl($api_url): TinkoffPay
    {
        $this->_api_url = $api_url;
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

    /**
     * @return string
     */
    protected function getApiUrl(): string
    {
        return $this->_api_url;
    }
}