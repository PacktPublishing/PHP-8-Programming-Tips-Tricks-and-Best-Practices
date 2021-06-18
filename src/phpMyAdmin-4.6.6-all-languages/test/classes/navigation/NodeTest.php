<?php
/* vim: set expandtab sw=4 ts=4 sts=4: */
/**
 * Tests for Node class
 *
 * @package PhpMyAdmin-test
 */

use PMA\libraries\navigation\NodeFactory;
use PMA\libraries\navigation\nodes\Node;
use PMA\libraries\Theme;

require_once 'libraries/navigation/NodeFactory.php';
require_once 'libraries/database_interface.inc.php';
require_once 'test/PMATestCase.php';

/**
 * Tests for Node class
 *
 * @package PhpMyAdmin-test
 */
class NodeTest extends PMATestCase
{
    /**
     * SetUp for test cases
     *
     * @return void
     */
    public function setup()
    {
        $GLOBALS['server'] = 0;
        $GLOBALS['cfg']['Server']['DisableIS'] = false;
        $_SESSION['PMA_Theme'] = Theme::load('./themes/pmahomme');
    }

    /**
     * SetUp for AddNode
     *
     * @return void
     */
    public function testAddNode()
    {
        $parent = NodeFactory::getInstance('Node', 'parent');
        $child = NodeFactory::getInstance('Node', 'child');
        $parent->addChild($child);
        $this->assertEquals(
            $parent->getChild($child->name),
            $child
        );
        $this->assertEquals(
            $parent->getChild($child->real_name, true),
            $child
        );
    }

    /**
     * SetUp for getChild
     *
     * @return void
     */
    public function testGetChildError()
    {
        $parent = NodeFactory::getInstance('Node', 'parent');
        $this->assertEquals(
            $parent->getChild("foo"),
            false
        );
        $this->assertEquals(
            $parent->getChild("foo", true),
            false
        );
    }

    /**
     * SetUp for getChild
     *
     * @return void
     */
    public function testRemoveNode()
    {
        $parent = NodeFactory::getInstance('Node', 'parent');
        $child = NodeFactory::getInstance('Node', 'child');
        $parent->addChild($child);
        $this->assertEquals(
            $parent->getChild($child->name),
            $child
        );
        $parent->removeChild($child->name);
        $this->assertEquals(
            $parent->getChild($child->name),
            false
        );
    }

    /**
     * SetUp for hasChildren
     *
     * @return void
     */
    public function testNodeHasChildren()
    {
        $parent = NodeFactory::getInstance();
        $empty_container = NodeFactory::getInstance(
            'Node', 'empty', Node::CONTAINER
        );
        $child = NodeFactory::getInstance();
        // test with no children
        $this->assertEquals(
            $parent->hasChildren(true),
            false
        );
        $this->assertEquals(
            $parent->hasChildren(false),
            false
        );
        // test with an empty container
        $parent->addChild($empty_container);
        $this->assertEquals(
            $parent->hasChildren(true),
            true
        );
        $this->assertEquals(
            $parent->hasChildren(false),
            false
        );
        // test with a real child
        $parent->addChild($child);
        $this->assertEquals(
            $parent->hasChildren(true),
            true
        );
        $this->assertEquals(
            $parent->hasChildren(false),
            true
        );
    }

    /**
     * SetUp for numChildren
     *
     * @return void
     */
    public function testNumChildren()
    {
        // start with root node only
        $parent = NodeFactory::getInstance();
        $this->assertEquals($parent->numChildren(), 0);
        // add a child
        $child = NodeFactory::getInstance();
        $parent->addChild($child);
        $this->assertEquals($parent->numChildren(), 1);
        // add a direct grandchild, this one doesn't count as
        // it's not enclosed in a CONTAINER
        $child->addChild(NodeFactory::getInstance());
        $this->assertEquals($parent->numChildren(), 1);
        // add a container, this one doesn't count wither
        $container = NodeFactory::getInstance(
            'Node', 'default', Node::CONTAINER
        );
        $parent->addChild($container);
        $this->assertEquals($parent->numChildren(), 1);
        // add a grandchild to container, this one counts
        $container->addChild(NodeFactory::getInstance());
        $this->assertEquals($parent->numChildren(), 2);
        // add another grandchild to container, this one counts
        $container->addChild(NodeFactory::getInstance());
        $this->assertEquals($parent->numChildren(), 3);
    }

    /**
     * SetUp for parents
     *
     * @return void
     */
    public function testParents()
    {
        $parent = NodeFactory::getInstance();
        $this->assertEquals($parent->parents(), array()); // exclude self
        $this->assertEquals($parent->parents(true), array($parent)); // include self

        $child = NodeFactory::getInstance();
        $parent->addChild($child);

        $this->assertEquals($child->parents(), array($parent)); // exclude self
        $this->assertEquals(
            $child->parents(true),
            array($child, $parent)
        ); // include self
    }

