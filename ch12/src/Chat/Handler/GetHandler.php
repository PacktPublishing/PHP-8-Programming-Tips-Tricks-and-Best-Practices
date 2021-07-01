<?php
declare(strict_types=1);
namespace Chat\Handler;

use Chat\Generic\Constants;
use Chat\Message\Validate;
use Chat\Service\Message as MessageService;
use Chat\Service\User as UserService;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

#[Chat\Handler\GetHandler]
class GetHandler implements RequestHandlerInterface
{
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $data    = $request->getQueryParams();
        $user    = $data['from'] ?? '*';
        $result  = ($user === '*')
                 ? (new UserService())->findAllUserNames()
                 : (new MessageService())->findByUser($user);
        return (new JsonResponse(['status' => 'success', 'data' => $result]))->withStatus(200);
    }
}
