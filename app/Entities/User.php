<?php

namespace SiteStroy\Entities;

use SiteStroy\Helpers\Cryptography;

class User extends Entity
{
    protected string $table = 'user';

    public function create(array $params): string
    {
        parent::create([...$params, 'password' => Cryptography::passwordHash($params['password'])]);
        return $this->query->getLastInsertId();
    }
}