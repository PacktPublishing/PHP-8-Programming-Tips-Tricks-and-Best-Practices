#!/bin/bash
cd /repo/sample_data
wget https://download.geonames.org/export/dump/countryInfo.txt
php sqlite_geonames_country_info.php
