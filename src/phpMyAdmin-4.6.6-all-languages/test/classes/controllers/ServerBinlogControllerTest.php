<?php
/* vim: set expandtab sw=4 ts=4 sts=4: */
/**
 * Holds ServerBinlogControllerTest
 *
 * @package PhpMyAdmin-test
 */

use PMA\libraries\Theme;
use PMA\libraries\controllers\server\ServerBinlogController;
use PMA\libraries\di\Container;
use PMA\libraries\Util;

require_once 'test/PMATestCase.php';
require_once 'libraries/url_generating.lib.php';
require_once 'libraries/database_interface.inc.php';
require_once 'libraries/sanitizing.lib.php';
require_once 'libraries/js_escape.lib.php';

/**
 * Tests for ServerCollationsController class
 *
 * @package PhpMyAdmin-test
 */
class ServerBinlogControllerTest extends PMATestCase
{
    /**
     * Prepares environment for the test.
     *
     * @return void
     */
    public function setUp()
    {
        //$_REQUEST
        $_REQUEST['log'] = "index1";
        $_REQUEST['pos'] = 3;

        //$GLOBALS
        $GLOBALS['cfg']['MaxRows'] = 10;
        $GLOBALS['server'] = 1;
        $GLOBALS['cfg']['ServerDefault'] = "server";
        $GLOBALS['cfg']['RememberSorting'] = true;
        $GLOBALS['cfg']['SQP'] = array();
        $GLOBALS['cfg']['MaxCharactersInDisplayedSQL'] = 1000;
        $GLOBALS['cfg']['ShowSQL'] = true;
        $GLOBALS['cfg']['TableNavigationLinksMode'] = 'icons';
        $GLOBALS['cfg']['LimitChars'] = 100;

        $GLOBALS['table'] = "table";
        $GLOBALS['pmaThemeImage'] = 'image';

        //$_SESSION
        $_SESSION['PMA_Theme'] = Theme::load('./themes/pmahomme');
        $_SESSION['PMA_Theme'] = new Theme();

        Util::cacheSet('profiling_supported', true);

        $binary_log_file_names = array();
        $binary_log_file_names[] = array("Log_name"=>"index1", "File_size"=>100);
        $binary_log_file_names[] = array("Log_name"=>"index2", "File_size"=>200);

        //Mock DBI
        $dbi = $this->getMockBuilder('PMA\libraries\DatabaseInterface')
            ->disableOriginalConstructor()
            ->getMock();
        $dbi->expects($this->once())->method('fetchResult')
            ->will($this->returnValue($binary_log_file_names));
        $container = Container::getDefaultContainer();
        $container->set('dbi', $dbi);
    }

    /**
     * Tests for _getLogSelector
     *
     * @return void
     */
    public function testGetLogSelector()
    {
        $url_params = array();
        $url_params['log'] = "log";
        $url_params['dontlimitchars'] = 1;

        $class = new ReflectionClass('\PMA\libraries\controllers\server\ServerBinlogController');
        $method = $class->getMethod('_getLogSelector');
        $method->setAccessible(true);

        $ctrl = new ServerBinlogController();
        $html = $method->invoke(
            $ctrl,
            $url_params
        );

        $this->assertContains(
            'Select binary log to view',
            $html
        );
        $this->assertContains(
            '<option value="index1" selected="selected">',
            $html
        );
        $this->assertContains(
            '<option value="index2">',
            $html
        );
    }

