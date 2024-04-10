<?php

namespace SiteStroy\Controllers;

use HemiFrame\Lib\SQLBuilder\QueryException;
use Laminas\Diactoros\Response\RedirectResponse;
use Laminas\Diactoros\ServerRequest;
use MiladRahimi\PhpRouter\View\View;
use SiteStroy\Entities\User;
use SiteStroy\Helpers\Cryptography;
use SiteStroy\Services\AuthService;

class UserController
{
    public function loginPage(View $view)
    {
        return $view->make('login');
    }

    public function registerPage(View $view)
    {
        return $view->make('register');
    }

    /**
     * Регистрация пользователя
     * @param View $view
     * @param ServerRequest $request
     * @param User $user
     * @return RedirectResponse|mixed
     */
    public function register(View $view, ServerRequest $request, User $user)
    {
        try {
            $errors = [];
            $body = $request->getParsedBody();

            if(!filter_var($body['email'], FILTER_VALIDATE_EMAIL)){
                $errors['email'] = 'Некорректный формат Email';
            }

            if(mb_strlen($body['password']) < 4){
                $errors['password'] = 'Слишком простой пароль';
            }

            if (count($errors)){
                return $view->make('register', ['errors' => $errors]);
            }

            $token = Cryptography::generateToken();
            $user->create([...$body, 'token' => $token,]);
            AuthService::setToken($token);

            return new RedirectResponse('/profile');
        } catch (QueryException $e) {
            return $view->make('register', ['registerError' => "Произошла ошибка регистрации"]);
        }
    }

    /**
     * Авторизация пользователя
     * @param View $view
     * @param ServerRequest $request
     * @param User $user
     * @return RedirectResponse|mixed
     */
    public function login(View $view, ServerRequest $request, User $user)
    {
        try {
            $errors = [];
            $body = $request->getParsedBody();

            if(!filter_var($body['email'], FILTER_VALIDATE_EMAIL)){
                $errors['email'] = 'Некорректный формат Email';
            }

            if(mb_strlen($body['password']) < 4){
                $errors['password'] = 'Ошибка при вводе пароля';
            }

            if (count($errors)){
                return $view->make('login', ['errors' => $errors]);
            }

            $userData = $user->getItem('email', $body['email']);

            if(!$userData){
                return $view->make('login', ['authError' => "Такого пользователя не существует"]);
            }

            if(!Cryptography::passwordVerify($body['password'], $userData['password'])){
                return $view->make('login', ['authError' => "Неправильный логин или пароль"]);
            }

            $token = Cryptography::generateToken();
            $user->update($userData['id'], ['token' => $token]);
            AuthService::setToken($token);

            return new RedirectResponse('/profile');
        }catch (QueryException $e){
            return $view->make('login', ['authError' => "Произошла ошибка авторизации"]);
        }

    }
}