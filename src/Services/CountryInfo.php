<?php
// /repo/src/Services/CountryInfo.php
namespace Services;
// using this data: https://download.geonames.org/export/dump/countryInfo.txt
// Columns (tab separated):
// ISO  ISO3    ISO-Numeric fips    Country Capital Area(in sq km)  Population  Continent   tld CurrencyCode
// CurrencyName Phone   Postal Code Format  Postal Code Regex   Languages   geonameid   neighbours  EquivalentFipsCode

use SplFileObject;
use ArrayIterator;
class CountryInfo
{
    // source country info
    public $obj = NULL;
    public const SRC_FILE = __DIR__ . '/../../sample_data/countryInfo.txt';
    public $headers = [
        'ISO','ISO3','ISO-Numeric','fips','Country','Capital','Area',
        'Population','Continent','tld','CurrencyCode','CurrencyName',
        'Phone','PostalCode','Format','PostalCodeRegex','Languages',
        'geonameid','neighbours','EquivalentFipsCode'
    ];

    public function __construct()
    {
        $this->obj = new SplFileObject(self::SRC_FILE, 'r');
    }

    /**
     * Returns iterator with desired information
     *
     * @param string $key        : field name that will be the key
     * @param callable $accept() : callback that determines accepted information
     *                           : callback needs to take a row of data as argument
     * @return ArrayIterator $iterator
     */
    public function getIterator(string $key = 'ISO', callable $callback = NULL)
    {
        // place country info into ArrayIterator
        $iter = new ArrayIterator();
        while (!$this->obj->eof()) {
            $row = $this->obj->fgetcsv("\t");
            // filter out garbage rows
            $leading = $row[0][0] ?? FALSE;
            if (!$leading) continue;
            if ($leading === '#') continue;
            // combine row with headers
            $slice = array_slice($this->headers, 0,  count($row));
            $row   = array_combine($slice, $row);
            $idx   = $row[$key];
            // filter by callback
            if ($callback) {
                if ($callback($row))
                    $iter->offsetSet($idx, $row);
            } else {
                $iter->offsetSet($idx, $row);
            }
        }
        return $iter;
    }

}
