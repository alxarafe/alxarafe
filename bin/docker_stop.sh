#!/bin/bash
# Description: Stops the Alxarafe project containers.
# Documentation:
# This script stops the running Docker containers for the Alxarafe project.
# It uses the container names defined in the docker-compose.yml file.
# After stopping, it lists all containers (including stopped ones).

clear

echo "Stopping Alxarafe containers..."
docker stop alxarafe_nginx alxarafe_php alxarafe_db alxarafe_phpmyadmin alxarafe_node

echo "List of containers"
docker ps -a
