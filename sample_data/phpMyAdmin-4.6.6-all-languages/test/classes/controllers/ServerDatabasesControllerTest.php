<?php
/* vim: set expandtab sw=4 ts=4 sts=4: */
/**
 * Holds ServerDatabasesControllerTest class
 *
 * @package PhpMyAdmin-test
 */

use PMA\libraries\di\Container;
use PMA\libraries\Theme;

require_once 'libraries/url_generating.lib.php';
require_once 'libraries/mysql_charsets.lib.php';

require_once 'libraries/database_interface.inc.php';

require_once 'libraries/sanitizing.lib.php';
require_once 'libraries/js_escape.lib.php';

require_once 'test/libraries/stubs/ResponseStub.php';
require_once 'test/PMATestCase.php';

/**
 * Tests for ServerDatabasesController class
 *
 * @package PhpMyAdmin-test
 */

class ServerDatabasesControllerTest extends PMATestCase
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
        $GLOBALS['PMA_Config'] = new PMA\libraries\Config();
        $GLOBALS['PMA_Config']->enableBc();
        $GLOBALS['is_superuser'] = true;

        $GLOBALS['table'] = "table";
        $GLOBALS['replication_info']['master']['status'] = false;
        $GLOBALS['replication_info']['slave']['status'] = false;
        $GLOBALS['pmaThemeImage'] = 'image';
        $GLOBALS['text_dir'] = "text_dir";

        //$_SESSION
        $_SESSION['PMA_Theme'] = Theme::load('./themes/pmahomme');
        $_SESSION['PMA_Theme'] = new Theme();
        $GLOBALS['server'] = 1;

        $container = Container::getDefaultContainer();
        $container->set('dbi', $GLOBALS['dbi']);
        $this->response = new \PMA\Test\Stubs\Response();
        $container->set('PMA\libraries\Response', $this->response);
        $container->alias('response', 'PMA\libraries\Response');
    }

    /**
     * Tests for _getHtmlForDatabases
     *
     * @return void
     * @group medium
     */
    public function testGetHtmlForDatabase()
    {
        $class = new ReflectionClass('\PMA\libraries\controllers\server\ServerDatabasesController');
        $method = $class->getMethod('_getHtmlForDatabases');
        $method->setAccessible(true);

        $container = Container::getDefaultContainer();
        $container->factory('PMA\libraries\controllers\server\ServerDatabasesController');
        $container->alias(
            'ServerDatabasesController', 'PMA\libraries\controllers\server\ServerDatabasesController'
        );
        $ctrl = $container->get('ServerDatabasesController');

        //Call the test function
        $databases = array(
            array("SCHEMA_NAME" => "pma_bookmark"),
            array("SCHEMA_NAME" => "information_schema"),
            array("SCHEMA_NAME" => "mysql"),
            array("SCHEMA_NAME" => "performance_schema"),
            array("SCHEMA_NAME" => "phpmyadmin")
        );
        $property = $class->getProperty('_databases');
        $property->setAccessible(true);
        $property->setValue($ctrl, $databases);

        $property = $class->getProperty('_database_count');
        $property->setAccessible(true);
        $property->setValue($ctrl, 5);

        $property = $class->getProperty('_pos');
        $property->setAccessible(true);
        $property->setValue($ctrl, 0);

        $property = $class->getProperty('_dbstats');
        $property->setAccessible(true);
        $property->setValue($ctrl, 0);

        $property = $class->getProperty('_sort_by');
        $property->setAccessible(true);
        $property->setValue($ctrl, 'SCHEMA_NAME');

        $property = $class->getProperty('_sort_order');
        $property->setAccessible(true);
        $property->setValue($ctrl, 'asc');

        $replication_types = array("master", "slave");

        $html = $method->invoke($ctrl, $replication_types);

        //validate 1: General info
        $this->assertContains(
            '<div id="tableslistcontainer">',
            $html
        );

        //validate 2:ajax Form
        $this->assertContains(
            '<form class="ajax" action="server_databases.php" ',
            $html
        );

        $this->assertContains(
            '<table id="tabledatabases" class="data">',
            $html
        );

        //validate 3: PMA_getHtmlForColumnOrderWithSort
        $this->assertContains(
            '<a href="server_databases.php',
            $html
        );
        $this->assertContains(
            'sort_by=SCHEMA_NAME',
            $html
        );

        //validate 4: PMA_getHtmlAndColumnOrderForDatabaseList
        $this->assertRegExp(
            '/title="pma_bookmark"[[:space:]]*value="pma_bookmark"/',
            $html
        );
        $this->assertRegExp(
            '/title="information_schema"[[:space:]]*value="information_schema"/',
            $html
        );
        $this->assertRegExp(
            '/title="performance_schema"[[:space:]]*value="performance_schema"/',
            $html
        );
        $this->assertRegExp(
            '/title="phpmyadmin"[[:space:]]*value="phpmyadmin"/',
            $html
        );

        //validate 5: PMA_getHtmlForTableFooter
        $this->assertContains(
            'Total: <span id="databases_count">5</span>',
            $html
        );

        //validate 6: PMA_getHtmlForTableFooterButtons
        $this->assertContains(
            'Check all',
            $html
        );

        //validate 7: PMA_getHtmlForNoticeEnableStatistics
        $this->assertContains(
            'Note: Enabling the database statistics here might cause heavy traffic',
            $html
        );
        $this->assertContains(
            'Enable statistics',
            $html
        );
    }

    /**
     * Tests for _setSortDetails()
     *
     * @return void
     */
    public function testSetSortDetails()
    {
        $class = new ReflectionClass('\PMA\libraries\controllers\server\ServerDatabasesController');
        $method = $class->getMethod('_setSortDetails');
        $method->setAccessible(true);
        $propertySortBy = $class->getProperty('_sort_by');
        $propertySortBy->setAccessible(true);
        $propertySortOrder = $class->getProperty('_sort_order');
        $propertySortOrder->setAccessible(true);

        $container = Container::getDefaultContainer();
        $container->factory('PMA\libraries\controllers\server\ServerDatabasesController');
        $container->alias(
            'ServerDatabasesController', 'PMA\libraries\controllers\server\ServerDatabasesController'
        );
        $ctrl = $container->get('ServerDatabasesController');

        //$_REQUEST['sort_by'] and $_REQUEST['sort_order'] are empty
        $method->invoke($ctrl, array("master", "slave"));
        $this->assertEquals(
            'SCHEMA_NAME',
            $propertySortBy->getValue($ctrl)
        );
        $this->assertEquals(
            'asc',
            $propertySortOrder->getValue($ctrl)
        );

        $container = Container::getDefaultContainer();
        $container->factory('PMA\libraries\controllers\server\ServerDatabasesController');
        $container->alias(
            'ServerDatabasesController', 'PMA\libraries\controllers\server\ServerDatabasesController'
        );
        $ctrl = $container->get('ServerDatabasesController');

        // $_REQUEST['sort_by'] = 'DEFAULT_COLLATION_NAME'
        // and $_REQUEST['sort_order'] is not 'desc'
        $_REQUEST['sort_by'] = 'DEFAULT_COLLATION_NAME';
        $_REQUEST['sort_order'] = 'abc';
        $method->invoke($ctrl);
        $this->assertEquals(
            'DEFAULT_COLLATION_NAME',
            $propertySortBy->getValue($ctrl)
        );
        $this->assertEquals(
            'asc',
            $propertySortOrder->getValue($ctrl)
        );

        $container = Container::getDefaultContainer();
        $container->factory('PMA\libraries\controllers\server\ServerDatabasesController');
        $container->alias(
            'ServerDatabasesController', 'PMA\libraries\controllers\server\ServerDatabasesController'
        );
        $ctrl = $container->get('ServerDatabasesController');

        // $_REQUEST['sort_by'] = 'DEFAULT_COLLATION_NAME'
        // and $_REQUEST['sort_order'] is 'desc'
        $_REQUEST['sort_by'] = 'DEFAULT_COLLATION_NAME';
        $_REQUEST['sort_order'] = 'desc';
        $method->invoke($ctrl);
        $this->assertEquals(
            'DEFAULT_COLLATION_NAME',
            $propertySortBy->getValue($ctrl)
        );
        $this->assertEquals(
            'desc',
            $propertySortOrder->getValue($ctrl)
        );
    }

    /**
     * Tests for _getColumnOrder()
     *
     * @return void
     */
    public function testGetColumnOrder()
    {
        $class = new ReflectionClass('\PMA\libraries\controllers\server\ServerDatabasesController');
        $method = $class->getMethod('_getColumnOrder');
        $method->setAccessible(true);

        $container = Container::getDefaultContainer();
        $container->factory('PMA\libraries\controllers\server\ServerDatabasesController');
        $container->alias(
            'ServerDatabasesController', 'PMA\libraries\controllers\server\ServerDatabasesController'
        );
        $ctrl = $container->get('ServerDatabasesController');

        $this->assertEquals(
            array(
                'DEFAULT_COLLATION_NAME' => array(
                    'disp_name' => __('Collation'),
                    'description_function' => 'PMA_getCollationDescr',
                    'format'    => 'string',
                    'footer'    => 'utf8_general_ci'
                ),
                'SCHEMA_TABLES' => array(
                    'disp_name' => __('Tables'),
                    'format'    => 'number',
                    'footer'    => 0
                ),
                'SCHEMA_TABLE_ROWS' => array(
                    'disp_name' => __('Rows'),
                    'format'    => 'number',
                    'footer'    => 0
                ),
                'SCHEMA_DATA_LENGTH' => array(
                    'disp_name' => __('Data'),
                    'format'    => 'byte',
                    'footer'    => 0
                ),
                'SCHEMA_INDEX_LENGTH' => array(
                    'disp_name' => __('Indexes'),
                    'format'    => 'byte',
                    'footer'    => 0
                ),
                'SCHEMA_LENGTH' => array(
                    'disp_name' => __('Total'),
                    'format'    => 'byte',
                    'footer'    => 0
                ),
                'SCHEMA_DATA_FREE' => array(
                    'disp_name' => __('Overhead'),
                    'format'    => 'byte',
                    'footer'    => 0
                )
            ),
            $method->invoke($ctrl)
        );
    }
}
