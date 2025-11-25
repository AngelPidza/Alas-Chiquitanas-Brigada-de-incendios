#!/bin/bash

# Script para regenerar modelos con soporte PostGIS y UUID completo
# Uso: ./regenerate-models-with-postgis.sh

set -e

echo "========================================"
echo "  Regenerador de Modelos Laravel"
echo "  PostGIS + UUID Support"
echo "========================================"
echo ""

echo "[1/3] Regenerando modelos con Reliese..."
php artisan code:models
echo ""

echo "[2/3] Corrigiendo modelos con UUID (keyType = string)..."
php artisan uuid:fix-models
echo ""

echo "[3/3] Agregando soporte PostGIS (accessors/mutators)..."
php artisan postgis:fix-models
echo ""

echo "========================================"
echo "  Proceso completado!"
echo "========================================"
echo ""
echo "Los modelos en app/Models/ han sido:"
echo "  - Generados por Reliese"
echo "  - Corregidos para UUID (keyType = 'string')"
echo "  - Equipados con accessors/mutators PostGIS"
echo ""
