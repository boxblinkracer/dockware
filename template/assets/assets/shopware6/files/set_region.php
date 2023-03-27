<?php

require_once __DIR__ . '/autoload.php';
require_once '/var/www/html/vendor/autoload.php';


$region = $argv[1];

$connectionFactory = new \ConnectionFactory();
$connection = ($connectionFactory)->build();

$switcher = new RegionSwitcher($connection);

$switcher->switchRegion($region);
