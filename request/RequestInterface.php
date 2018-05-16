<?php
/**
 * Created by PhpStorm.
 * User: anton
 * Date: 07.09.17
 * Time: 14:55
 */

namespace chumakovanton\tinkoffPay\request;


interface RequestInterface
{
    /**
     * @param string $terminalKey
     * @return self
     */
    public function setTerminalKey(string $terminalKey): self;

    /**
     * @param string $secretKey
     * @return RequestInterface
     */
    public function setSecretKey(string $secretKey): self;

    /**
     * Сериализовать объект
     * @return null|string
     */
    public function serialize(): ?string;
}