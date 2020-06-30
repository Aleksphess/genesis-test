#!/bin/bash
set -e

docker exec -it web sh -c "php tests/codeception/bin/yii migrate --interactive=0"

docker exec -it web sh -c "php tests/codeception/bin/yii migrate --interactive=0 --migrationPath=@base/console/migrations"

docker exec -it web sh -c "cd tests/codeception/api && ../../../vendor/bin/codecept run functional -vvv"
