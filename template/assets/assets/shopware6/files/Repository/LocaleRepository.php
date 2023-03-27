<?php

use Doctrine\DBAL\Connection;

class LocaleRepository
{

    use \BinaryTrait;


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
     * @param string $locale
     * @return mixed
     * @throws \Exception
     */
    public function getIdByLocale($locale)
    {
        $sql = "SELECT * FROM locale";

        $rows = $this->connection->executeQuery($sql)->fetchAll();

        foreach ($rows as $row) {
            if ($row['code'] === $locale) {
                return $this->binaryToString($row['id']);
            }
        }

        throw new \Exception('Locale ' . $locale . ' not found');
    }

}