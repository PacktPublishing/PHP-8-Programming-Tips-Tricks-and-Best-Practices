<?php
declare(strict_types=1);
namespace Chat\Handler;

use Chat\Generic\Constants;
use Chat\Message\Validate;
use Chat\Service\Message as MessageService;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

#[Chat\Handler\GetHandler]
class GetHandler implements RequestHandlerInterface
{
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $data   = $request->getQueryParams();
        $user   = $data['from'] ?? '*';
        if (!$result = (new MessageService())->findByUser($user)) {
            $data[] = Constants::ERR_NOT_USER;
            $data[] = Constants::USAGE;
            return (new JsonResponse(['status' => 'fail', 'data' => $data]))->withStatus(500);
        } else {
            return (new JsonResponse(['status' => 'success', 'data' => $data]))->withStatus(200);
        }
    }
}
