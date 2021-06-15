<?php
/* vim: set expandtab sw=4 ts=4 sts=4: */
/**
 * Functionality for the navigation tree
 *
 * @package PhpMyAdmin-Navigation
 */
namespace PMA\libraries\navigation\nodes;

use PMA;
use PMA\libraries\navigation\NodeFactory;

/**
 * Represents a container for events nodes in the navigation tree
 *
 * @package PhpMyAdmin-Navigation
 */
class NodeEventContainer extends NodeDatabaseChildContainer
{
    /**
     * Initialises the class
     */
    public function __construct()
    {
        parent::__construct(__('Events'), Node::CONTAINER);
        $this->icon = PMA\libraries\Util::getImage('b_events.png', '');
        $this->links = array(
            'text' => 'db_events.php?server=' . $GLOBALS['server']
                . '&amp;db=%1$s&amp;token=' . $_SESSION[' PMA_token '],
            'icon' => 'db_events.php?server=' . $GLOBALS['server']
                . '&amp;db=%1$s&amp;token=' . $_SESSION[' PMA_token '],
        );
        $this->real_name = 'events';

        $new = NodeFactory::getInstance(
            'Node',
            _pgettext('Create new event', 'New')
        );
        $new->isNew = true;
        $new->icon = PMA\libraries\Util::getImage('b_event_add.png', '');
        $new->links = array(
            'text' => 'db_events.php?server=' . $GLOBALS['server']
                . '&amp;db=%2$s&amp;token=' . $_SESSION[' PMA_token ']
                . '&add_item=1',
            'icon' => 'db_events.php?server=' . $GLOBALS['server']
                . '&amp;db=%2$s&amp;token=' . $_SESSION[' PMA_token ']
                . '&add_item=1',
        );
        $new->classes = 'new_event italics';
        $this->addChild($new);
    }
}

