<?php

use Doctrine\DBAL\Connection;

class LanguageRepository
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
     * @param $localeId
     * @return mixed
     */
    public function getIdByLocale($localeId)
    {
        # somehow where does not work...and i'm not in the mood right now
        $sql = "SELECT * FROM language";

        $rows = $this->connection->executeQuery($sql)->fetchAll();

        foreach ($rows as $row) {
            $currentLocale = $this->binaryToString($row['locale_id']);

            if ($currentLocale === $localeId) {

                return $this->binaryToString($row['id']);
            }
        }

    }

}