    /**
     * SetUp for realParent
     *
     * @return void
     */
    public function testRealParent()
    {
        $parent = NodeFactory::getInstance();
        $this->assertEquals($parent->realParent(), false);

        $child = NodeFactory::getInstance();
        $parent->addChild($child);
        $this->assertEquals($child->realParent(), $parent);
    }

    /**
     * Tests whether Node->hasSiblings() method returns false
     * when the node does not have any siblings.
     *
     * @return void
     * @test
     */
    public function testHasSiblingsWithNoSiblings()
    {
        $parent = NodeFactory::getInstance();
        $child = NodeFactory::getInstance();
        $parent->addChild($child);
        $this->assertEquals(false, $child->hasSiblings());
    }

    /**
     * Tests whether Node->hasSiblings() method returns true
     * when it actually has siblings.
     *
     * @return void
     * @test
     */
    public function testHasSiblingsWithSiblings()
    {
        $parent = NodeFactory::getInstance();
        $firstChild = NodeFactory::getInstance();
        $parent->addChild($firstChild);
        $secondChild = NodeFactory::getInstance();
        $parent->addChild($secondChild);
        // Normal case; two Node:NODE type siblings
        $this->assertEquals(true, $firstChild->hasSiblings());

        $parent = NodeFactory::getInstance();
        $firstChild = NodeFactory::getInstance();
        $parent->addChild($firstChild);
        $secondChild = NodeFactory::getInstance(
            'Node', 'default', Node::CONTAINER
        );
        $parent->addChild($secondChild);
        // Empty Node::CONTAINER type node should not be considered in hasSiblings()
        $this->assertEquals(false, $firstChild->hasSiblings());

        $grandChild = NodeFactory::getInstance();
        $secondChild->addChild($grandChild);
        // Node::CONTAINER type nodes with children are counted for hasSiblings()
        $this->assertEquals(true, $firstChild->hasSiblings());
    }

    /**
     * It is expected that Node->hasSiblings() method always return true
     * for Nodes that are 3 levels deep (columns and indexes).
     *
     * @return void
     * @test
     */
    public function testHasSiblingsForNodesAtLevelThree()
    {
        $parent = NodeFactory::getInstance();
        $child = NodeFactory::getInstance();
        $parent->addChild($child);
        $grandChild = NodeFactory::getInstance();
        $child->addChild($grandChild);
        $greatGrandChild = NodeFactory::getInstance();
        $grandChild->addChild($greatGrandChild);

        // Should return false for node that are two levels deeps
        $this->assertEquals(false, $grandChild->hasSiblings());
        // Should return true for node that are three levels deeps
        $this->assertEquals(true, $greatGrandChild->hasSiblings());
    }

    /**
     * Tests private method _getWhereClause()
     *
     * @return void
     * @test
     */
    public function testGetWhereClause()
    {
        $method = new ReflectionMethod(
            'PMA\libraries\navigation\nodes\Node', '_getWhereClause'
        );
        $method->setAccessible(true);

        // Vanilla case
        $node = NodeFactory::getInstance();
        $this->assertEquals(
            "WHERE TRUE ", $method->invoke($node, 'SCHEMA_NAME')
        );

        // When a schema names is passed as search clause
        $this->assertEquals(
            "WHERE TRUE AND `SCHEMA_NAME` LIKE '%schemaName%' ",
            $method->invoke($node, 'SCHEMA_NAME', 'schemaName')
        );

        if (! isset($GLOBALS['cfg']['Server'])) {
            $GLOBALS['cfg']['Server'] = array();
        }

        // When hide_db regular expression is present
        $GLOBALS['cfg']['Server']['hide_db'] = 'regexpHideDb';
        $this->assertEquals(
            "WHERE TRUE AND `SCHEMA_NAME` NOT REGEXP 'regexpHideDb' ",
            $method->invoke($node, 'SCHEMA_NAME')
        );
        unset($GLOBALS['cfg']['Server']['hide_db']);

        // When only_db directive is present and it's a single db
        $GLOBALS['cfg']['Server']['only_db'] = 'stringOnlyDb';
        $this->assertEquals(
            "WHERE TRUE AND ( `SCHEMA_NAME` LIKE 'stringOnlyDb' ) ",
            $method->invoke($node, 'SCHEMA_NAME')
        );
        unset($GLOBALS['cfg']['Server']['only_db']);

        // When only_db directive is present and it's an array of dbs
        $GLOBALS['cfg']['Server']['only_db'] = array('onlyDbOne', 'onlyDbTwo');
        $this->assertEquals(
            "WHERE TRUE AND ( `SCHEMA_NAME` LIKE 'onlyDbOne' "
            . "OR `SCHEMA_NAME` LIKE 'onlyDbTwo' ) ",
            $method->invoke($node, 'SCHEMA_NAME')
        );
        unset($GLOBALS['cfg']['Server']['only_db']);
    }

