<?php

use Doctrine\DBAL\Connection;

class SalesChannelRepository
{

    use BinaryTrait;

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
     * @param $languageId
     * @param $currencyId
     * @param $snippetSetId
     * @return void
     */
    public function updateAllLanguages($languageId, $currencyId, $snippetSetId)
    {
        $sql = "UPDATE sales_channel_domain SET 
                currency_id = '" . $this->stringToBinary($currencyId) . "', 
                language_id = '" . $this->stringToBinary($languageId) . "', 
                snippet_set_id = '" . $this->stringToBinary($snippetSetId) . "'
                ";

        $this->connection->executeQuery($sql);
    }

}
