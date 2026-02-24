#!/bin/bash
# Change to the project root
cd "$(dirname "$0")/.."

echo "Starting containers..."
docker-compose up -d --build

echo "Installing dependencies via Composer (inside the container)..."
docker-compose exec -T php composer install -d skeleton

echo "------------------------------------------------"
echo "✅ Environment ready"
echo "🌍 Demo App: http://localhost:8081"
echo "🗄️ PhpMyAdmin: http://localhost:8082"
