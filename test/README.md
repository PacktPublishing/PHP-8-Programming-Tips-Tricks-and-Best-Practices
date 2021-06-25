# Unit Tests
If you want to run tests, proceed as follows:

## Inside the PHP 7 Docker Container
First install PHP Unit 5:
```
cd /repo/test/phpunit5
composer update
```
Then you can run tests:
```
vendor/bin/phpunit
```

## Inside the PHP 8 Docker Container
First install PHP Unit 9:
```
cd /repo/test/phpunit9
composer update
```
Then you can run tests:
```
vendor/bin/phpunit
```
