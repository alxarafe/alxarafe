#!/bin/bash
# Description: Performs a clean start of the Alxarafe development environment.
# Documentation:
# This script performs a deep cleanup by removing temporary files, node_modules, 
# vendor directories, and lock files. It also stops and removes the project's 
# Docker containers and prunes the Docker system to free space. 
# Finally, it rebuilds and starts the containers, and opens the application in the browser.

clear

echo "Cleaning temporary files, directories and dependencies..."
rm -rf tmp node_modules vendor composer.lock package-lock.json

echo "Stopping and removing Alxarafe containers..."
docker stop alxarafe_nginx alxarafe_php alxarafe_db alxarafe_phpmyadmin alxarafe_node 2>/dev/null
docker rm alxarafe_nginx alxarafe_php alxarafe_db alxarafe_phpmyadmin alxarafe_node 2>/dev/null

echo "Pruning Docker system..."
docker system prune -f

echo "Starting containers with docker compose..."
docker compose up -d

echo "Opening application in browser..."
# Note: Using the HTTP_PORT from .env (8081)
xdg-open http://localhost:8081 &

echo "Clean start process finished."
docker ps
