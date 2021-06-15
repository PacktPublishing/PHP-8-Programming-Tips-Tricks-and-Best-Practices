<?php
/* vim: set expandtab sw=4 ts=4 sts=4: */
/**
 ** Test for PMA\libraries\Util::getDropdown from Util.php
 *
 * @package PhpMyAdmin-test
 * @group common.lib-tests
 */

/*
 * Include to test.
 */


/**
 ** Test for PMA\libraries\Util::getDropdown from Util.php
 *
 * @package PhpMyAdmin-test
 * @group common.lib-tests
 */
class PMA_GetDropdownTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test for getDropdown
     *
     * @return void
     */
    function testGetDropdownEmpty()
    {
        $name = "test_dropdown_name";
        $choices = array();
        $active_choice = null;
        $id = "test_&lt;dropdown&gt;_name";

        $result = '<select name="' . htmlspecialchars($name) . '" id="'
            . htmlspecialchars($id) . '"></select>';

        $this->assertEquals(
            $result,
            PMA\libraries\Util::getDropdown(
                $name, $choices, $active_choice, $id
            )
        );
    }

    /**
     * Test for getDropdown
     *
     * @return void
     */
    function testGetDropdown()
    {
        $name = "&test_dropdown_name";
        $choices = array("value_1" => "label_1", "value&_2\"" => "label_2");
        $active_choice = null;
        $id = "test_&lt;dropdown&gt;_name";

        $result = '<select name="' . htmlspecialchars($name) . '" id="'
            . htmlspecialchars($id) . '">';
        foreach ($choices as $one_choice_value => $one_choice_label) {
            $result .= '<option value="' . htmlspecialchars($one_choice_value) . '"';
            if ($one_choice_value == $active_choice) {
                $result .= ' selected="selected"';
            }
            $result .= '>' . htmlspecialchars($one_choice_label) . '</option>';
        }
        $result .= '</select>';

        $this->assertEquals(
            $result,
            PMA\libraries\Util::getDropdown(
                $name, $choices, $active_choice, $id
            )
        );
    }

    /**
     * Test for getDropdown
     *
     * @return void
     */
    function testGetDropdownWithActive()
    {
        $name = "&test_dropdown_name";
        $choices = array("value_1" => "label_1", "value&_2\"" => "label_2");
        $active_choice = "value&_2\"";
        $id = "test_&lt;dropdown&gt;_name";

        $result = '<select name="' . htmlspecialchars($name) . '" id="'
            . htmlspecialchars($id) . '">';
        foreach ($choices as $one_choice_value => $one_choice_label) {
            $result .= '<option value="' . htmlspecialchars($one_choice_value) . '"';
            if ($one_choice_value == $active_choice) {
                $result .= ' selected="selected"';
            }
            $result .= '>' . htmlspecialchars($one_choice_label) . '</option>';
        }
        $result .= '</select>';

        $this->assertEquals(
            $result,
            PMA\libraries\Util::getDropdown(
                $name, $choices, $active_choice, $id
            )
        );
    }
}