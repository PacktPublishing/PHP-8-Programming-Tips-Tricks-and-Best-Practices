<?php
declare(strict_types=1);
namespace ChatTest\Handler;

use Chat\Handler\GetHandler;
use Laminas\Diactoros\ServerRequest;
use PHPUnit\Framework\TestCase;
class GetHandlerTest extends TestCase
{
    public $handler = NULL;
    public $request = NULL;
    public function setUp() : void
    {
        $this->handler = new GetHandler();
        $this->request = new ServerRequest();
    }
    public function testErrorResponse()
    {
        $this->assertEquals(1, 0);
    }
}
