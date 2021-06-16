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
 * PmaSeleniumDbStructureTest class
 *
 * @package    PhpMyAdmin-test
 * @subpackage Selenium
 * @group      selenium
 */
class PMA_SeleniumDbStructureTest extends PMA_SeleniumBase
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
            . " PRIMARY KEY (`id`)"
            . ")"
        );
        $this->dbQuery(
            "CREATE TABLE `test_table2` ("
            . " `id` int(11) NOT NULL AUTO_INCREMENT,"
            . " `val` int(11) NOT NULL,"
            . " PRIMARY KEY (`id`)"
            . ")"
        );
        $this->dbQuery(
            "INSERT INTO `test_table` (val) VALUES (2);"
        );
    }

    /**
     * setUp function that can use the selenium session (called before each test)
     *
     * @return void
     */
    public function setUpPage()
    {
        $this->login();
        $this->waitForElement('byLinkText', $this->database_name)->click();
        $this->waitForElement(
            'byCssSelector',
            'li.last.table'
        );
        $this->waitForElement(
            "byXPath", "//a[contains(., 'test_table')]"
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
        $this->byXPath("(//a[contains(., 'Empty')])[1]")->click();

        $this->waitForElement(
            "byXPath",
            "//button[contains(., 'OK')]"
        )->click();

        $this->assertNotNull(
            $this->waitForElement(
                "byXPath",
                "//div[@class='success' and contains(., "
                . "'MySQL returned an empty result')]"
            )
        );

        $result = $this->dbQuery("SELECT count(*) as c FROM test_table");
        $row = $result->fetch_assoc();
        $this->assertEquals(0, $row['c']);
    }

    /**
     * Tests for dropping multiple tables
     *
     * @return void
     *
     * @group large
     */
    public function testDropMultipleTables()
    {
        $this->byCssSelector("label[for='tablesForm_checkall']")->click();
        $this->select($this->byName("submit_mult"))
            ->selectOptionByLabel("Drop");
        $this->waitForElement("byId", "buttonYes")
            ->click();

        $this->waitForElement(
            "byXPath",
            "//p[contains(., 'No tables found in database')]"
        );

        $result = $this->dbQuery("SHOW TABLES;");
        $this->assertEquals(0, $result->num_rows);

    }
}
