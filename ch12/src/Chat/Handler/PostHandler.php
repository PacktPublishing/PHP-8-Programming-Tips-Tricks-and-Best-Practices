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
        $post = $request->getParsedBody();
        $data = [];
        $message = new MessageService();
        if (!$message->save($post)) {
            $data[] = Constants::ERR_MSG_SEND;
            $data[] = Constants::USAGE;
            return (new JsonResponse(['status' => 'fail', 'data' => $data]))->withStatus(500);
        } else {
            $data = sprintf(Constants::SUCCESS_OK, 'message sent');
            return (new JsonResponse(['status' => 'success', 'data' => $data]))->withStatus(200);
        }
    }
}
