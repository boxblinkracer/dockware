<?php

use Doctrine\DBAL\Connection;


class CurrencyRepository
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
     * @param $iso
     * @return void
     */
    public function getIdByIso($iso)
    {
        # somehow where does not work...and i'm not in the mood right now
        $sql = "SELECT * FROM currency";

        $rows = $this->connection->executeQuery($sql)->fetchAll();

        foreach ($rows as $row) {
            if ($row['iso_code'] === $iso) {

                return $this->binaryToString($row['id']);
            }
        }

    }

    /**
     * @param string $currency
     */
    public function setDefaultCurrency($currency)
    {
        $sql = "SELECT factor FROM currency WHERE iso_code = '" . $currency . "'";

        $row = $this->connection->executeQuery($sql)->fetch();

        $factor = $row['factor'];

        if ((double)$factor === 1.0) {
            # already default
            return;
        }

        $sql = "
            START TRANSACTION;
            
            SET @defaultID = (SELECT id FROM currency WHERE iso_code = 'EUR');
            SET @otherID = (SELECT id FROM currency WHERE iso_code = '" . $currency . "');
            UPDATE currency SET id = 'temp' WHERE iso_code = 'EUR';
            UPDATE currency SET id = @defaultID WHERE iso_code = '" . $currency . "';
            UPDATE currency SET id = @otherID WHERE iso_code = 'EUR';
            
            SET @fixFactor = (SELECT 1/factor FROM currency WHERE iso_code = '" . $currency . "');
            UPDATE currency SET factor = IF(iso_code = '" . $currency . "', 1, factor * @fixFactor);
            
            COMMIT;
        ";

        $this->connection->executeQuery($sql);

    }
}