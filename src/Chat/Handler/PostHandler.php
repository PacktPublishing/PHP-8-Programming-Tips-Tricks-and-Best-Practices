<?php
declare(strict_types=1);
namespace Chat\Handler;

use Chat\Generic\Constants;
use Chat\Message\Validate;
use Chat\Service\Message as MessageService;
use Laminas\Diactoros\ResponseFactory;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

#[Chat\Handler\PostHandler]
class PostHandler implements RequestHandlerInterface
{
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $data = $request->getParsedBody();
        $message = new MessageService();
        if (!$message->save($data)) {
            return (new JsonResponse(['status' => 'fail', 'data' => Constants::ERR_MSG_SEND]))->withStatus(500);
        }
        return (new JsonResponse(['status' => 'success', 'data' => $data]))->withStatus(200);

    }
}
