<?php
/**
 * Created by PhpStorm.
 * User: anton
 * Date: 07.09.17
 * Time: 14:54
 */

namespace chumakovanton\tinkoffPay\request;


use DateTime;
use yii\helpers\Json;

class RequestInit extends AbstractRequest
{
    /*** required ***/
    /**
     * Номер заказа в системе Продавца
     * @var string(50)
     */
    private $_orderId;

    /**
     * Сумма в копейках
     * @var int(10)
     */
    private $_amount;


    /*** not required ***/
    /**
     * IP-адрес клиента
     * @var string(40)
     */
    private $_IP;

    /**
     * Краткое описание
     * @var string(250)
     */
    private $_description;

    /**
     * Код валюты ISO 4217 (например, 643).
     * Если передан Currency, и он разрешен для Продавца,
     * то транзакция будет инициирована в переданной валюте.
     * Иначе будет использована валюта по умолчанию для данного терминала
     * @var int(3)
     */
    private $_currency;

    /**
     * Язык платёжной формы.
     * ru - форма оплаты на русском языке;
     * en - форма оплаты на англифском языке.
     * По умолчанию (если параметр не передан) - форма оплаты на русском языке.
     * @var string(2)
     */
    private $_language;

    /**
     * Идентификатор покупателя в системе Продавца.
     * Если передается,
     * то для данного покупателя будет осуществлена
     * привязка карты к данному идентификатору клиента CustomerKey.
     * В нотификации на AUTHORIZED будет передан параметр CardId,
     * подробнее см. метод GetGardList
     * Параметр обязателен, если Recurrent = Y
     * @var string(36)
     */
    private $_customerKey;

    /**
     * Если передается и установлен в Y,
     * то регистрирует платёж как рекуррентный.
     * В этом случае после оплаты в нотификации на AUTHORIZED
     * будет передан параметр RebillId для использования в методе Charge
     * @var string(1)
     */
    private $_recurrent;

    /**
     * Cрок жизни ссылки.
     * В случае, если текущая дата превышает дату переданную в данном параметре,
     * ссылка для оплаты становится недоступной и платёж выполнить нельзя.
     * Формат даты: YYYY-MM-DDTHH24:MI:SS+GMT
     * Пример даты: 2016-08-31T12:28:00+03:00
     * @var DateTime
     */
    private $_redirectDueDate;

    /**
     * JSON объект содержащий дополнительные параметры в виде “ключ”:”значение”.
     * Данные параметры будут переданы на страницу оплаты (в случае ее кастомизации).
     * Максимальная длина для каждого передаваемого параметра:
     *  - Ключ – 20 знаков,
     *  - Значение – 100 знаков.
     *
     * Максимальное количество пар «ключ-значение» не может превышать 20.
     * @var array
     */
    private $_data;

    /**
     * RequestInit constructor.
     * @param string $orderId Номер заказа в системе Продавца
     * @param int $amount Сумма в копейках
     */
    public function __construct(string $orderId, int $amount)
    {
        $this->setOrderId($orderId);
        $this->setAmount($amount);
    }

    /**
     * Функция заполняет свойство $_dataFields значениями полей запроса
     */
    protected function buildDataFields(): void
    {
        if (null !== $this->_amount) {
            $this->_dataFields['Amount'] = $this->getAmount();
        }
        if (null !== $this->_orderId) {
            $this->_dataFields['OrderId'] = $this->getOrderId();
        }
        if (null !== $this->_IP) {
            $this->_dataFields['IP'] = $this->getIP();
        }
        if (null !== $this->_description) {
            $this->_dataFields['Description'] = $this->getDescription();
        }
        if (null !== $this->_currency) {
            $this->_dataFields['Currency'] = $this->getCurrency();
        }
        if (null !== $this->_language) {
            $this->_dataFields['Language'] = $this->getLanguage();
        }
        if (null !== $this->_customerKey) {
            $this->_dataFields['CustomerKey'] = $this->getCustomerKey();
        }
        if (null !== $this->_recurrent) {
            $this->_dataFields['Recurrent'] = $this->getRecurrent();
        }
        if (null !== $this->_redirectDueDate) {
            $this->_dataFields['RedirectDueDate'] = $this->getRedirectDueDate();
        }
        if (null !== $this->_data) {
            $this->_dataFields['DATA'] = $this->getData();
        }
    }

