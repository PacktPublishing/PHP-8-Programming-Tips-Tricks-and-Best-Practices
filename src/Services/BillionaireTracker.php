<?php
namespace Services;
use SplFileObject;
use ArrayIterator;
class BillionaireTracker
{
    // this describes lines within the file
    public $skip   = 1;  // lines to skip (e.g. skip headers)
    public $key_field = 'net_worth';
    public $val_field = 'name';
    public $fields =[
        'rank'        => 'cb_int',
        'name'        => 'cb_name',
        'net_worth'   => 'cb_float',
        'last_change' => 'cb_float',
        'ytd_change'  => 'cb_float',
        'country'     => 'cb_str',
        'industry'    => 'cb_str',
    ];
    // callbacks
    public function cb_int($val) { return (int) $val; }
    public function cb_str($val) { return trim($val); }
    public function cb_float($val) { return ((float) str_replace(['$','B'], '', $val)) * 1000000000; }
    public function cb_name($val) {
        $val = trim($val);
        $tmp = explode(' ', $val);
        $last = array_pop($tmp);
        return $last . ',' . implode(' ', $tmp);
    }
    /**
     * Returns a list of key/value pairs
     * @param string $fn : source filename
     * @return array : [[key => value],[key => value], etc.]
     */
    public function extract(string $fn)
    {
        $obj = new SplFileObject($fn, 'r');
        $final = [];
        // skip lines
        $skip  = $this->skip ?? 0;
        while (!$obj->eof() && $skip) {
            $line = $obj->fgets();
            $skip--;
        }
        // scan source code file
        while (!$obj->eof()) {
            // read $this->fields number of lines
            // each line contains a different data element
            $temp = [];
            $key  = '';
            $val  = NULL;
            foreach ($this->fields as $element => $callback) {
                if (!$obj->eof()) {
                    $item = $obj->fgets();
                    if ($element === $this->key_field) {
                        $key = $this->$callback($item);
                    } elseif ($element === $this->val_field) {
                        $val = $this->$callback($item);
                    }
                }
            }
            if ($key) $final[] = [$key => $val];
        }
        return $final;
    }
    /**
     * Produces output from the heap
     * @param SplHeap $heap  : source data
     * @param string $pat    : sprintf() pattern
     * @param string $line   : "-----" line separator
     * @param string $output : formatted output
     */
    public function view($heap, string $patt, string $line)
    {
        // move up to the first node
        $total = 0;
        $heap->top();
        // produce output
        $output = '';
        $output .= $line;
        $output .= sprintf($patt, 'Net Worth', 'Name');
        $output .= $line;
        while ($heap->valid()) {
            $iter = new ArrayIterator($heap->current());
            $output .= sprintf($patt, number_format($iter->key()), $iter->current());
            $total += (int) $iter->key();
            $heap->next();
        }
        $output .= $line;
        $output .= sprintf($patt, '', number_format($total));
        $output .= $line;
        return $output;
    }
}
