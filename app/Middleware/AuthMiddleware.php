<?php

namespace SiteStroy\Middleware;
use Closure;
use Laminas\Diactoros\Response\JsonResponse;
use Laminas\Diactoros\Response\RedirectResponse;
use Psr\Http\Message\ServerRequestInterface;
use SiteStroy\Services\AuthService;

class AuthMiddleware
{
    function sendError(ServerRequestInterface $request,)
    {
        return count($request->getHeader('Content-Type')) === 0 ?
            new RedirectResponse('/404') :
            new JsonResponse(['message' => 'Ошибка авторизации'], 401);
    }

    public function handle(ServerRequestInterface $request, Closure $next)
    {
        $user = AuthService::getUserByToken();
        if(!$user){
            return $this->sendError($request);
        }
        return $next($request->withAttribute('user', $user));
    }
}