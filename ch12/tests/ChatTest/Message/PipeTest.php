<?php
namespace ChatTest\Message;

use Psr\Http\Message\StreamInterface;
use Laminas\Diactoros\ServerRequest;
use Chat\Message\Pipe;
use PHPUnit\Framework\TestCase;
class PipeTest extends TestCase
{
    const URL = 'http://localhost/ch12/php8_chat_ajax.php';
    public function setUp() : void
    {
        $this->request = new ServerRequest();
    }
    public function testPipeGetAllReturnsStreamInterface()
    {
        $request  = $this->request
                         ->withQueryParams(['all' => 1])
                         ->withHeader('Accept', 'text/html');
        $expected = TRUE;
        $response = Pipe::exec($request);
        $actual   = ($response instanceof StreamInterface);
        $this->assertEquals($expected, $actual);
    }
}
