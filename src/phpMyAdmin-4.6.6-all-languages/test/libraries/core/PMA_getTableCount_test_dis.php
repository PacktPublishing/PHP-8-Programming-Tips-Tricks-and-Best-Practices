<?php
/* vim: set expandtab sw=4 ts=4 sts=4: */
/**
 * PMA_getTableCount_test returns count of tables in given db
 *
 * @package PhpMyAdmin-test
 */

/*
 * Include to test.
 */

use PMA\libraries\Theme;

require_once 'libraries/js_escape.lib.php';
require_once 'libraries/select_lang.inc.php';
require_once 'libraries/sanitizing.lib.php';
require_once 'libraries/config.default.php';


require_once 'libraries/url_generating.lib.php';


require_once 'libraries/database_interface.inc.php';

require_once 'config.sample.inc.php';

/**
 * PMA_getTableCount_test returns count of tables in given db
 *
 * @package PhpMyAdmin-test
 */
class PMA_GetTableCount_Test extends PHPUnit_Framework_TestCase
{
    /**
     * Set up
     *
     * @return void
     */
    public function setUp()
    {
        $GLOBALS['PMA_Config'] = new PMA\libraries\Config();
        $GLOBALS['PMA_Config']->enableBc();
        $GLOBALS['cfg']['OBGzip'] = false;
        $_SESSION['PMA_Theme'] = new Theme();
        $GLOBALS['pmaThemeImage'] = 'theme/';
        $GLOBALS['pmaThemePath'] = $_SESSION['PMA_Theme']->getPath();
        $GLOBALS['server'] = 1;
        $GLOBALS['db'] = '';
        $GLOBALS['table'] = '';
    }

    /**
     * Test for PMA_getTableCount
     *
     * @return void
     */
    function testTableCount()
    {
        $GLOBALS['cfg']['Server']['host'] = 'localhost';
        $GLOBALS['cfg']['Server']['user'] = 'root';

        $this->assertEquals(5, PMA_getTableCount('meddb'));
    }
}
