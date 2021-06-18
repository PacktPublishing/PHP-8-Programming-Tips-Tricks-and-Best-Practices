<?php
// /repo/src/Services/SampleAccess.php
// produces sample access data
namespace Services;

use DateInterval;
use DateTime;
use ArrayIterator;
class SampleAccess
{
    const MAX_DAY_SPAN = 21;
    const MAX_ENTRIES  = 12;
    public static $names = ['Fred', 'Barney', 'Wilma', 'Betty', 'Bam Bam'];
    public static function getData(int $max = self::MAX_ENTRIES)
    {
        // define sample data
        $data = [];
        foreach (self::$names as $idx => $name) {
            $entries = rand(1, self::MAX_ENTRIES);
            $today = new DateTime('now');
            $data['name_' . $idx]['name'] = $name;
            for ($x = 0; $x < $entries; $x++)
                $data['name_' . $idx]['time_' . $x] = ['time' => self::randDate($today)];
        }
        return new ArrayIterator($data);
    }
    public static function randDate(DateTime $date) : string
    {
        $interval = new DateInterval('P' . rand(1,self::MAX_DAY_SPAN) . 'D');
        return $date->add($interval)->format('Y-m-d');
    }
    public static function randName()
    {
        return self::$names[array_rand(self::$names)];
    }
}
