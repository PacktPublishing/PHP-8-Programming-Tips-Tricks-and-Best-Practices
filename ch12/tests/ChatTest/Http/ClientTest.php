<?php
namespace ChatTest\Http;

use Chat\Http\Client;
use PHPUnit\Framework\TestCase;
class ClientTest extends TestCase
{
    const URL = 'http://localhost/ch12/php8_chat_ajax.php';
    public function testGetAllIncludesStatusKey()
    {
        $url  = self::URL . '?all=1';
        $data = Client::doGet($url);
        $expected = 'status';
        $actual = array_keys($data);
        $this->assertEquals($expected, $actual[0]);
    }
    public function testGetAllIncludesDataKey()
    {
        $url  = self::URL . '?all=1';
        $data = Client::doGet($url);
        $expected = 'data';
        $actual = array_keys($data);
        $this->assertEquals($expected, $actual[1]);
    }
    public function testGetAllReturnsListOfUsers()
    {
        $url  = self::URL . '?all=1';
        $data = Client::doGet($url);
        $expected = TRUE;
        $actual = is_array($data);
        $this->assertEquals($expected, $actual);
    }
    public function testPostReturnsError()
    {
        $post = ['from' => 'doesnotexist', 'msg' => 'xxxxxx'];
        $data = Client::doPost(self::URL, $post);
        $expected = 'fail';
        $actual = $data['status'] ?? '';
        $this->assertEquals($expected, $actual);
    }
    public function testValidPostReturnsSameEntry()
    {
        $msg  = 'TEST: ' . date('Y-m-d H:i:s');
        $post = ['from' => 'acaya', 'msg' => $msg];
        $data = Client::doPost(self::URL, $post);
        $expected = $msg;
        $actual = $data['data']['msg'] ?? '';
        $this->assertEquals($expected, $actual);
    }
}
