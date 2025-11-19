#!/bin/bash

# Script para regenerar migraciones desde PostgreSQL
# Uso: ./regenerate-migrations.sh

set -e

echo "🔄 Regenerando migraciones desde base de datos..."

# 1. Eliminar migraciones existentes (excepto las base de Laravel y PostGIS)
echo "🗑️  Limpiando migraciones antiguas..."
find database/migrations -type f ! -name "0001_01_01_*" -delete

# 2. Generar migraciones desde la base de datos
echo "📦 Generando migraciones desde PostgreSQL..."
php artisan migrate:generate \
    --connection=pgsql \
    --tables=comunarios_apoyo,condiciones_climaticas,equipos,estados_sistema,focos_calor,generos,miembros_equipo,niveles_entrenamiento,niveles_gravedad,noticias_incendios,recursos,reportes_incendio,reportes,roles,tipos_incidente,tipos_recurso,tipos_sangre,usuarios

# 3. Arreglar UUIDs con DB::raw()
echo "🔧 Corrigiendo defaults de UUID..."
php artisan migrations:fix-uuid

# 4. Verificar que PostGIS extension existe
if [ ! -f "database/migrations/0001_01_01_000003_enable_postgis_extensions.php" ]; then
    echo "⚠️  Advertencia: Migración de PostGIS no encontrada"
    echo "   Ejecuta: php artisan make:migration enable_postgis_extensions"
fi

echo "✅ Migraciones regeneradas exitosamente"
echo ""
echo "Para aplicar las migraciones:"
echo "  php artisan migrate:fresh --database=pruebas"
