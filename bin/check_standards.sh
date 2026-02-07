#!/bin/bash
# Description: Checks coding standards (PHPCS) and detects code smells (PHPMD).

echo "Running Coding Standards check (PHPCS)..."
docker exec alxarafe_php ./vendor/bin/phpcs --standard=phpcs.xml src/Core
docker exec alxarafe_php ./vendor/bin/phpcs --standard=phpcs.xml Tests
# docker exec alxarafe_php ./vendor/bin/phpcs --standard=phpcs.xml skeleton/Tests

# echo "Running Mess Detector (PHPMD)..."
# docker exec alxarafe_php ./vendor/bin/phpmd src/Core text cleancode,codesize,controversial,design,naming,unusedcode
# docker exec alxarafe_php ./vendor/bin/phpmd Tests text cleancode,codesize,controversial,design,naming,unusedcode
# docker exec alxarafe_php ./vendor/bin/phpmd skeleton/Tests text cleancode,codesize,controversial,design,naming,unusedcode
