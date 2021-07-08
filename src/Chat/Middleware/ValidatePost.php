<?php
declare(strict_types=1);
namespace Chat\Middleware;

use Chat\Service\User;
use Chat\Generic\Constants;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

#[Chat\Middleware\ValidatePost]
class ValidatePost extends Validate
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $error = [];
        $data = $request->getParsedBody();
        $expect = 3;
        $actual = 0;
        $actual += (int) $this->validateFromUser($data, $error);
        $actual += (int) $this->validateToUser($data, $error);
        $actual += (int) $this->validateMessage($data, $error);
        if ($expect ===  $actual)
            return $handler->handle($request->withParsedBody($data));
        else
            return (new JsonResponse(['status' => 'fail', 'data' => $error]))->withStatus(400);
    }
    public function validateToUser(array &$data, array &$message = [])
    {
        $found = TRUE;
        if (empty($data['to'])) {
            $data['to'] = '*';
        }
        if ($data['to'] === '*') return TRUE;
        $user = new User();
        $result = $user->findByUserName($data['to']);
        if (!$result || $data['to'] !== $result['username']) {
            $message[] = Constants::ERR_NOT_USER . ' [to]';
            $found = FALSE;
        }
        return $found;
    }
    public function validateMessage(array &$data, array &$message = [])
    {
        $errors = 0;
        if (empty($data['msg'])) {
            $message[] = Constants::ERR_MSG_NOT;
            $errors++;
        } else {
            $data['msg'] = strip_tags($data['msg']);
            if (strlen($data['msg']) > Constants::DEFAULT_MSG_LEN) {
                $errors++;
                $message[] = Constants::ERR_MSG_LEN;
            }
        }
        return ($errors === 0);
    }
}
