<?php
declare(strict_types=1);
namespace ChatTest\Service;

use Exception;
use DateTime;
use DateInterval;
use Chat\Service\Base;
use Chat\Generic\Constants;
use PHPUnit\Framework\TestCase;
class BaseTest extends TestCase
{
    public function setUp() : void
    {
        $this->base = new Base();
    }
    public function testBuildSelectThrowsExceptionIfSqlTableNotSet()
    {
        $sql['tablet'] = 'messages';
        $sql['where'] = ['user_from=?'];
        $sql['order'] = 'created DESC';
        $expected = TRUE;
        try {
            $actual = $this->base->buildSelect($sql);
        } catch (Exception $e) {
            $actual = TRUE;
        }
        $this->assertEquals($expected, $actual, 'Exception not thrown');
    }
    public function testBuildSelect()
    {
        $sql['table'] = 'messages';
        $sql['where'] = ['user_from=?'];
        $sql['order'] = 'created DESC';
        $expected = 'SELECT * FROM messages WHERE user_from=? ORDER BY created DESC';
        $actual = $this->base->buildSelect($sql);
        $this->assertEquals($expected, $actual);
    }
    public function testBuildSelectReturnsSpecifiedColumns()
    {
        $sql['table'] = 'users';
        $sql['cols'] = 'id,username';
        $expected = 'SELECT id,username FROM users';
        $actual = $this->base->buildSelect($sql);
        $this->assertEquals($expected, $actual);
    }
    public function testExpandSql()
    {
        $sql['table'] = 'messages';
        $sql['where'] = ['user_from=?'];
        $sql['order'] = 'created DESC';
        $opts['limit'] = 88;
        $opts['offset'] = 99;
        $expected = 'SELECT * FROM messages WHERE user_from=? ORDER BY created DESC LIMIT 88 OFFSET 99';
        $actual = $this->base->buildSelect($sql, $opts);
        $this->assertEquals($expected, $actual);
    }
    public function testExpandSqlDate()
    {
        $sql['table'] = 'messages';
        $sql['where'] = ['user_from=?'];
        $sql['order'] = 'created DESC';
        $opts['days'] = 14;
        $days = new DateTime();
        $days->add(new DateInterval('P14D'));
        $str = $days->format(Constants::DATE_FORMAT);
        $expected = "SELECT * FROM messages WHERE user_from=? AND datetime >= '$str' ORDER BY created DESC";
        $actual = $this->base->buildSelect($sql, $opts);
        $this->assertEquals($expected, $actual);
    }
    public function testGetConnectionReturnsPDO()
    {
        $expected = 'PDO';
        $actual   = get_class($this->base->getConnection());
        $this->assertEquals($expected, $actual);
    }
}
