<?php

namespace SiteStroy\Entities;

use HemiFrame\Lib\SQLBuilder\Query;
use HemiFrame\Lib\SQLBuilder\QueryException;

class Entity
{
    protected Query $query;
    protected string $table;
    public function __construct()
    {
        $pdo = new \PDO('mysql:host=localhost;dbname=sitestroy', 'root', 'root', [
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
        ]);
        $pdo->exec("set names utf8");
        Query::$global['pdo'] = $pdo;
        $this->query = new Query();
    }

    /**
     * @throws QueryException
     */
    public function create(array $params): string
    {
        $this->query = new Query();
        $this->query
            ->insertInto($this->table)
            ->set($params)
            ->execute();

        return $this->query->getLastInsertId();
    }

    /**
     * @throws QueryException
     */
    public function update(int $id, $params): void
    {
        $this->query = new Query();
        $this->query
            ->update($this->table)
            ->set($params)
            ->andWhere('id', $id)
            ->execute();
    }

    /**
     * @throws QueryException
     */
    public function getItem(string $field, string|int $value): ?array
    {
        $this->query = new Query();
        $this->query
            ->select('*')
            ->from($this->table)
            ->andWhere($field, $value)
            ->execute();
        return $this->query->fetchFirstArray();
    }

    /**
     * @throws QueryException
     */
    public function getAll(array $params): array
    {
        $this->query = new Query();
        $this->query
            ->select('*')
            ->from($this->table)
            ->execute();
        return $this->query->fetchArrays();
    }

    /**
     * @param int $id
     * @return void
     * @throws QueryException
     */
    public function delete(int $id): void
    {
        $this->query
            ->delete()
            ->from($this->table)
            ->andWhere('id', $id)
            ->execute();
    }
}