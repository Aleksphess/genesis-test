#!/bin/bash

docker exec -it web sh -c "cd tests/codeception/api && ../../../vendor/bin/codecept run unit $*  -d -vvv"
