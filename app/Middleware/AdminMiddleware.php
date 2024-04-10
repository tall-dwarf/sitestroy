<?php

namespace SiteStroy\Middleware;

use Closure;
use Laminas\Diactoros\Response\JsonResponse;
use Laminas\Diactoros\Response\RedirectResponse;
use Psr\Http\Message\ServerRequestInterface;

class AdminMiddleware
{
    function sendError(ServerRequestInterface $request,)
    {
        return count($request->getHeader('Content-Type')) === 0 ?
            new RedirectResponse('/404') :
            new JsonResponse(['message' => 'Ошибка'], 401);
    }

    public function handle(ServerRequestInterface $request, Closure $next)
    {
        $user = $request->getAttribute('user');
        if($user['role'] !== 'admin'){
            return $this->sendError($request);
        }

        return $next($request);
    }
}