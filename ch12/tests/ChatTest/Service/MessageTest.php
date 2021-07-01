<?php
declare(strict_types=1);
namespace ChatTest\Service;

use Exception;
use DateTime;
use DateInterval;
use Chat\Service\Message;
use Chat\Generic\Constants;
use PHPUnit\Framework\TestCase;
class MessageTest extends TestCase
{
    public $message = NULL;
    public function setUp() : void
    {
        $this->message = new Message();
    }
    public function testSave()
    {
        $expected = 1;
        $user = 'xxx' . date('Ymd');
        $actual = $this->message->save(['from' => $user,'to' => $user,'msg' => 'xxx']);
        $this->assertEquals($expected, $actual, 'Failed to save message');
    }
    public function testRemove()
    {
        $expected = TRUE;
        $user = 'xxx' . date('Ymd');
        $actual = $this->message->remove($user);
        $this->assertEquals($expected, ($actual > 0), 'Failed to remove message by user');
    }
}
