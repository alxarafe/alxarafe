#!/bin/bash

# Generates the documentation on docs folder
# Requires not have pending commits

php sami.phar update documentation.php --force
