<?php

require_once __DIR__ . '/autoload.php';
require_once '/var/www/html/vendor/autoload.php';


$newAccessKey = $argv[1];


$connectionFactory = new \ConnectionFactory();
$connection = ($connectionFactory)->build();

$apiKey = new \ApiSwitcher($connection);

$apiKey->setStoreApiKey($newAccessKey);
