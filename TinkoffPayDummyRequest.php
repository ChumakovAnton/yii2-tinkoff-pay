<?php
/**
 * Created by PhpStorm.
 * User: anton
 * Date: 08.09.17
 * Time: 14:41
 */

namespace chumakovanton\tinkoffPay;


class TinkoffPayDummyRequest extends TinkoffPay
{
    protected function _sendRequest(string $api_url, string $postData): string
    {
        $response = '<html><head><title>BadRequest</title></head><body>BadRequest</body></html>';
        switch (mb_substr($this->getApiUrl(), mb_strrpos($this->getApiUrl(), '/', 1))) {
            case 'Init': $response = '{"Success":true,"ErrorCode":"0","TerminalKey":"TestB","Status":"NEW","Paym
            entId":"13660","OrderId":"21050",
             "Amount":100000,"PaymentURL":"https://securepay.tinkoff.ru/rest/Authorize
            /1B63Y1"}'; break;
        }
        return $response;
    }
}