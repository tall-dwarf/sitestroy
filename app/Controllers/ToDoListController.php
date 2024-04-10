<?php

namespace SiteStroy\Controllers;

use Laminas\Diactoros\Response\JsonResponse;
use Laminas\Diactoros\ServerRequest;
use SiteStroy\Entities\ToDoList;

class ToDoListController
{
    /**
     * Изменение состояния Todo записи
     * @param ServerRequest $request
     * @param ToDoList $toDoList
     * @return JsonResponse
     */
    public function toggle(ServerRequest $request, ToDoList $toDoList)
    {
        try {
            $user = $request->getAttribute('user');
            $body = json_decode($request->getBody()->getContents(), true);
            $toDoList->toggle($user['id'], $body['todoId'], $body['value']);
            return new JsonResponse(['message' => 'Запись успешно обновлена']);
        }catch (\Exception $exception){
            return new JsonResponse(['message' => 'Ошибка обновления записи'], 400);
        }

    }

    /**
     * Создание Todo записи
     * @param ServerRequest $request
     * @param ToDoList $toDoList
     * @return JsonResponse
     */
    public function create(ServerRequest $request, ToDoList $toDoList)
    {
        try {
            $user = $request->getAttribute('user');
            $body = $request->getParsedBody();
            $todoId = $toDoList->create(['text' => $body['text'], 'user_id' => $user['id']]);
            return new JsonResponse(['message' => 'Запись успешно добавлена', 'todoId' => (int)$todoId]);
        }catch (\Exception $exception){
            return new JsonResponse(['message' => 'Ошибка создания записи'], 400);
        }
    }

    /**
     * Удаление Todo записи
     * @param ServerRequest $request
     * @param ToDoList $toDoList
     * @return JsonResponse
     */
    public function delete(ServerRequest $request, ToDoList $toDoList): JsonResponse
    {
        try {
            $user = $request->getAttribute('user');
            $body = json_decode($request->getBody()->getContents(), true);
            $toDoList->deleteByUser($user['id'], $body['todoId']);
            return new JsonResponse(['message' => 'Запись успешно удалена']);
        }catch (\Exception $exception){
            return new JsonResponse(['message' => 'Ошибка удаления записи'], 400);
        }
    }
}