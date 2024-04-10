<?php

namespace SiteStroy\Controllers;

use HemiFrame\Lib\SQLBuilder\QueryException;
use Laminas\Diactoros\Response\JsonResponse;
use Laminas\Diactoros\ServerRequest;
use MiladRahimi\PhpRouter\View\View;
use SiteStroy\Entities\ToDoList;
use SiteStroy\Entities\User;

class AdminController
{
    /**
     * Функция отдающая страницу администратора
     * @param User $user
     * @param ToDoList $toDoList
     * @param View $view
     * @return mixed
     * @throws QueryException
     */
    public function index(User $user, ToDoList $toDoList, View $view)
    {
        $users = $user->getAll([]);
        $allToDo = $toDoList->getAll([]);

        foreach ($users as $key => $user){
            $users[$key]['todos'] = array_filter($allToDo, fn($todo) => $todo['user_id'] == $user['id']);
        }

        return $view->make('admin', ['users' => $users]);
    }

    /**
     * Создание Todo записи
     * @param ServerRequest $request
     * @param ToDoList $toDoList
     * @return JsonResponse
     * @throws QueryException
     */
    public function createTodo(ServerRequest $request, ToDoList $toDoList)
    {
        $data = $request->getParsedBody();
        $toDoList->create([ 'user_id' => (int)$data['userId'], 'text' => $data['text']]);
        return new JsonResponse(['message' => 'Запись успешно добавлена']);
    }

    /**
     * Изменение состояния Todo записи
     * @param ServerRequest $request
     * @param ToDoList $toDoList
     * @return JsonResponse
     * @throws QueryException
     */
    public function changeTodo(ServerRequest $request, ToDoList $toDoList)
    {
        $data = json_decode($request->getBody()->getContents(), true);
        $toDoList->update((int)$data['todoId'], ['completed' => (int)$data['value']]);
        return new JsonResponse(['message' => 'Запись успешно обновлена']);
    }

    /**
     * Удаление Todo записи
     * @param ServerRequest $request
     * @param ToDoList $toDoList
     * @return JsonResponse
     * @throws QueryException
     */
    public function deleteTodo(ServerRequest $request, ToDoList $toDoList)
    {
        $data = json_decode($request->getBody()->getContents(), true);
        $toDoList->delete($data['todoId']);
        return new JsonResponse(['message' => 'Запись успешно удалена']);

    }
}