<?php
declare(strict_types=1);
namespace Chat\Message;

use Chat\Generic\Constants;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ServerRequestInterface;

#[Chat\Message\Render]
class Render
{
    public static function output(ServerRequestInterface $request, JsonResponse $response)
    {
        $accept = $request->getHeader('accept')[0] ?? '';
        return (str_contains($accept, 'html'))
                ? self::outText($response)
                : self::outJson($response);
    }
    public static function outJson($response)
    {
        // output headers
        foreach ($response->getHeaders() as $name => $value) {
            header($name . ': ' . implode(';', $value));
        }
        return json_encode($response->getPayload());
    }
    public static function outText($response)
    {
        return $response->getBody();
    }
}
