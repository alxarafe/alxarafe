#!/bin/bash

# Clear terminal screen
clear

# Navigate to the docker directory (or stay in root if that's where compose lives)
cd "$(dirname "$0")" || exit

echo "Stopping Alxarafe services..."
# This stops all services defined in the docker-compose.yml
# It is more efficient than stopping containers one by one
docker compose stop

echo "------------------------------------------------"
echo "All containers have been stopped."
echo "Current container status:"
echo "------------------------------------------------"
# List all containers (including stopped ones) to verify status
docker ps -a --format "table {{.Names}}\t{{.Status}}"
