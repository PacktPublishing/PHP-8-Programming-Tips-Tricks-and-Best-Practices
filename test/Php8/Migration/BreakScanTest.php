<?php
declare(strict_types=1);
namespace Php8Test\Migration;
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
}
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
}
EOT;
        $this->good_class = str_replace(["\r","\n"], ' ', $this->good_class);
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
}
