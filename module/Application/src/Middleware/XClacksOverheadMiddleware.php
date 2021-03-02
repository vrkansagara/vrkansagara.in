<?php

declare(strict_types=1);

namespace Application\Middleware;

use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class XClacksOverheadMiddleware implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, DelegateInterface $delegate): ResponseInterface
    {
        $response = $delegate->handle($request);
        return $response->withHeader('X-Clacks-Overhead', 'GNU Terry Pratchett');
    }
}
