<?php
/* vim: set expandtab sw=4 ts=4 sts=4: */
/**
 * Selenium TestCase for table related tests
 *
 * @package    PhpMyAdmin-test
 * @subpackage Selenium
 */

require_once 'TestBase.php';

/**
 * PmaSeleniumTableOperationsTest class
 *
 * @package    PhpMyAdmin-test
 * @subpackage Selenium
 * @group      selenium
 */
class PMA_SeleniumTableOperationsTest extends PMA_SeleniumBase
{
    /**
     * Setup the browser environment to run the selenium test case
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->dbQuery(
            "CREATE TABLE `test_table` ("
            . " `id` int(11) NOT NULL AUTO_INCREMENT,"
            . " `val` int(11) NOT NULL,"
            . " `val2` int(11) NOT NULL,"
            . " PRIMARY KEY (`id`)"
            . ")"
        );
        $this->dbQuery("INSERT INTO test_table (val) VALUES (22)");
        $this->dbQuery("INSERT INTO test_table (val) VALUES (33)");
    }

    /**
     * setUp function that can use the selenium session (called before each test)
     *
     * @return void
     */
    public function setUpPage()
    {
        $this->login();
        $this->navigateTable('test_table');

        $this->expandMore();
        $this->byXPath("//a[contains(., 'Operations')]")->click();
        $this->sleep();
        $this->waitForElement(
            "byXPath",
            "//legend[contains(., 'Table maintenance')]"
        );
    }

    /**
     * Test for changing a table order
     *
     * @return void
     *
     * @group large
     */
    public function testChangeTableOrder()
    {
        /* FIXME: Need to create table which will allow this */
        $this->markTestIncomplete(
            'Changing order is not supported for some tables.'
        );
        $this->select($this->byName("order_field"))
            ->selectOptionByLabel("val");

        $this->byId("order_order_desc")->click();
        $this->byCssSelector(
            "form#alterTableOrderby input[type='submit']"
        )->click();

        $this->waitForElement(
            "byXPath",
            "//div[@class='success' and "
            . "contains(., 'Your SQL query has been executed successfully')]"
        );

        $this->byLinkText("Browse")->click();
        $this->waitForElement("byId", "table_results");

        $this->assertEquals(
            "2",
            $this->getCellByTableClass('table_results', 1, 5)
        );
    }

    /**
     * Test for moving a table
     *
     * @return void
     *
     * @group large
     */
    public function testMoveTable()
    {
        $this->byCssSelector("form#moveTableForm input[name='new_name']")
            ->value("2");

        $this->byCssSelector("form#moveTableForm input[type='submit']")->click();

        $this->waitForElement(
            "byXPath",
            "//div[@class='success' and "
            . "contains(., 'Table `" . $this->database_name
            . "`.`test_table` has been "
            . "moved to `" . $this->database_name . "`.`test_table2`.')]"
        );

        $result = $this->dbQuery("SHOW TABLES");
        $row = $result->fetch_assoc();
        $this->assertEquals(
            "test_table2",
            $row["Tables_in_" . $this->database_name]
        );
    }

    /**
     * Test for renaming a table
     *
     * @return void
     *
     * @group large
     */
    public function testRenameTable()
    {
        $this->byCssSelector("form#tableOptionsForm input[name='new_name']")
            ->value("2");

        $this->byName("comment")->value("foobar");

        $this->byCssSelector("form#tableOptionsForm input[type='submit']")->click();

        $this->waitForElement(
            "byXPath",
            "//div[@class='success' and "
            . "contains(., 'Table test_table has been renamed to test_table2')]"
        );

        $this->assertNotNull(
            $this->waitForElement(
                "byXPath",
                "//span[@id='span_table_comment' and contains(., 'foobar')]"
            )
        );

        $result = $this->dbQuery("SHOW TABLES");
        $row = $result->fetch_assoc();
        $this->assertEquals(
            "test_table2",
            $row["Tables_in_" . $this->database_name]
        );
    }

    /**
     * Test for copying a table
     *
     * @return void
     *
     * @group large
     */
    public function testCopyTable()
    {
        $this->byCssSelector("form#copyTable input[name='new_name']")->value("2");
        $this->byCssSelector("label[for='what_data']")->click();
        $this->byCssSelector("form#copyTable input[type='submit']")->click();

        $this->waitForElement(
            "byXPath",
            "//div[@class='success' and "
            . "contains(., 'Table `" . $this->database_name
            . "`.`test_table` has been "
            . "copied to `" . $this->database_name . "`.`test_table2`.')]"
        );

        $result = $this->dbQuery("SELECT COUNT(*) as c FROM test_table2");
        $row = $result->fetch_assoc();
        $this->assertEquals(
            2,
            $row["c"]
        );
    }

    /**
     * Test for truncating a table
     *
     * @return void
     *
     * @group large
     */
    public function testTruncateTable()
    {
        $this->byId("truncate_tbl_anchor")->click();
        $this->byXPath("//button[contains(., 'OK')]")->click();

        $this->waitForElement(
            "byXPath",
            "//div[@class='success' and "
            . "contains(., 'MySQL returned an empty result set')]"
        );

        $result = $this->dbQuery("SELECT COUNT(*) as c FROM test_table");
        $row = $result->fetch_assoc();
        $this->assertEquals(
            0,
            $row["c"]
        );
    }

    /**
     * Test for dropping a table
     *
     * @return void
     *
     * @group large
     */
    public function testDropTable()
    {
        $this->byId("drop_tbl_anchor")->click();
        $this->byXPath("//button[contains(., 'OK')]")->click();

        $this->waitForElement(
            "byXPath",
            "//div[@class='success' and "
            . "contains(., 'MySQL returned an empty result set')]"
        );

        $this->waitForElement(
            "byXPath",
            "//a[@class='tabactive' and contains(., 'Structure')]"
        );

        $result = $this->dbQuery("SHOW TABLES");
        $this->assertEquals(
            0,
            $result->num_rows
        );
    }
}
