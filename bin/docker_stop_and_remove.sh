#!/bin/bash
# Description: Stops and removes the Alxarafe project containers.
# Documentation:
# This script stops and then removes the Docker containers for the Alxarafe project.
# It is useful for a partial reset of the environment without deleting volumes or images.

clear

echo "Stopping Alxarafe containers..."
docker stop alxarafe_nginx alxarafe_php alxarafe_db alxarafe_phpmyadmin alxarafe_node

echo "Removing Alxarafe containers..."
docker rm alxarafe_nginx alxarafe_php alxarafe_db alxarafe_phpmyadmin alxarafe_node

echo "List of containers"
docker ps -a
