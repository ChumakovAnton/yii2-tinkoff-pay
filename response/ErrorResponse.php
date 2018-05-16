<?php
/**
 * Created by PhpStorm.
 * User: anton
 * Date: 07.09.17
 * Time: 15:36
 */

namespace chumakovanton\tinkoffPay\response;


class ErrorResponse
{
    private static $error_codes = [
        99 => 'Воспользуйтесь другой картой, банк выпустивший карту отклонил операцию',
        102 => 'Операция отклонена фрод-мониторингом.',
        101 => 'Не пройдена идентификация 3DS',
        1006 => 'Проверьте реквизиты или воспользуйтесь другой картой',
        1012 => 'Воспользуйтесь другой картой',
        1013 => 'Повторите попытку позже',
        1014 => 'Неверно введены реквизиты карты. Проверьте корректность введенных данных',
        1030 => 'Повторите попытку позже',
        1033 => 'Проверьте реквизиты или воспользуйтесь другой картой',
        1034 => 'Воспользуйтесь другой картой, банк выпустивший карту отклонил операцию',
        1041 => 'Воспользуйтесь другой картой, банк выпустивший карту отклонил операцию',
        1043 => 'Воспользуйтесь другой картой, банк выпустивший карту отклонил операцию',
        1051 => 'Недостаточно средств на карте',
        1054 => 'Проверьте реквизиты или воспользуйтесь другой картой',
        1057 => 'Воспользуйтесь другой картой, банк выпустивший карту отклонил операцию',
        1065 => 'Воспользуйтесь другой картой, банк выпустивший карту отклонил операцию',
        1082 => 'Проверьте реквизиты или воспользуйтесь другой картой',
        1089 => 'Воспользуйтесь другой картой, банк выпустивший карту отклонил операцию',
        1091 => 'Воспользуйтесь другой картой',
        1096 => 'Повторите попытку позже',
        9999 => 'Внутренняя ошибка системы',
    ];

    /**
     * @var int
     */
    private $_error_code;

    /**
     * @var string
     */
    private $_message;

    /**
     * @var string
     */
    private $_details;

    public function __construct(int $errorCode)
    {
        $this->_error_code = $errorCode;
    }

    /**
     * Description error code
     * @return mixed|string
     */
    public function getDescription()
    {
        if (!empty(self::$error_codes[$this->_error_code])){
            return self::$error_codes[$this->_error_code];
        }
        return '';
    }

    /**
     * @return null|string
     */
    public function getMessage(): ?string
    {
        return $this->_message;
    }

    /**
     * @param string $message
     * @return $this
     */
    public function setMessage(string $message): self
    {
        $this->_message = $message;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getDetails(): ?string
    {
        return $this->_details;
    }

    /**
     * @param string $details
     * @return $this
     */
    public function setDetails(string $details): self
    {
        $this->_details = $details;
        return $this;
    }


}