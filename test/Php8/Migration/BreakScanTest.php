<?php
declare(strict_types=1);
namespace Php8Test\Migration;
use PHPUnit\Framework\TestCase;
use Php8\Migration\BreakScan;
class BreakScanTest extends TestCase
{
    public $scanner = NULL;
    public $config = [];
    public $contents = '';
    public function setUp() : void
    {
        $this->config = require __DIR__ . '/../../../ch11/php8_bc_break_scanner_config.php';
        $this->scanner = new BreakScan($this->config);
        $this->contents[0] = <<<EOT
<?php
namespace Fake\ Name \Space;
class Test
{
    public function test(string \$test = '')
    {
        return TRUE;
    }
}
EOT;
        $this->contents[0] = <<<EOT
<?php
namespace Test;
class Test
{
    public function __construct(string \$test = '')
    {
        return TRUE;
    }
    public function test(string \$test = '')
    {
        return TRUE;
    }
}
EOT;
        foreach ($this->contents as $key => $val)
            $this->contents[$key] = str_replace(["\r","\n"], ' ', $val);
    }
    public function testConfig_ERR_CLASS_CONSTRUCT()
    {
        $expected = TRUE;
        $actual = $this->config[BreakScan::KEY_CALLBACK]['ERR_CLASS_CONSTRUCT']['callback']($this->contents[0]);
        $this->assertEquals($expected, $actual, 'ERR_CLASS_CONSTRUCT does not locate method same name as class');
    }
    public function testConfig_ERR_ASSERT_IN_NAMESPACE()
    {
        $expected = TRUE;
        $actual = (bool) $this->config[BreakScan::KEY_CALLBACK]['ERR_ASSERT_IN_NAMESPACE']['callback']($this->contents[0]);
        $this->assertEquals($expected, $actual, 'ERR_ASSERT_IN_NAMESPACE does not detect spaces in namespace properly');
    }
}
