#!/bin/bash

# Clear terminal screen
clear

# 1. Cleanup: Remove temporary data, unnecessary directories, and lock files
# Useful for a fresh start before rebuilding containers
echo "Cleaning up local files and directories..."
# Adjusted paths to match Alxarafe structure
sudo rm -rf docker/db/data tmp node_modules vendor composer.lock package-lock.json public/js/*

# 2. Stop and remove existing project containers to avoid conflicts
echo "Stopping and removing Alxarafe containers..."
# Using docker compose down is safer and cleaner than individual stops
docker compose down --remove-orphans

# 3. Deep clean Docker system
# Removes stopped containers, unused networks, and dangling images to free up space
echo "Pruning Docker system..."
docker system prune -f

# 4. Build and start containers in the background
# This will trigger the build process for PHP 8.5 and Node/TS
echo "Starting containers with docker compose..."
docker compose up -d --build

# 5. Dependency installation
# We run these inside the containers using the defined USER_ID to maintain permissions
echo "Installing PHP dependencies (Composer)..."
docker exec -it alxarafe_php composer install

echo "Installing Node dependencies and compiling assets..."
# Since we have a dedicated node service, we can also trigger it there
docker exec -it alxarafe_node npm install

# Note: 'docker cp' is no longer needed because volumes are mapped in docker-compose.yml
# Any change in 'vendor' or 'node_modules' is reflected instantly in all containers.

# 6. Open the application in the default browser
# Adjusted to the port 8081 we defined for Alxarafe
echo "Launching application in browser..."
xdg-open http://localhost:8081 &

echo "Development environment is ready!"
