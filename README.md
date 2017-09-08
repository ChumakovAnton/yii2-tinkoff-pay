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

$paymentService = Yii::$app->paymentService;

$paymentRequest = new RequestInit('order1', 1000);
$paymentRequest->addData('user_id', Yii::$app->user->id);

$response = $paymentService->initPay($paymentRequest);

$paymentUrl = $response->getPaymentUrl();

```
