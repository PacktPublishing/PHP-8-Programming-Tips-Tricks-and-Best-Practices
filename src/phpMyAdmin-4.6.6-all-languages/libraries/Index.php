<?php
/* vim: set expandtab sw=4 ts=4 sts=4: */
/**
 * holds the database index class
 *
 * @package PhpMyAdmin
 */
namespace PMA\libraries;

/**
 * Index manipulation class
 *
 * @package PhpMyAdmin
 * @since   phpMyAdmin 3.0.0
 */
class Index
{
    const PRIMARY  = 1;
    const UNIQUE   = 2;
    const INDEX    = 4;
    const SPATIAL  = 8;
    const FULLTEXT = 16;

    /**
     * Class-wide storage container for indexes (caching, singleton)
     *
     * @var array
     */
    private static $_registry = array();

    /**
     * @var string The name of the schema
     */
    private $_schema = '';

    /**
     * @var string The name of the table
     */
    private $_table = '';

    /**
     * @var string The name of the index
     */
    private $_name = '';

    /**
     * Columns in index
     *
     * @var array
     */
    private $_columns = array();

    /**
     * The index method used (BTREE, HASH, RTREE).
     *
     * @var string
     */
    private $_type = '';

    /**
     * The index choice (PRIMARY, UNIQUE, INDEX, SPATIAL, FULLTEXT)
     *
     * @var string
     */
    private $_choice = '';

    /**
     * Various remarks.
     *
     * @var string
     */
    private $_remarks = '';

    /**
     * Any comment provided for the index with a COMMENT attribute when the
     * index was created.
     *
     * @var string
     */
    private $_comment = '';

    /**
     * @var integer 0 if the index cannot contain duplicates, 1 if it can.
     */
    private $_non_unique = 0;

    /**
     * Indicates how the key is packed. NULL if it is not.
     *
     * @var string
     */
    private $_packed = null;

    /**
     * Block size for the index
     *
     * @var int
     */
    private $_key_block_size = null;

    /**
     * Parser option for the index
     *
     * @var string
     */
    private $_parser = null;

    /**
     * Constructor
     *
     * @param array $params parameters
     */
    public function __construct($params = array())
    {
        $this->set($params);
    }

    /**
     * Creates(if not already created) and returns the corresponding Index object
     *
     * @param string $schema     database name
     * @param string $table      table name
     * @param string $index_name index name
     *
     * @return Index corresponding Index object
     */
    static public function singleton($schema, $table, $index_name = '')
    {
        Index::_loadIndexes($table, $schema);
        if (! isset(Index::$_registry[$schema][$table][$index_name])) {
            $index = new Index;
            if (mb_strlen($index_name)) {
                $index->setName($index_name);
                Index::$_registry[$schema][$table][$index->getName()] = $index;
            }
            return $index;
        } else {
            return Index::$_registry[$schema][$table][$index_name];
        }
    }

    /**
     * returns an array with all indexes from the given table
     *
     * @param string $table  table
     * @param string $schema schema
     *
     * @return Index[]  array of indexes
     */
    static public function getFromTable($table, $schema)
    {
        Index::_loadIndexes($table, $schema);

        if (isset(Index::$_registry[$schema][$table])) {
            return Index::$_registry[$schema][$table];
        } else {
            return array();
        }
    }

    /**
     * Returns an array with all indexes from the given table of the requested types
     *
     * @param string $table   table
     * @param string $schema  schema
     * @param int    $choices choices
     *
     * @return Index[] array of indexes
     */
    static public function getFromTableByChoice($table, $schema, $choices = 31)
    {
        $indexes = array();
        foreach (self::getFromTable($table, $schema) as $index) {
            if (($choices & Index::PRIMARY)
                && $index->getChoice() == 'PRIMARY'
            ) {
                $indexes[] = $index;
            }
            if (($choices & Index::UNIQUE)
                && $index->getChoice() == 'UNIQUE'
            ) {
                $indexes[] = $index;
            }
            if (($choices & Index::INDEX)
                && $index->getChoice() == 'INDEX'
            ) {
                $indexes[] = $index;
            }
            if (($choices & Index::SPATIAL)
                && $index->getChoice() == 'SPATIAL'
            ) {
                $indexes[] = $index;
            }
            if (($choices & Index::FULLTEXT)
                && $index->getChoice() == 'FULLTEXT'
            ) {
                $indexes[] = $index;
            }
        }
        return $indexes;
    }

