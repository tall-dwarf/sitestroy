<?php

namespace SiteStroy\Services;

use HemiFrame\Lib\SQLBuilder\QueryException;
use SiteStroy\Entities\User;

class AuthService
{
    /**
     * Сохранение токена и времени жизни токена в куках
     * @param string $token
     * @return void
     */
    public static function setToken(string $token): void
    {
        $time = (new \DateTime())->add(new \DateInterval('PT6H'))->format('U');
        $time = base64_encode(serialize($time));
        setcookie('token', "$time:$token", 0, '/', '', false, true);
    }

    /**
     * Получение пользователя по его токену сохранённому в куках
     * @return array|null
     * @throws QueryException
     */
    public static function getUserByToken(): null|array
    {
        if (empty($_COOKIE['token'])) {
            return null;
        }

        $data = explode(":", $_COOKIE['token'], 2);

        if(count($data) != 2){
            setcookie('token', '', -10, '/', '', false, true);
            return null;
        }
//        czoxMDoiMTcxMjYzMDIzNiI7%3Ae6bbffc0d6288e1aeac337990b1863cd48a6d78fb5710b87f9137a633e25ad354c84d4f806f9431e
        [$time, $token] = $data;
        $time = unserialize(base64_decode($time));

        if(!is_numeric($time)){
            setcookie('token', '', -10, '/', '', false, true);
            return null;
        }

        if(($time - (new \DateTime())->format('U')) < 0){
            setcookie('token', '', -10, '/', '', false, true);
            return null;
        }

        $user = new User();
        return $user->getItem('token', $token);

    }
}