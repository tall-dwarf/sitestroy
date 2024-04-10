<?php

namespace SiteStroy\Helpers;

class Cryptography
{
    public static function passwordHash(string $password): string
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    public static function passwordVerify($password,string $hash): bool
    {
        return password_verify($password, $hash);
    }

    public static function generateToken(): string
    {
        return sha1(random_bytes(100)) . sha1(random_bytes(100));
    }
}