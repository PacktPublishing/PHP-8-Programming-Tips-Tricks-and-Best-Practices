<?php
namespace ChatTest\Message;

use Laminas\Diactoros\Response\JsonResponse;
use Laminas\Diactoros\ServerRequestFactory;
use Chat\Handler\GetAllNamesHandler;
use PHPUnit\Framework\TestCase;
class GetAllNamesHandlerTest extends TestCase
{
    public $request;
    public function setUp() : void
    {
        $this->request = ServerRequestFactory::fromGlobals();
        $this->handler = new GetAllNamesHandler();
    }
    public function testHandlerReturnsJsonResponse()
    {
        $expected = JsonResponse::class;
        $result   = $this->handler->handle($this->request);
        $actual   = get_class($result);
        $this->assertEquals($expected, $actual);
    }
}