    /**
     * Tests getData() method when DisableIS is false and navigation tree
     * grouping enabled.
     *
     * @return void
     * @test
     */
    public function testGetDataWithEnabledISAndGroupingEnabled()
    {
        $pos = 10;
        $limit = 20;
        $GLOBALS['cfg']['Server']['DisableIS'] = false;
        $GLOBALS['cfg']['NavigationTreeEnableGrouping'] = true;
        $GLOBALS['cfg']['FirstLevelNavigationItems'] = $limit;
        $GLOBALS['cfg']['NavigationTreeDbSeparator'] = '_';

        $expectedSql  = "SELECT `SCHEMA_NAME` ";
        $expectedSql .= "FROM `INFORMATION_SCHEMA`.`SCHEMATA`, ";
        $expectedSql .= "(";
        $expectedSql .= "SELECT DB_first_level ";
        $expectedSql .= "FROM ( ";
        $expectedSql .= "SELECT DISTINCT SUBSTRING_INDEX(SCHEMA_NAME, ";
        $expectedSql .= "'_', 1) ";
        $expectedSql .= "DB_first_level ";
        $expectedSql .= "FROM INFORMATION_SCHEMA.SCHEMATA ";
        $expectedSql .= "WHERE TRUE ";
        $expectedSql .= ") t ";
        $expectedSql .= "ORDER BY DB_first_level ASC ";
        $expectedSql .= "LIMIT $pos, $limit";
        $expectedSql .= ") t2 ";
        $expectedSql .= "WHERE TRUE AND 1 = LOCATE(CONCAT(DB_first_level, '_'), ";
        $expectedSql .= "CONCAT(SCHEMA_NAME, '_')) ";
        $expectedSql .= "ORDER BY SCHEMA_NAME ASC";

        // It would have been better to mock _getWhereClause method
        // but strangely, mocking private methods is not supported in PHPUnit
        $node = NodeFactory::getInstance();

        $dbi = $this->getMockBuilder('PMA\libraries\DatabaseInterface')
            ->disableOriginalConstructor()
            ->getMock();
        $dbi->expects($this->once())
            ->method('fetchResult')
            ->with($expectedSql);
        $dbi->expects($this->any())->method('escapeString')
            ->will($this->returnArgument(0));
        $GLOBALS['dbi'] = $dbi;
        $node->getData('', $pos);
    }

    /**
     * Tests getData() method when DisableIS is false and navigation tree
     * grouping disabled.
     *
     * @return void
     * @test
     */
    public function testGetDataWithEnabledISAndGroupingDisabled()
    {
        $pos = 10;
        $limit = 20;
        $GLOBALS['cfg']['Server']['DisableIS'] = false;
        $GLOBALS['cfg']['NavigationTreeEnableGrouping'] = false;
        $GLOBALS['cfg']['FirstLevelNavigationItems'] = $limit;

        $expectedSql  = "SELECT `SCHEMA_NAME` ";
        $expectedSql .= "FROM `INFORMATION_SCHEMA`.`SCHEMATA` ";
        $expectedSql .= "WHERE TRUE ";
        $expectedSql .= "ORDER BY `SCHEMA_NAME` ";
        $expectedSql .= "LIMIT $pos, $limit";

        // It would have been better to mock _getWhereClause method
        // but strangely, mocking private methods is not supported in PHPUnit
        $node = NodeFactory::getInstance();

        $dbi = $this->getMockBuilder('PMA\libraries\DatabaseInterface')
            ->disableOriginalConstructor()
            ->getMock();
        $dbi->expects($this->once())
            ->method('fetchResult')
            ->with($expectedSql);
        $dbi->expects($this->any())->method('escapeString')
            ->will($this->returnArgument(0));

        $GLOBALS['dbi'] = $dbi;
        $node->getData('', $pos);
    }

