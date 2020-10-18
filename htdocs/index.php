<?php
use app\XlsExchange;
use app\exception\XlsExchangeException;

require_once 'vendor/autoload.php';

mb_internal_encoding ('ISO-8859-1');

(new XlsExchange())
    ->setInputFile('/tmp/order.json')
    ->setOutputFile('/tmp/items.xlsx')
    /*->setOutputFtp(
        'ftp.xxxx.ru',
        'xxxx',
        'yyyy',
        '/zzz'
    )*/
    ->export();
