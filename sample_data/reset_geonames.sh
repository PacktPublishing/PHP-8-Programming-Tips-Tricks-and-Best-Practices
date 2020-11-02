#!/bin/bash
cd /repo/sample_data
wget https://download.geonames.org/export/dump/cities15000.zip
unzip cities15000.zip
rm cities15000.zip
php reset_geonames.php
