#!/bin/bash
# Description: Starts the Alxarafe project containers.
# Documentation:
# This script starts the Docker containers defined in the project's root 
# docker-compose.yml file. It clears the screen, provides status messages 
# in Spanish for the user, and lists the running containers at the end.

clear

echo "Starting Alxarafe containers with docker compose..."
docker compose up -d

echo "List of containers"
docker ps