    /**
     * return primary if set, false otherwise
     *
     * @param string $table  table
     * @param string $schema schema
     *
     * @return mixed primary index or false if no one exists
     */
    static public function getPrimary($table, $schema)
    {
        Index::_loadIndexes($table, $schema);

        if (isset(Index::$_registry[$schema][$table]['PRIMARY'])) {
            return Index::$_registry[$schema][$table]['PRIMARY'];
        } else {
            return false;
        }
    }

    /**
     * Load index data for table
     *
     * @param string $table  table
     * @param string $schema schema
     *
     * @return boolean whether loading was successful
     */
    static private function _loadIndexes($table, $schema)
    {
        if (isset(Index::$_registry[$schema][$table])) {
            return true;
        }

        $_raw_indexes = $GLOBALS['dbi']->getTableIndexes($schema, $table);
        foreach ($_raw_indexes as $_each_index) {
            $_each_index['Schema'] = $schema;
            $keyName = $_each_index['Key_name'];
            if (! isset(Index::$_registry[$schema][$table][$keyName])) {
                $key = new Index($_each_index);
                Index::$_registry[$schema][$table][$keyName] = $key;
            } else {
                $key = Index::$_registry[$schema][$table][$keyName];
            }

            $key->addColumn($_each_index);
        }

        return true;
    }

    /**
     * Add column to index
     *
     * @param array $params column params
     *
     * @return void
     */
    public function addColumn($params)
    {
        if (isset($params['Column_name'])
            && mb_strlen($params['Column_name'])
        ) {
            $this->_columns[$params['Column_name']] = new IndexColumn($params);
        }
    }

    /**
     * Adds a list of columns to the index
     *
     * @param array $columns array containing details about the columns
     *
     * @return void
     */
    public function addColumns($columns)
    {
        $_columns = array();

        if (isset($columns['names'])) {
            // coming from form
            // $columns[names][]
            // $columns[sub_parts][]
            foreach ($columns['names'] as $key => $name) {
                $sub_part = isset($columns['sub_parts'][$key])
                    ? $columns['sub_parts'][$key] : '';
                $_columns[] = array(
                    'Column_name'   => $name,
                    'Sub_part'      => $sub_part,
                );
            }
        } else {
            // coming from SHOW INDEXES
            // $columns[][name]
            // $columns[][sub_part]
            // ...
            $_columns = $columns;
        }

        foreach ($_columns as $column) {
            $this->addColumn($column);
        }
    }

    /**
     * Returns true if $column indexed in this index
     *
     * @param string $column the column
     *
     * @return boolean  true if $column indexed in this index
     */
    public function hasColumn($column)
    {
        return isset($this->_columns[$column]);
    }

    /**
     * Sets index details
     *
     * @param array $params index details
     *
     * @return void
     */
    public function set($params)
    {
        if (isset($params['columns'])) {
            $this->addColumns($params['columns']);
        }
        if (isset($params['Schema'])) {
            $this->_schema = $params['Schema'];
        }
        if (isset($params['Table'])) {
            $this->_table = $params['Table'];
        }
        if (isset($params['Key_name'])) {
            $this->_name = $params['Key_name'];
        }
        if (isset($params['Index_type'])) {
            $this->_type = $params['Index_type'];
        }
        if (isset($params['Comment'])) {
            $this->_remarks = $params['Comment'];
        }
        if (isset($params['Index_comment'])) {
            $this->_comment = $params['Index_comment'];
        }
        if (isset($params['Non_unique'])) {
            $this->_non_unique = $params['Non_unique'];
        }
        if (isset($params['Packed'])) {
            $this->_packed = $params['Packed'];
        }
        if (isset($params['Index_choice'])) {
            $this->_choice = $params['Index_choice'];
        } else {
            if ('PRIMARY' == $this->_name) {
                $this->_choice = 'PRIMARY';
            } elseif ('FULLTEXT' == $this->_type) {
                $this->_choice = 'FULLTEXT';
                $this->_type = '';
            } elseif ('SPATIAL' == $this->_type) {
                $this->_choice = 'SPATIAL';
                $this->_type = '';
            } elseif ('0' == $this->_non_unique) {
                $this->_choice = 'UNIQUE';
            } else {
                $this->_choice = 'INDEX';
            }
        }
        if (isset($params['Key_block_size'])) {
            $this->_key_block_size = $params['Key_block_size'];
        }
        if (isset($params['Parser'])) {
            $this->_parser = $params['Parser'];
        }
    }