    /**
     * Обрезать строку до максимальной длины
     * @param string $value Строка
     * @param int $maxLength Максимальная длина строки
     * @return null|string
     */
    private static function truncateString(string $value, int $maxLength): ?string
    {
        if (mb_strlen($value) > $maxLength) {
            return mb_substr($value, 0, $maxLength);
        }
        return $value;
    }

    /**
     * Добавить параметр в DATA
     * Максимальная длина для каждого передаваемого параметра:
     *  - Ключ – 20 знаков,
     *  - Значение – 100 знаков.
     *
     * Максимальное количество пар «ключ-значение» не может превышать 20.
     *
     * @param string $key Ключ
     * @param string $value Значение
     * @return self
     */
    public function addData(string $key, string $value): self
    {
        if (empty($key) || (count($this->_data) > 20))
        {
            return $this;
        }

        $key = self::truncateString($key, 20);
        $value = self::truncateString($value, 100);

        $this->_data[$key] = $value;
        return $this;
    }

    /**
     * Удалить значение из DATA по ключу
     * @param string $key Ключ
     * @return self
     */
    public function removeData(string $key): self
    {
        if (!empty($this->_data[$key])) {
            unset($this->_data[$key]);
        }
        return $this;
    }

    /**
     * @param string $orderId
     * @return self
     */
    public function setOrderId(string $orderId): self
    {
        $this->_orderId = self::truncateString($orderId, 50);
        return $this;
    }

    /**
     * @param int $amount
     * @return self
     */
    public function setAmount(int $amount): self
    {
        $this->_amount = $amount;
        return $this;
    }

    /**
     * @param string $IP
     * @return self
     */
    public function setIP(string $IP): self
    {
        $this->_IP = self::truncateString($IP, 40);
        return $this;
    }

    /**
     * @param string $description
     * @return self
     */
    public function setDescription(string $description): self
    {
        $this->_description = self::truncateString($description, 250);
        return $this;
    }

    /**
     * @param int $currency
     * @return self
     */
    public function setCurrency(int $currency): self
    {
        $this->_currency = $currency;
        return $this;
    }

    /**
     * @param string $language
     * @return self
     */
    public function setLanguage(string $language): self
    {
        $this->_language = self::truncateString($language, 2);
        return $this;
    }

    /**
     * @param string $customerKey
     * @return self
     */
    public function setCustomerKey(string $customerKey): self
    {
        $this->_customerKey = self::truncateString($customerKey, 36);
        return $this;
    }

    /**
     * @return self
     */
    public function setRecurrent(): self
    {
        $this->_recurrent = 'Y';
        return $this;
    }

    /**
     * @param DateTime $redirectDueDate
     * @return self
     */
    public function setRedirectDueDate(DateTime $redirectDueDate): self
    {
        $this->_redirectDueDate = $redirectDueDate;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getRedirectDueDate(): ?string
    {
        return $this->_redirectDueDate->format('Y-m-d\TH:i:s\Z');
    }

    /**
     * @return null|string
     * @throws \yii\base\InvalidParamException
     */
    public function getData(): ?string
    {
        return Json::encode($this->_data);
    }

    /**
     * @return null|string
     */
    public function getOrderId(): ?string
    {
        return $this->_orderId;
    }

    /**
     * @return null|int
     */
    public function getAmount(): ?int
    {
        return $this->_amount;
    }

    /**
     * @return null|string
     */
    public function getIP(): ?string
    {
        return $this->_IP;
    }

    /**
     * @return null|string
     */
    public function getDescription(): ?string
    {
        return $this->_description;
    }

    /**
     * @return null|int
     */
    public function getCurrency(): ?int
    {
        return $this->_currency;
    }

    /**
     * @return null|string
     */
    public function getLanguage(): ?string
    {
        return $this->_language;
    }

    /**
     * @return null|string
     */
    public function getCustomerKey(): ?string
    {
        return $this->_customerKey;
    }

    /**
     * @return null|string
     */
    public function getRecurrent(): ?string
    {
        return $this->_recurrent;
    }
}