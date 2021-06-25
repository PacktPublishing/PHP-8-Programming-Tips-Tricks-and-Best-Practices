<?php
declare(strict_types=1);
namespace Php8Test\Migration;
require __DIR__ . '/../../../src/Php8/Migration/BreakScan.php';
use ArrayIterator;
use PHPUnit\Framework\TestCase;
use Php8\Migration\BreakScan;
class BreakScanTest extends TestCase
{
    public $scanner = NULL;
    public $config = [];
    public $good_class = '';
    public $bad_class = '';
    public function setUp() : void
    {
        $this->config = require __DIR__ . '/../../../ch11/php8_bc_break_scanner_config.php';
        $this->scanner = new BreakScan($this->config);
        $this->bad_class = <<<EOT
<?php
namespace Fake\ Name \Space;
error_log(assert("xyz"));
class BadTest {
    public function badTest(string \$test = '') {
        \$test = is_real('real');
        return TRUE;
    }
    public function isResource()
    {
        \$ch = curl_init();
        if (!is_resource(\$ch))
            throw new Exception('Did not work');
    }
    public function __call(string \$name, string \$param) : Exception
    {
        sleep 5;
    }
    public function __invoke(\$name, \$args)
    {
        sleep 5;
    }
    public function __get(string \$name) : string
    {
        sleep 5;
    }
}
EOT;
        $this->real_class = <<<EOT
<?php
/* vim: set expandtab sw=4 ts=4 sts=4: */
/**
 * Holds the PhpMyAdmin\Controllers\Table\TableRelationController
 *
 * @package PhpMyAdmin\Controllers
 */
namespace PhpMyAdmin\Controllers\Table;

use PhpMyAdmin\Controllers\TableController;
use PhpMyAdmin\Core;
use PhpMyAdmin\DatabaseInterface;
use PhpMyAdmin\Index;
use PhpMyAdmin\Relation;
use PhpMyAdmin\Table;
use PhpMyAdmin\Template;
use PhpMyAdmin\Util;

/**
 * Handles table relation logic
 *
 * @package PhpMyAdmin\Controllers
 */
class TableRelationController extends TableController
{
    /**
     * @var array \$options_array
     */
    protected \$options_array;
EOT;

        $this->bad_class = str_replace(["\r","\n"], ' ', $this->bad_class);
        $this->good_class= <<<EOT
<?php
namespace Test\All\Good;
class Test {
    public function __construct(string \$test = '') {
        return TRUE;
    }
    public function test(string \$test = '') {
        return TRUE;
    }
    public function __call(string \$name, array \$param) : mixed
    {
        sleep 5;
    }
    public function __invoke(\$name, \$args, \$code)
    {
        /* do nothing */
    }
    public function __get(\$name) : int
    {
        /* do nothing */
    }
}
EOT;
        $this->good_class = str_replace(["\r","\n"], ' ', $this->good_class);
    }
    public function tearDown() : void
    {
        $this->scanner->clearMessages();
    }
    public function test_getKeyValue()
    {
        $expected = 'Test';
        $actual = BreakScan::getKeyValue($this->good_class, 'class', ' ');
        $this->assertEquals($expected, $actual);
    }
    public function testConfig_ERR_CLASS_CONSTRUCT()
    {
        $expected = TRUE;
        $actual = $this->config[BreakScan::KEY_CALLBACK]['ERR_CLASS_CONSTRUCT']['callback']($this->bad_class);
        $this->assertEquals($expected, $actual);
    }
    public function testConfig_ERR_ASSERT_IN_NAMESPACE()
    {
        $expected = TRUE;
        $actual = (bool) $this->config[BreakScan::KEY_CALLBACK]['ERR_ASSERT_IN_NAMESPACE']['callback']($this->bad_class);
        $this->assertEquals($expected, $actual);
    }
    public function test_scanIsResource()
    {
        $expected = TRUE;
        $this->scanner->contents = $this->bad_class;
        $actual = (bool) $this->scanner->scanIsResource();
        $this->assertEquals($expected, $actual);
    }
    public function test_scanRemovedFunctions()
    {
        $expected = TRUE;
        $this->scanner->contents = $this->bad_class;
        $actual = (bool) $this->scanner->scanRemovedFunctions();
        $this->assertEquals($expected, $actual);
    }
    public function test_ERR_SPACES_IN_NAMESPACE()
    {
        $expected = TRUE;
        $actual = $this->config[BreakScan::KEY_CALLBACK]['ERR_SPACES_IN_NAMESPACE']['callback']($this->bad_class);
        $this->assertEquals($expected, $actual);
    }
    public function test_scanMagicSignatures()
    {
        $expected = TRUE;
        $this->scanner->contents = $this->bad_class;
        $actual = (bool) $this->scanner->scanMagicSignatures();
        $this->assertEquals($expected, $actual);
    }
    public function test_invoke_correctMessagesForAllBadMagicMethodSignatures()
    {
        $this->scanner->contents = $this->bad_class;
        $this->scanner->scanMagicSignatures();
        $messages = $this->scanner->getMessages();
        $signature = $this->config[BreakScan::KEY_MAGIC]['__invoke']['signature'];
        $expected = FALSE;
        $actual   = in_array($signature, $messages, TRUE);
        $this->assertEquals($expected, $actual, '__invoke signature is OK and should not appear');
    }
    /*
    public function test_call_correctMessagesForBadMagicMethodSignatures()
    {
        $this->scanner->contents = $this->good_class;
        $this->scanner->scanMagicSignatures();
        $messages = $this->scanner->getMessages();
        $signature = $this->config[BreakScan::KEY_MAGIC]['__call']['signature'];
        $expected = TRUE;
        $actual   = in_array($signature, $messages, TRUE);
        $this->assertEquals($expected, $actual, '__call return type is incorrect but did not appear in messages');
    }
    public function test_confirmAllMagicMethodsAreDetected()
    {
        $this->scanner->contents = $this->bad_class;
        $this->scanner->scanMagicSignatures();
        $str   = implode(' ', $this->scanner->getMessages());
        $methods = ['__call', '__invoke', '__get'];
        $error = 'The following magic methods did not appear in messages: ';
        $expected = 3;
        $actual   = 0;
        foreach ($methods as $item) {
            if (strpos($str, $item) !== FALSE) {
                $error .= ' '. $item;
            } else {
                $actual++;
            }
        }
        $this->assertEquals($expected, $actual, $error);
    }
    */
}
