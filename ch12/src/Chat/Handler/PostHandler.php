<?php
declare(strict_types=1);
namespace Chat\Handler;

use Chat\Generic\Constants;
use Chat\Message\Validate;
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
        $error = [];
        $data = $request->getParsedBody();
        if (!Validate::validatePost($data, $error)) {
            return (new JsonResponse(['status' => 'fail', 'data' => $error]))->withStatus(400);
        }
        $message = new MessageService();
        if (!$message->save($data)) {
            return (new JsonResponse(['status' => 'fail', 'data' => Constants::ERR_MSG_SEND]))->withStatus(500);
        }
        $data = $message->findByUser($data['from']);
        return (new JsonResponse(['status' => 'success', 'data' => $data]))->withStatus(200);

    }
}
