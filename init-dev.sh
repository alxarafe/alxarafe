#!/bin/bash
echo "Levantando contenedores..."
docker-compose up -d --build

echo "Instalando dependencias via Composer (dentro del contenedor)..."
docker-compose exec -T php composer install -d skeleton

echo "------------------------------------------------"
echo "✅ Entorno listo"
echo "🌍 App Demo: http://localhost:8081"
echo "🗄️ PhpMyAdmin: http://localhost:8082"
