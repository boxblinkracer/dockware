<?php

use Doctrine\DBAL\Connection;


class ApiSwitcher
{

    /**
     * @var Connection
     */
    private $connection;

    /**
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @param $key
     */
    public function setStoreApiKey($key)
    {

        $key = strtoupper($key);

        /**
         * So Shopware can work with the new sales channel api key, it needs the prefix swsc
         * Check if the prefix was provided, otherwise set it
         */
        $identifier = mb_substr($key, 0, 4);

        if ($identifier !== 'SWSC') {
            $key = 'SWSC' . $key;
        }

        $sql = "
        START TRANSACTION;
        
        UPDATE sales_channel
        LEFT JOIN sales_channel_domain
        ON sales_channel.id = sales_channel_domain.sales_channel_id
        SET access_key = '" . $key . "'
        WHERE sales_channel_domain.url = 'http://localhost';
        
        COMMIT;
        ";

        $this->connection->executeQuery($sql);

        echo $key;
    }

}