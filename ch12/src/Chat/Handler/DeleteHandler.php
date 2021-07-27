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
        $fail = FALSE;
        $post = $request->getParsedBody();
        $user = $post['from'] ?? '';
        $user = strip_tags(trim($user));
        $data = [];
        if (empty($user)) {
            $fail = TRUE;
            $data[] = Constants::ERR_FROM_USER;
        } else {
            $message = new MessageService();
            if (!$message->remove($user)) {
                $fail = TRUE;
                $data[] = Constants::ERR_MSG_SEND;
            } else {
                $data = sprintf(Constants::SUCCESS_OK, $user . ' removed');
            }
        }
        if ($fail) {
            $data[] = Constants::USAGE;
            return (new JsonResponse(['status' => 'fail', 'data' => $data]))->withStatus(500);
        } else {
            return (new JsonResponse(['status' => 'success', 'data' => $data]))->withStatus(200);
        }
    }
}
