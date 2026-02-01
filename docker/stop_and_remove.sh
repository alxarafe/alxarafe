#!/bin/bash

# Clear terminal screen
clear

# Navigate to the script's directory
cd "$(dirname "$0")" || exit

echo "Stopping and removing Alxarafe containers..."
# 'down' stops and removes containers, networks, and images defined in the compose file
# It's the cleanest way to reset the project state
docker compose down

echo "------------------------------------------------"
echo "Project containers have been removed."
echo "Current system status (should be empty for Alxarafe):"
echo "------------------------------------------------"
# List all containers to confirm they are gone
docker ps -a --format "table {{.Names}}\t{{.Status}}"