    /**
     * Returns the number of columns of the index
     *
     * @return integer the number of the columns
     */
    public function getColumnCount()
    {
        return count($this->_columns);
    }

    /**
     * Returns the index comment
     *
     * @return string index comment
     */
    public function getComment()
    {
        return $this->_comment;
    }

    /**
     * Returns index remarks
     *
     * @return string index remarks
     */
    public function getRemarks()
    {
        return $this->_remarks;
    }

    /**
     * Return the key block size
     *
     * @return number
     */
    public function getKeyBlockSize()
    {
        return $this->_key_block_size;
    }

    /**
     * Return the parser
     *
     * @return string
     */
    public function getParser()
    {
        return $this->_parser;
    }

    /**
     * Returns concatenated remarks and comment
     *
     * @return string concatenated remarks and comment
     */
    public function getComments()
    {
        $comments = $this->getRemarks();
        if (mb_strlen($comments)) {
            $comments .= "\n";
        }
        $comments .= $this->getComment();

        return $comments;
    }

    /**
     * Returns index type (BTREE, HASH, RTREE)
     *
     * @return string index type
     */
    public function getType()
    {
        return $this->_type;
    }

    /**
     * Returns index choice (PRIMARY, UNIQUE, INDEX, SPATIAL, FULLTEXT)
     *
     * @return string index choice
     */
    public function getChoice()
    {
        return $this->_choice;
    }

    /**
     * Return a list of all index choices
     *
     * @return string[] index choices
     */
    static public function getIndexChoices()
    {
        return array(
            'PRIMARY',
            'INDEX',
            'UNIQUE',
            'SPATIAL',
            'FULLTEXT',
        );
    }

    /**
     * Returns a lit of all index types
     *
     * @return string[] index types
     */
    static public function getIndexTypes()
    {
        return array(
            'BTREE',
            'HASH'
        );
    }

    /**
     * Returns HTML for the index choice selector
     *
     * @param boolean $edit_table whether this is table editing
     *
     * @return string HTML for the index choice selector
     */
    public function generateIndexChoiceSelector($edit_table)
    {
        $html_options = '<select name="index[Index_choice]"'
            . ' id="select_index_choice" '
            . ($edit_table ? 'disabled="disabled"' : '') . '>';

        foreach (Index::getIndexChoices() as $each_index_choice) {
            if ($each_index_choice === 'PRIMARY'
                && $this->_choice !== 'PRIMARY'
                && Index::getPrimary($this->_table, $this->_schema)
            ) {
                // skip PRIMARY if there is already one in the table
                continue;
            }
            $html_options .= '<option value="' . $each_index_choice . '"'
                 . (($this->_choice == $each_index_choice)
                 ? ' selected="selected"'
                 : '')
                 . '>' . $each_index_choice . '</option>' . "\n";
        }
        $html_options .= '</select>';

        return $html_options;
    }

    /**
     * Returns HTML for the index type selector
     *
     * @return string HTML for the index type selector
     */
    public function generateIndexTypeSelector()
    {
        $types = array("" => "--");
        foreach (Index::getIndexTypes() as $type) {
            $types[$type] = $type;
        }

        return Util::getDropdown(
            "index[Index_type]", $types,
            $this->_type, "select_index_type"
        );
    }

    /**
     * Returns how the index is packed
     *
     * @return string how the index is packed
     */
    public function getPacked()
    {
        return $this->_packed;
    }

    /**
     * Returns 'No'/false if the index is not packed,
     * how the index is packed if packed
     *
     * @param boolean $as_text whether to output should be in text
     *
     * @return mixed how index is packed
     */
    public function isPacked($as_text = false)
    {
        if ($as_text) {
            $r = array(
                '0' => __('No'),
                '1' => __('Yes'),
            );
        } else {
            $r = array(
                '0' => false,
                '1' => true,
            );
        }

        if (null === $this->_packed) {
            return $r[0];
        }

        return $this->_packed;
    }

    /**
     * Returns integer 0 if the index cannot contain duplicates, 1 if it can
     *
     * @return integer 0 if the index cannot contain duplicates, 1 if it can
     */
    public function getNonUnique()
    {
        return $this->_non_unique;
    }

