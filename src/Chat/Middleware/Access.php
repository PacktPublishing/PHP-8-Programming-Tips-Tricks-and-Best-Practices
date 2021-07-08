<?php
declare(strict_types=1);
namespace Chat\Middleware;

use Chat\Service\User;
use Chat\Generic\Constants;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

#[Chat\Middleware\Access]
class Access implements MiddlewareInterface
{
    public const ACCESS_LOG = __DIR__ . '/../../../access.log';
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $params = $request->getServerParams();
        $message = var_export($params, TRUE);
        file_put_contents(self::ACCESS_LOG, $message . "\n", FILE_APPEND);
        return $handler->handle($request);
    }
}
