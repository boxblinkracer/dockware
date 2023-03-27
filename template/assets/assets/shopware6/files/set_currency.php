<?php

require_once __DIR__ . '/autoload.php';
require_once '/var/www/html/vendor/autoload.php';


$newCurrency = $argv[1];

$connectionFactory = new \ConnectionFactory();
$connection = ($connectionFactory)->build();

$currency = new \CurrencyRepository($connection);

$currency->setDefaultCurrency($newCurrency);
