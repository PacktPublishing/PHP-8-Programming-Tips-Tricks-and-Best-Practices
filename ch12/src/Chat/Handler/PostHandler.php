<?php
declare(strict_types=1);
namespace Chat\Handler;

use Chat\Generic\Constants;
use Chat\Message\Validate;
use Laminas\Diactoros\ResponseFactory;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

#[Chat\Handler\PostHandler]
class PostHandler implements RequestHandlerInterface
{
    public function __construct(public ServerRequestInterface $request) {}
    public function handle(ServerRequestInterface $request): ResponseInterface
    {

    }
}
