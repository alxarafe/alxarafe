#!/bin/bash

# Run all common commands

./bin/run-phpcbf.sh
./bin/run-phpcs.sh
./bin/generate-documentation.sh
./bin/run-phpunit-phpdbg.sh