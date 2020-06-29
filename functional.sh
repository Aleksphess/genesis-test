#!/bin/bash
set -e
php tests/codeception/bin/yii migrate --interactive=0
php tests/codeception/bin/yii migrate --interactive=0 --migrationPath=@base/console/migrations
cd tests/codeception/api
../../../vendor/bin/codecept run functional -vvv