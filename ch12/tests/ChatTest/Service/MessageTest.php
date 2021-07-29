<?php
declare(strict_types=1);
namespace ChatTest\Service;

use Exception;
use PDO;
use DateTime;
use DateInterval;
use Chat\Service\Message;
use Chat\Generic\Constants;
use PHPUnit\Framework\TestCase;
class MessageTest extends TestCase
{
    public $message = NULL;
    public $user    = '';
    public function setUp() : void
    {
        $this->message = new Message();
        $this->user = 'xxx' . date('Ymd');
    }
    public function testGetConnection()
    {
        $expected = TRUE;
        $actual   = $this->message->getConnection() instanceof PDO;
        $this->assertEquals($expected, $actual, 'Failed to return PDO instance');
    }
    public function testSave()
    {
        $expected = 1;
        $actual = $this->message->save(['from' => $this->user,'to' => $this->user,'msg' => 'xxx']);
        $this->assertEquals($expected, $actual, 'Failed to save message');
    }
    public function testDoExec()
    {
        $username = strip_tags(strtolower($this->user));
        $sql['table'] = Message::TABLE;
        $sql['where'] = ['user_from=?',' OR user_to=?'," OR user_to='*'"];
        $sql['order'] = 'created DESC';
        $actual   = $this->message->do_exec([$username,$username], $sql, []) ?? FALSE;
        $expected = TRUE;
        $this->assertEquals($expected, is_array($actual), 'Array not returned');
    }
    public function testDoExecContentIsCorrect()
    {
        $username = strip_tags(strtolower($this->user));
        $sql['table'] = Message::TABLE;
        $sql['where'] = ['user_from=?',' OR user_to=?'," OR user_to='*'"];
        $sql['order'] = 'created DESC';
        $actual   = $this->message->do_exec([$username,$username], $sql, []) ?? FALSE;
        $expected = 'xxx';
        $msg      = $actual[0]['msg'];
        $this->assertEquals($expected, $msg, 'Message contents not correct');
    }
    public function testBuildSelect()
    {
        $expected = "SELECT * FROM messages WHERE user_from=? OR user_to=? OR user_to='*' ORDER BY created DESC LIMIT 20";
        $sql['table'] = Message::TABLE;
        $sql['where'] = ['user_from=?',' OR user_to=?'," OR user_to='*'"];
        $sql['order'] = 'created DESC';
        $actual = $this->message->buildSelect($sql);
        $this->assertEquals($expected, $actual, 'SQL statement not built properly');
    }
    public function testFindByUser()
    {
        $expected = TRUE;
        $actual = $this->message->findByUser($this->user);
        $this->assertEquals($expected, is_array($actual), 'Failed to get messages');
        $this->assertEquals($expected, !empty($actual), 'Array is empty');
    }
    public function testFindByUserMessageContentCorrect()
    {
        $expected = 'xxx';
        $actual   = $this->message->findByUser($this->user);
        $msg      = $actual[0]['msg'];
        $this->assertEquals($expected, $msg, 'Message content not returned');
    }
    public function testRemove()
    {
        $expected = TRUE;
        $actual = $this->message->remove($this->user);
        $this->assertEquals($expected, ($actual > 0), 'Failed to remove messages by user');
    }
    public function testFindByUserDoesntExistReturnsEmptyArray()
    {
        $expected = [];
        $actual = $this->message->findByUser($this->user);
        $this->assertEquals($expected, $actual, 'Failed to return empty array if user does not exist');
    }
}
