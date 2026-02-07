#!/bin/bash
# Description: Runs static analysis tools (PHPStan, Psalm).

echo "Running PHPStan..."
docker exec alxarafe_php ./vendor/bin/phpstan analyse src --memory-limit=1G
docker exec alxarafe_php ./vendor/bin/phpstan analyse Tests --memory-limit=1G
# docker exec alxarafe_php ./vendor/bin/phpstan analyse skeleton/Tests --memory-limit=1G

echo "Running Psalm..."
docker exec alxarafe_php ./vendor/bin/psalm src --output-format=console
docker exec alxarafe_php ./vendor/bin/psalm Tests --output-format=console
# docker exec alxarafe_php ./vendor/bin/psalm skeleton/Tests --output-format=console
