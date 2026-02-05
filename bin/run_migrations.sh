#!/bin/bash
# Description: Runs database migrations and seeders for the Alxarafe project.

echo "Running migrations and seeders inside alxarafe_php container..."
docker exec -it alxarafe_php php /var/www/html/skeleton/public/index.php Admin Migration runMigrationsAndSeeders

echo "Process finished."
