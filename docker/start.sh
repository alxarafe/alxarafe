#!/bin/bash

# Clear terminal screen
clear

# Change to the directory where docker-compose.yml is located
# Note: If docker-compose.yml is in the root, this 'cd' might not be necessary.
# Based on your previous setup, we keep it but pointing to the right folder.
cd docker

echo "Starting Alxarafe services..."
# We launch all services defined in the compose file in detached mode
docker compose up -d

# Return to the project root
cd ..

echo "------------------------------------------------"
echo "Active Containers Status:"
echo "------------------------------------------------"
# List running containers to verify everything is Up
docker ps --format "table {{.Names}}\t{{.Status}}\t{{.Ports}}"
