@echo off
echo 🔧 Solucionador de problemas CMBEY
echo.

echo 🔍 Diagnosticando problemas comunes...
echo.

REM Check if .env exists
if not exist ".env" (
    echo ❌ Archivo .env no encontrado
    echo ✅ Copiando desde .env.example...
    copy .env.example .env
    echo ✅ Archivo .env creado
    echo.
)

REM Check if APP_KEY is set
findstr /C:"APP_KEY=base64:" .env >nul
if %errorlevel% neq 0 (
    echo ❌ APP_KEY no configurada correctamente
    echo ✅ Generando nueva APP_KEY...
    call php artisan key:generate --force
    echo ✅ APP_KEY generada
    echo.
)

echo 🧹 Limpiando cache...
call php artisan config:clear
call php artisan cache:clear
call php artisan view:clear
call php artisan route:clear

echo.
echo 🔄 Verificando conexion a base de datos...
call php artisan migrate:status
if %errorlevel% neq 0 (
    echo.
    echo ❌ Error de conexion a base de datos
    echo.
    echo 🔍 Posibles soluciones:
    echo 1. Verifica que WAMPSERVER este ejecutandose (icono verde)
    echo 2. Confirma que existe la base de datos 'Proyecto' en phpMyAdmin
    echo 3. Verifica las credenciales en el archivo .env:
    echo    DB_HOST=127.0.0.1
    echo    DB_PORT=3306
    echo    DB_DATABASE=Proyecto
    echo    DB_USERNAME=root
    echo    DB_PASSWORD=
    echo.
    pause
    exit /b 1
)

echo ✅ Conexion a base de datos OK
echo.

echo 🔄 Verificando migraciones...
call php artisan migrate --force
if %errorlevel% neq 0 (
    echo ❌ Error en migraciones
    pause
    exit /b 1
)

echo 🌱 Verificando seeders...
call php artisan db:seed --force
if %errorlevel% neq 0 (
    echo ❌ Error en seeders
    pause
    exit /b 1
)

echo.
echo ✅ ¡Todos los problemas han sido solucionados!
echo.
echo 🚀 Iniciando servidor...
echo Visita: http://localhost:8000
echo Presiona Ctrl+C para detener
echo.

call php artisan serve --port=8000