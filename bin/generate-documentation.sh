#!/bin/bash

# Generates the documentation on docs folder
# Requires not have pending commits

php bin/sami.phar update bin/sami_documentation.php --force
