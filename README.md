chumakovanton/yii2-tinkoff-pay
==========================
Extension for oplata.tinkoff.ru merchant API

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist chumakovanton/yii2-tinkoff-pay "*"
```

or add

```
"chumakovanton/yii2-tinkoff-pay": "*"
```

to the require section of your `composer.json` file.


Usage
-----

Config application :

```php
'components' => [
    //  ...
    'tinkoffPay' => [
            'class' => \chumakovanton\tinkoffPay\TinkoffPay::className(),
            'terminalKey' => 'terminalKey',
            'secretKey' => 'secretKey',
            'apiUrl' => 'https://securepay.tinkoff.ru/v2'
        ],
]

```

Once the extension is installed, simply use it in your code by  :

```php

/** @var \chumakovanton\tinkoffPay\TinkoffPay $paymentService */
$paymentService = Yii::$app->tinkoffPay;

$paymentRequest = $paymentService->initPay('order1', 1000);

$paymentRequest->addData('user_id', 123);

try {
    $response = $paymentRequest->send();
} catch (\chumakovanton\tinkoffPay\exceptions\HttpException $exception) {
    throw new \yii\web\HttpException($exception->statusCode, $exception->getMessage());
}

$paymentUrl = $response->getPaymentUrl();

```
