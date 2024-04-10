<?php

namespace SiteStroy\Controllers;

use MiladRahimi\PhpRouter\View\View;
use Psr\Http\Message\ServerRequestInterface;
use SiteStroy\Entities\ToDoList;

class ProfileController
{
    /**
     * Функция отдающая страницу профиля
     * @param View $view
     * @param ServerRequestInterface $request
     * @param ToDoList $toDoList
     * @return mixed
     */
    public function profilePage(View $view, ServerRequestInterface $request, ToDoList $toDoList)
    {
        $user = $request->getAttribute('user');
        return $view->make('profile', ['list' => $toDoList->getByUserId((int)$user['id'])]);
    }
}