    /**
     * Returns whether the index is a 'Unique' index
     *
     * @param boolean $as_text whether to output should be in text
     *
     * @return mixed whether the index is a 'Unique' index
     */
    public function isUnique($as_text = false)
    {
        if ($as_text) {
            $r = array(
                '0' => __('Yes'),
                '1' => __('No'),
            );
        } else {
            $r = array(
                '0' => true,
                '1' => false,
            );
        }

        return $r[$this->_non_unique];
    }

    /**
     * Returns the name of the index
     *
     * @return string the name of the index
     */
    public function getName()
    {
        return $this->_name;
    }

    /**
     * Sets the name of the index
     *
     * @param string $name index name
     *
     * @return void
     */
    public function setName($name)
    {
        $this->_name = (string) $name;
    }

    /**
     * Returns the columns of the index
     *
     * @return IndexColumn[] the columns of the index
     */
    public function getColumns()
    {
        return $this->_columns;
    }

    /**
     * Show index data
     *
     * @param string  $table      The table name
     * @param string  $schema     The schema name
     * @param boolean $print_mode Whether the output is for the print mode
     *
     * @return string HTML for showing index
     *
     * @access  public
     */
    static public function getHtmlForIndexes($table, $schema, $print_mode = false)
    {
        $indexes = Index::getFromTable($table, $schema);

        $no_indexes_class = count($indexes) > 0 ? ' hide' : '';
        $no_indexes  = "<div class='no_indexes_defined$no_indexes_class'>";
        $no_indexes .= Message::notice(__('No index defined!'))->getDisplay();
        $no_indexes .= '</div>';

        if (! $print_mode) {
            $r  = '<fieldset class="index_info">';
            $r .= '<legend id="index_header">' . __('Indexes');
            $r .= Util::showMySQLDocu('optimizing-database-structure');

            $r .= '</legend>';
            $r .= $no_indexes;
            if (count($indexes) < 1) {
                $r .= '</fieldset>';
                return $r;
            }
            $r .= Index::findDuplicates($table, $schema);
        } else {
            $r  = '<h3>' . __('Indexes') . '</h3>';
            $r .= $no_indexes;
            if (count($indexes) < 1) {
                return $r;
            }
        }
        $r .= '<table id="table_index">';
        $r .= '<thead>';
        $r .= '<tr>';
        if (! $print_mode) {
            $r .= '<th colspan="2" class="print_ignore">' . __('Action') . '</th>';
        }
        $r .= '<th>' . __('Keyname') . '</th>';
        $r .= '<th>' . __('Type') . '</th>';
        $r .= '<th>' . __('Unique') . '</th>';
        $r .= '<th>' . __('Packed') . '</th>';
        $r .= '<th>' . __('Column') . '</th>';
        $r .= '<th>' . __('Cardinality') . '</th>';
        $r .= '<th>' . __('Collation') . '</th>';
        $r .= '<th>' . __('Null') . '</th>';
        $r .= '<th>' . __('Comment') . '</th>';
        $r .= '</tr>';
        $r .= '</thead>';
        $r .= '<tbody>';

        $odd_row = true;
        foreach ($indexes as $index) {
            $row_span = ' rowspan="' . $index->getColumnCount() . '" ';

            $r .= '<tr class="noclick ' . ($odd_row ? 'odd' : 'even') . '">';

            if (! $print_mode) {
                $this_params = $GLOBALS['url_params'];
                $this_params['index'] = $index->getName();
                $r .= '<td class="edit_index print_ignore';
                $r .= ' ajax';
                $r .= '" ' . $row_span . '>'
                   . '    <a class="';
                $r .= 'ajax';
                $r .= '" href="tbl_indexes.php' . PMA_URL_getCommon($this_params)
                   . '">' . Util::getIcon('b_edit.png', __('Edit')) . '</a>'
                   . '</td>' . "\n";
                $this_params = $GLOBALS['url_params'];
                if ($index->getName() == 'PRIMARY') {
                    $this_params['sql_query'] = 'ALTER TABLE '
                        . Util::backquote($table)
                        . ' DROP PRIMARY KEY;';
                    $this_params['message_to_show']
                        = __('The primary key has been dropped.');
                    $js_msg = PMA_jsFormat($this_params['sql_query']);
                } else {
                    $this_params['sql_query'] = 'ALTER TABLE '
                        . Util::backquote($table) . ' DROP INDEX '
                        . Util::backquote($index->getName()) . ';';
                    $this_params['message_to_show'] = sprintf(
                        __('Index %s has been dropped.'), htmlspecialchars($index->getName())
                    );
                    $js_msg = PMA_jsFormat($this_params['sql_query']);
                }

                $r .= '<td ' . $row_span . ' class="print_ignore">';
                $r .= '<input type="hidden" class="drop_primary_key_index_msg"'
                    . ' value="' . $js_msg . '" />';
                $r .= '    <a class="drop_primary_key_index_anchor';
                $r .= ' ajax';
                $r .= '" href="sql.php' . PMA_URL_getCommon($this_params)
                   . '" >'
                   . Util::getIcon('b_drop.png', __('Drop'))  . '</a>'
                   . '</td>' . "\n";
            }

            if (! $print_mode) {
                $r .= '<th ' . $row_span . '>'
                    . htmlspecialchars($index->getName())
                    . '</th>';
            } else {
                $r .= '<td ' . $row_span . '>'
                    . htmlspecialchars($index->getName())
                    . '</td>';
            }
            $r .= '<td ' . $row_span . '>';
            $type = $index->getType();
            if (! empty($type)) {
                $r .= htmlspecialchars($type);
            } else {
                $r .= htmlspecialchars($index->getChoice());
            }
            $r .= '</td>';
            $r .= '<td ' . $row_span . '>' . $index->isUnique(true) . '</td>';
            $r .= '<td ' . $row_span . '>' . $index->isPacked(true) . '</td>';

            foreach ($index->getColumns() as $column) {
                if ($column->getSeqInIndex() > 1) {
                    $r .= '<tr class="noclick ' . ($odd_row ? 'odd' : 'even') . '">';
                }
                $r .= '<td>' . htmlspecialchars($column->getName());
                if ($column->getSubPart()) {
                    $r .= ' (' . htmlspecialchars($column->getSubPart()) . ')';
                }
                $r .= '</td>';
                $r .= '<td>'
                    . htmlspecialchars($column->getCardinality())
                    . '</td>';
                $r .= '<td>'
                    . htmlspecialchars($column->getCollation())
                    . '</td>';
                $r .= '<td>'
                    . htmlspecialchars($column->getNull(true))
                    . '</td>';

                if ($column->getSeqInIndex() == 1
                ) {
                    $r .= '<td ' . $row_span . '>'
                        . htmlspecialchars($index->getComments()) . '</td>';
                }
                $r .= '</tr>';
            } // end foreach $index['Sequences']

            $odd_row = ! $odd_row;
        } // end while
        $r .= '</tbody>';
        $r .= '</table>';
        if (! $print_mode) {
            $r .= '</fieldset>';
        }

        return $r;
    }

