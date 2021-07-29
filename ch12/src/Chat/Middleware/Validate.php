<?php
declare(strict_types=1);
namespace Chat\Middleware;

use Chat\Service\User;
use Chat\Generic\Constants;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Laminas\Diactoros\Response\JsonResponse;

#[Chat\Middleware\Validate]
class Validate implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $error = [];
        $data = $request->getQueryParams();
        if (!$this->validateFromUser($data, $error))
            return (new JsonResponse(['status' => 'fail', 'data' => $error]))->withStatus(400);
        else
            return $handler->handle($request->withParsedBody($data));
    }
    public function validateFromUser(array $data, array &$message = [])
    {
        $found = TRUE;
        if (empty($data['from'])) {
            $message[] = Constants::ERR_FROM_USER;
            $found = FALSE;
        // this triggers a return of all usernames
        } elseif ($data['from'] === '*') {
            $found = TRUE;
        } else {
            $user = new User();
            $result = $user->findByUserName($data['from']);
            if (!$result || $data['from'] !== $result['username']) {
                $message[] = Constants::ERR_NOT_USER . ' [from]';
                $found = FALSE;
            }
        }
        return $found;
    }
}
