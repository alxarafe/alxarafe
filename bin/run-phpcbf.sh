#!/bin/bash

# Check PHP Code Beautifier and Fixer rules based on phpcs.xml

vendor/bin/phpcbf --tab-width=4 --encoding=utf-8 --standard=phpcs.xml src/Alxarafe/Core -s