<?php

namespace SiteStroy\Entities;

class ToDoList extends Entity
{
    protected string $table = "to_do_list";

    public function getByUserId(int $userId): array
    {
        $this->query
            ->select('*')
            ->from($this->table, 'td')
            ->andWhere('td.user_id', $userId)
            ->execute();

        return $this->query->fetchArrays();
    }

    public function toggle(int $userId, int $todoId, $value): void
    {
        $this->query
            ->update($this->table)
            ->set(['completed' => (int)$value])
            ->andWhere('user_id', $userId)
            ->andWhere('id', $todoId)
            ->execute();
    }

    public function deleteByUser(int $userId, int $todoId,)
    {
        $this->query
            ->delete()
            ->from($this->table)
            ->andWhere('user_id', $userId)
            ->andWhere('id', $todoId)
            ->execute();
    }
}