<?php

namespace assets\assets\shopware6\files\Service;

use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\FetchMode;

class Connection
{

    /**
     * @param $host
     * @param $port
     * @param $user
     * @param $pwd
     * @param $db
     * @return mixed
     */
    public function connect($host, $port, $user, $pwd, $db)
    {
        $connString = "mysql://" . $user . ":" . $pwd . "@" . $host . ":" . $port . "/" . $db;

        $connection = DriverManager::getConnection(
            [
                'url' => $connString,
                'charset' => 'utf8mb4',
            ],
            new Configuration()
        );

        $connection->executeQuery('USE `shopware`');

        return $connection;
    }
}