#!/bin/sh

# system infos
pwd;
php --version;

# get composer
# get sami if it does not exist.
[ -e composer.phar ] && echo "Composer found\r\n" || curl -sS https://getcomposer.org/installer | php;

php composer.phar update;

# create the build dir if doesn't exist
mkdir -p build;

# run ci tasks
php composer.phar phpunit;
php composer.phar phpcs-ci;
php composer.phar phpcpd-ci;
php composer.phar phpmd-ci;
