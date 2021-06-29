<?php
declare(strict_types=1);
namespace ChatTest\Service;

use Exception;
use DateTime;
use DateInterval;
use Chat\Service\User;
use Chat\Generic\Constants;
use PHPUnit\Framework\TestCase;
class UserTest extends TestCase
{
    public function setUp() : void
    {
        $this->user = new User();
    }
    public function testFindByUsername()
    {
        $expected = 1;
        $actual = $this->user->findByUserName('acaya')['id'];
        $this->assertEquals($expected, $actual);
    }
    public function testFindById()
    {
        $expected = 'acaya';
        $actual = $this->user->findById(1)['username'];
        $this->assertEquals($expected, $actual);
    }
}
