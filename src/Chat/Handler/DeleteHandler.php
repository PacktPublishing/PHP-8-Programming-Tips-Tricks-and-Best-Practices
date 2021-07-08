<?php
declare(strict_types=1);
namespace Chat\Handler;

use Chat\Generic\Constants;
use Chat\Service\Message as MessageService;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

#[Chat\Handler\GetHandler]
class DeleteHandler implements RequestHandlerInterface
{
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $result = (new MessageService())->reset();
        return (new JsonResponse(['status' => 'success', 'data' => $result]))->withStatus(200);
    }
}
