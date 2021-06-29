<?php
declare(strict_types=1);
namespace Chat\Message;

use Chat\Generic\Constants;
use Laminas\Diactoros\Response\JsonResponse;

#[Chat\Message\Render]
class Render
{
    public static function output(JsonResponse $response)
    {
        // output headers
        foreach ($response->getHeaders() as $name => $value) {
            header($name . ': ' . implode(';', $value));
        }
        return $response->getBody();
    }
}
