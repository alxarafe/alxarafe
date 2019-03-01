#!/bin/bash

# Check PHP Code Sniffer rules based on phpcs.xml

vendor/bin/phpcs --tab-width=4 --encoding=utf-8 --standard=phpcs.xml src/Core -s