#!/bin/bash

cd tests/codeception/api
../../../vendor/bin/codecept run unit $*  -d -vvv