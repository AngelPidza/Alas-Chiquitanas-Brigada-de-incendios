# Guía de Migraciones - Sistema Bomberos

## Problema Resuelto

El generador `kitloong/laravel-migrations-generator` no maneja correctamente las funciones de PostgreSQL como `uuid_generate_v4()`, generando código incorrecto:

```php
// ❌ Incorrecto (generado por defecto)
$table->uuid('id')->default('uuid_generate_v4()')->primary();

// ✅ Correcto (después del fix)
$table->uuid('id')->default(DB::raw('uuid_generate_v4()'))->primary();
```

## Solución Implementada

### 1. Comando Artisan: `migrations:fix-uuid`

Corrige automáticamente las migraciones generadas para usar `DB::raw()` con funciones de PostgreSQL.

**Uso:**
```bash
# Vista previa (dry-run)
php artisan migrations:fix-uuid --dry-run

# Aplicar correcciones
php artisan migrations:fix-uuid
```

**Funciones soportadas:**
- `uuid_generate_v4()`
- `gen_random_uuid()`
- `now()`
- `current_timestamp`
- `current_date`
- `current_time`

### 2. Migración de Extensiones PostgreSQL

Archivo: `database/migrations/0001_01_01_000003_enable_postgis_extensions.php`

Habilita las extensiones necesarias **antes** de crear las tablas:
- `postgis` - Para datos geoespaciales (geography, geometry)
- `uuid-ossp` - Para generación de UUIDs

### 3. Script de Regeneración Automática

Archivo: `regenerate-migrations.sh`

Script bash que automatiza todo el proceso:

```bash
./regenerate-migrations.sh
```

**Pasos que ejecuta:**
1. Limpia migraciones antiguas (preserva las base de Laravel)
2. Genera migraciones desde PostgreSQL con `migrate:generate`
3. Aplica el fix de UUID automáticamente
4. Verifica que la migración de PostGIS exista

## Flujo de Trabajo

### Regenerar Migraciones desde la Base de Datos

```bash
# Método 1: Script automático (recomendado)
./regenerate-migrations.sh

# Método 2: Manual
# 1. Limpiar migraciones viejas
find database/migrations -type f ! -name "0001_01_01_*" -delete

# 2. Generar desde DB
php artisan migrate:generate --connection=pgsql

# 3. Corregir UUIDs
php artisan migrations:fix-uuid

# 4. Aplicar migraciones
php artisan migrate:fresh --database=pruebas
```

### Aplicar Migraciones

```bash
# En base de datos de pruebas
php artisan migrate:fresh --database=pruebas

# En base de datos principal
php artisan migrate:fresh

# Sin eliminar datos (solo nuevas migraciones)
php artisan migrate --database=pruebas
```

## Archivos Importantes

### Comando de Fix
- **Ubicación:** `app/Console/Commands/FixMigrationsUuid.php`
- **Descripción:** Comando Artisan que corrige defaults de UUID
- **Registro:** Automático (Laravel lo detecta)

### Service Provider (Opcional)
- **Ubicación:** `app/Providers/DatabaseServiceProvider.php`
- **Descripción:** Macros para Blueprint (actualmente no usados pero disponibles)
- **Macros disponibles:**
  - `primaryUuid()` - UUID primary key con default
  - `uuidWithDefault()` - UUID con default

### Extensiones PostgreSQL
- **Ubicación:** `database/migrations/0001_01_01_000003_enable_postgis_extensions.php`
- **⚠️ IMPORTANTE:** Esta migración DEBE tener timestamp anterior a las demás

## Verificación

```bash
# Verificar que las migraciones fueron corregidas
grep -r "uuid_generate_v4" database/migrations/ | head -5

# Debe mostrar: DB::raw('uuid_generate_v4()')
# Si muestra: 'uuid_generate_v4()' (sin DB::raw), ejecutar el fix

# Verificar extensiones PostgreSQL
psql -U usuario -d nombre_db -c "\dx"
# Debe mostrar: postgis, uuid-ossp
```

## Troubleshooting

### Error: "invalid input syntax for type uuid"
**Causa:** UUID default sin `DB::raw()`
**Solución:** `php artisan migrations:fix-uuid`

### Error: "type geography does not exist"
**Causa:** PostGIS no habilitado
**Solución:** Verificar migración `0001_01_01_000003_enable_postgis_extensions.php`

### Error: "relation already exists"
**Causa:** Migraciones duplicadas
**Solución:**
```bash
# Eliminar duplicados
find database/migrations -name "*172943*" -delete
find database/migrations -name "*172946*" -delete
```

### Migraciones no se ejecutan en orden
**Causa:** Timestamp incorrecto en migración de PostGIS
**Solución:** Renombrar a `0001_01_01_000003_*` para que se ejecute primero

## Notas Técnicas

### Por qué `DB::raw()`?

Laravel escapa valores por defecto como strings. Para funciones de PostgreSQL, necesitamos que se ejecuten como expresiones SQL:

```php
// String literal (ERROR)
"'uuid_generate_v4()'"

// Expresión SQL (CORRECTO)
uuid_generate_v4()
```

### Extensiones PostgreSQL

Las extensiones deben habilitarse a nivel de base de datos:

```sql
CREATE EXTENSION IF NOT EXISTS postgis;
CREATE EXTENSION IF NOT EXISTS "uuid-ossp";
```

Laravel's `DB::statement()` ejecuta SQL raw, permitiendo crear extensiones antes de las tablas.

## Recursos

- [kitloong/laravel-migrations-generator](https://github.com/kitloong/laravel-migrations-generator)
- [Laravel Migrations Docs](https://laravel.com/docs/migrations)
- [PostGIS Documentation](https://postgis.net/documentation/)
- [PostgreSQL UUID Functions](https://www.postgresql.org/docs/current/uuid-ossp.html)
