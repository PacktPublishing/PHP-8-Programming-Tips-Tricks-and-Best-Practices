<?php
namespace Services;
use ArrayIterator;
/**
 * This class is used with the following:
 */
class SortTest
{
    public $id;
    public $name;
    public static $names = ['Fred', 'Barney', 'Wilma', 'Betty'];
    public static $max = 20;
    /**
     * Displays array
     *
     * @param array $arr
     * @return string $out
     */
    public static function show(array $arr)
    {
        $out  = "\n";
        $cols = 4;
        $iter = new ArrayIterator($arr);
        $patt = '%03s | %6s | %03d ' . PHP_EOL;
        $out .= sprintf('%3s | %6s | %3s ', 'Key', 'Name', 'ID') . PHP_EOL;
        $out .= sprintf('%3s | %6s | %3s ', '---', '------', '---') . PHP_EOL;
        while ($iter->valid()) {
            for ($x = 0; $x < $cols; $x++) {
                $key = $iter->key();
                $obj = $iter->current();
                $out .= sprintf($patt, $key, $obj->name, $obj->id);
                $iter->next();
                if (!$iter->valid()) break;
            }
        }
        return $out . "\n";
    }
    /**
     * Builds consistent array of Test instances
     *
     * @return array $arr
     */
    public static function build()
    {
        $arr = [];
        $maxNames = count(self::$names);
        $pos = 0;
        for ($x = 0; $x < self::$max; $x++) {
            // note that the ID value == the order assigned
            $key  = strtoupper(dechex($x));
            $id   = sprintf('%04d', $x + 1000);
            if ($pos >= $maxNames) $pos = 0;
            $name = self::$names[$pos++];
            $test = new self();
            $test->id = $id;
            $test->name = $name;
            $arr[$key] = $test;
        }
        return $arr;
    }
}


