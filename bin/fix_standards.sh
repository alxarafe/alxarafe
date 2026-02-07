#!/bin/bash
# Description: Automatically fixes coding standard violations using PHPCBF.

echo "Running PHP Code Beautifier and Fixer..."

# Fix src/Core
docker exec alxarafe_php ./vendor/bin/phpcbf --tab-width=4 --encoding=utf-8 --standard=phpcs.xml src/Core -s || true

# Fix Tests
docker exec alxarafe_php ./vendor/bin/phpcbf --tab-width=4 --encoding=utf-8 --standard=phpcs.xml Tests -s || true

# Fix skeleton/Tests
docker exec alxarafe_php ./vendor/bin/phpcbf --tab-width=4 --encoding=utf-8 --standard=phpcs.xml skeleton/Tests -s || true
