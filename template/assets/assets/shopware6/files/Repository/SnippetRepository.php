<?php

use Doctrine\DBAL\Connection;

class SnippetRepository
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
    public function getSnippetSetIdByLocale($locale)
    {
        $sql = "SELECT * FROM snippet_set";

        $rows = $this->connection->executeQuery($sql)->fetchAll();

        foreach ($rows as $row) {
            if ($row['iso'] === $locale) {
                return $this->binaryToString($row['id']);
            }
        }

        throw new \Exception('Snippet-Set ' . $locale . ' not found');
    }

}