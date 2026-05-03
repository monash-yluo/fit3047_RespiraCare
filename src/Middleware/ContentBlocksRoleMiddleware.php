<?php

declare(strict_types=1);

namespace App\Middleware;

use Cake\Http\Exception\NotFoundException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class ContentBlocksRoleMiddleware implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $params = $request->getAttribute('params') ?? [];
        $plugin = $params['plugin'] ?? null;
        $controller = $params['controller'] ?? null;
    
        if ($plugin === 'ContentBlocks' && $controller === 'ContentBlocks') {
            $identity = $request->getAttribute('identity');

            if (!$identity || $identity->get('role') !== 'admin') {
                throw new NotFoundException('Page not found');
            }
        }

        return $handler->handle($request);
    }
}