    /**
     * Tests getData() method when DisableIS is true and navigation tree
     * grouping enabled.
     *
     * @return void
     * @test
     */
    public function testGetDataWithDisabledISAndGroupingEnabled()
    {
        $pos = 0;
        $limit = 10;
        $GLOBALS['cfg']['Server']['DisableIS'] = true;
        $GLOBALS['dbs_to_test'] = false;
        $GLOBALS['cfg']['NavigationTreeEnableGrouping'] = true;
        $GLOBALS['cfg']['FirstLevelNavigationItems'] = $limit;
        $GLOBALS['cfg']['NavigationTreeDbSeparator'] = '_';

        $node = NodeFactory::getInstance();

        $dbi = $this->getMockBuilder('PMA\libraries\DatabaseInterface')
            ->disableOriginalConstructor()
            ->getMock();
        $dbi->expects($this->once())
            ->method('tryQuery')
            ->with("SHOW DATABASES WHERE TRUE AND `Database` LIKE '%db%' ")
            ->will($this->returnValue(true));
        $dbi->expects($this->exactly(3))
            ->method('fetchArray')
            ->willReturnOnConsecutiveCalls(
                array(
                    '0' => 'db'
                ),
                array(
                    '0' => 'aa_db'
                ),
                false
            );

        $dbi->expects($this->once())
            ->method('fetchResult')
            ->with(
                "SHOW DATABASES WHERE TRUE AND `Database` LIKE '%db%' AND ("
                . " LOCATE('db_', CONCAT(`Database`, '_')) = 1"
                . " OR LOCATE('aa_', CONCAT(`Database`, '_')) = 1 )"
            );
        $dbi->expects($this->any())->method('escapeString')
            ->will($this->returnArgument(0));

        $GLOBALS['dbi'] = $dbi;
        $node->getData('', $pos, 'db');
    }

    /**
     * Tests the getPresence method when DisableIS is false and navigation tree
     * grouping enabled.
     *
     * @return void
     * @test
     */
    public function testGetPresenceWithEnabledISAndGroupingEnabled()
    {
        $GLOBALS['cfg']['Server']['DisableIS'] = false;
        $GLOBALS['cfg']['NavigationTreeEnableGrouping'] = true;
        $GLOBALS['cfg']['NavigationTreeDbSeparator'] = '_';

        $query = "SELECT COUNT(*) ";
        $query .= "FROM ( ";
        $query .= "SELECT DISTINCT SUBSTRING_INDEX(SCHEMA_NAME, '_', 1) ";
        $query .= "DB_first_level ";
        $query .= "FROM INFORMATION_SCHEMA.SCHEMATA ";
        $query .= "WHERE TRUE ";
        $query .= ") t ";

        // It would have been better to mock _getWhereClause method
        // but strangely, mocking private methods is not supported in PHPUnit
        $node = NodeFactory::getInstance();

        $dbi = $this->getMockBuilder('PMA\libraries\DatabaseInterface')
            ->disableOriginalConstructor()
            ->getMock();
        $dbi->expects($this->once())
            ->method('fetchValue')
            ->with($query);
        $GLOBALS['dbi'] = $dbi;
        $node->getPresence();
    }

    /**
     * Tests the getPresence method when DisableIS is false and navigation tree
     * grouping disabled.
     *
     * @return void
     * @test
     */
    public function testGetPresenceWithEnabledISAndGroupingDisabled()
    {
        $GLOBALS['cfg']['Server']['DisableIS'] = false;
        $GLOBALS['cfg']['NavigationTreeEnableGrouping'] = false;

        $query = "SELECT COUNT(*) ";
        $query .= "FROM INFORMATION_SCHEMA.SCHEMATA ";
        $query .= "WHERE TRUE ";

        $node = NodeFactory::getInstance();
        $dbi = $this->getMockBuilder('PMA\libraries\DatabaseInterface')
            ->disableOriginalConstructor()
            ->getMock();
        $dbi->expects($this->once())
            ->method('fetchValue')
            ->with($query);
        $GLOBALS['dbi'] = $dbi;
        $node->getPresence();
    }

    /**
     * Tests the getPresence method when DisableIS is true
     *
     * @return void
     * @test
     */
    public function testGetPresenceWithDisabledIS()
    {
        $GLOBALS['cfg']['Server']['DisableIS'] = true;
        $GLOBALS['dbs_to_test'] = false;
        $GLOBALS['cfg']['NavigationTreeEnableGrouping'] = true;

        $node = NodeFactory::getInstance();

        // test with no search clause
        $dbi = $this->getMockBuilder('PMA\libraries\DatabaseInterface')
            ->disableOriginalConstructor()
            ->getMock();
        $dbi->expects($this->once())
            ->method('tryQuery')
            ->with("SHOW DATABASES WHERE TRUE ");
        $dbi->expects($this->any())->method('escapeString')
            ->will($this->returnArgument(0));

        $GLOBALS['dbi'] = $dbi;
        $node->getPresence();

        // test with a search clause
        $dbi = $this->getMockBuilder('PMA\libraries\DatabaseInterface')
            ->disableOriginalConstructor()
            ->getMock();
        $dbi->expects($this->once())
            ->method('tryQuery')
            ->with("SHOW DATABASES WHERE TRUE AND `Database` LIKE '%dbname%' ");
        $dbi->expects($this->any())->method('escapeString')
            ->will($this->returnArgument(0));

        $GLOBALS['dbi'] = $dbi;
        $node->getPresence('', 'dbname');
    }
}