    /**
     * Tests for _getLogInfo
     *
     * @return void
     * @group medium
     */
    public function testGetLogInfo()
    {
    	$class = new ReflectionClass('\PMA\libraries\controllers\server\ServerBinlogController');
    	$method = $class->getMethod('_getLogInfo');
    	$method->setAccessible(true);
    	$ctrl = new ServerBinlogController();

        //Mock DBI
    	$container = Container::getDefaultContainer();
        $dbi = $container->get('dbi');

        //expects return value
        $result = array(
            array(
                "SHOW BINLOG EVENTS IN 'index1' LIMIT 3, 10",
                null,
                1,
                true,
                array("log1"=>"logd")
            ),
            array(
                array("log2"=>"logb"),
                null,
                0,
                false,
                'executed'
            )
        );
        $value = array(
                'Info' => "index1_Info",
                'Log_name' => "index1_Log_name",
                'Pos' => "index1_Pos",
                'Event_type' => "index1_Event_type",
                'End_log_pos' => "index1_End_log_pos",
                'Server_id' => "index1_Server_id",
        );
        $count = 3;

        //expects functions
        $dbi->expects($this->once())->method('query')
            ->will($this->returnValue($result));

        $dbi->expects($this->once())->method('numRows')
            ->will($this->returnValue($count));

        $dbi->expects($this->at(0))->method('fetchAssoc')
            ->will($this->returnValue($value));

        $dbi->expects($this->at(1))->method('fetchAssoc')
            ->will($this->returnValue(false));

        $container->set('dbi', $dbi);

        //Call the test function
        $url_params = array();
        $url_params['log'] = "log";
        $url_params['dontlimitchars'] = 1;
        $html = $method->invoke($ctrl, $url_params);

        //validate 1: the sql has been executed
        $this->assertContains(
            'Your SQL query has been executed successfully',
            $html
        );
        //validate 2: SQL
        $this->assertContains(
            "SHOW BINLOG EVENTS IN 'index1' LIMIT 3, 10",
            $html
        );
        //validate 3: BINLOG HTML
        $this->assertContains(
            '<table id="binlogTable">',
            $html
        );
        //validate 4: PMA_getNavigationRow is right
        $urlNavigation = 'server_binlog.php?log=log&amp;dontlimitchars=1&amp;'
            . 'pos=3&amp;server=1&amp';
        $this->assertContains(
            $urlNavigation,
            $html
        );
        $this->assertContains(
            'title="Previous"',
            $html
        );
        //validate 5: Log Item
        $this->assertContains(
            'Log name',
            $html
        );
        $this->assertContains(
            'Position',
            $html
        );
        $this->assertContains(
            'Event type',
            $html
        );
        $this->assertContains(
            'Server ID',
            $html
        );
        $this->assertContains(
            'Original position',
            $html
        );
    }

    /**
     * Tests for _getAllLogItemInfo
     *
     * @return void
     */
    public function testGetAllLogItemInfo()
    {
    	$class = new ReflectionClass('\PMA\libraries\controllers\server\ServerBinlogController');
    	$method = $class->getMethod('_getAllLogItemInfo');
    	$method->setAccessible(true);
    	$ctrl = new ServerBinlogController();

        //Mock DBI
    	$container = Container::getDefaultContainer();
        $dbi = $container->get('dbi');

        $fetchAssoc = array(
            'Info' => 'Info',
            'Log_name' => 'Log_name',
            'Pos' => 'Pos',
            'Event_type' => 'Event_type',
            'Server_id' => 'Server_id',
            'Orig_log_pos' => 'Orig_log_pos',
            'End_log_pos' => 'End_log_pos',
        );
        $dbi->expects($this->at(0))->method('fetchAssoc')
            ->will($this->returnValue($fetchAssoc));
        $dbi->expects($this->at(1))->method('fetchAssoc')
            ->will($this->returnValue(false));
        $container->set('dbi', $dbi);

        $GLOBALS['cfg']['LimitChars'] = 2;

        $result = array();
        $dontlimitchars = ";";
        $html = $method->invoke($ctrl, $result, $dontlimitchars);

        $value = $fetchAssoc;
        $this->assertContains(
            $value['Log_name'],
            $html
        );
        $this->assertContains(
            $value['Pos'],
            $html
        );
        $this->assertContains(
            $value['Event_type'],
            $html
        );
        $this->assertContains(
            $value['Server_id'],
            $html
        );
        $this->assertContains(
            $value['Orig_log_pos'],
            $html
        );
        $this->assertContains(
            htmlspecialchars($value['Info']),
            $html
        );
    }
}