    /**
     * Gets the properties in an array for comparison purposes
     *
     * @return array an array containing the properties of the index
     */
    public function getCompareData()
    {
        $data = array(
            // 'Non_unique'    => $this->_non_unique,
            'Packed'        => $this->_packed,
            'Index_choice'    => $this->_choice,
        );

        foreach ($this->_columns as $column) {
            $data['columns'][] = $column->getCompareData();
        }

        return $data;
    }

    /**
     * Function to check over array of indexes and look for common problems
     *
     * @param string $table  table name
     * @param string $schema schema name
     *
     * @return string  Output HTML
     * @access  public
     */
    static public function findDuplicates($table, $schema)
    {
        $indexes = Index::getFromTable($table, $schema);

        $output  = '';

        // count($indexes) < 2:
        //   there is no need to check if there less than two indexes
        if (count($indexes) < 2) {
            return $output;
        }

        // remove last index from stack and ...
        while ($while_index = array_pop($indexes)) {
            // ... compare with every remaining index in stack
            foreach ($indexes as $each_index) {
                if ($each_index->getCompareData() !== $while_index->getCompareData()
                ) {
                    continue;
                }

                // did not find any difference
                // so it makes no sense to have this two equal indexes

                $message = Message::notice(
                    __(
                        'The indexes %1$s and %2$s seem to be equal and one of them '
                        . 'could possibly be removed.'
                    )
                );
                $message->addParam($each_index->getName());
                $message->addParam($while_index->getName());
                $output .= $message->getDisplay();

                // there is no need to check any further indexes if we have already
                // found that this one has a duplicate
                continue 2;
            }
        }
        return $output;
    }
}
