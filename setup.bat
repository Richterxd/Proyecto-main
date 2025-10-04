@echo off
echo 🚀 Iniciando configuracion del sistema CMBEY...
echo.

REM Check if Composer is installed
where composer >nul 2>nul
if %errorlevel% neq 0 (
    echo ❌ Composer no esta instalado. Por favor instala Composer primero.
    echo Visita: https://getcomposer.org/download/
    pause
    exit /b 1
)

REM Check if Node.js is installed
where node >nul 2>nul
if %errorlevel% neq 0 (
    echo ❌ Node.js no esta instalado. Por favor instala Node.js primero.
    echo Visita: https://nodejs.org/
    pause
    exit /b 1
)

REM Check if PHP is installed
where php >nul 2>nul
if %errorlevel% neq 0 (
    echo ❌ PHP no esta disponible. Asegurate de que WAMPSERVER este ejecutandose.
    echo O agrega PHP al PATH del sistema.
    pause
    exit /b 1
)

echo ✅ Composer, Node.js y PHP detectados correctamente
echo.

echo 📦 Instalando dependencias de PHP...
call composer install --no-dev --optimize-autoloader
if %errorlevel% neq 0 (
    echo ❌ Error instalando dependencias de PHP
    pause
    exit /b 1
)

echo 🔑 Generando clave de aplicacion...
call php artisan key:generate --force
if %errorlevel% neq 0 (
    echo ❌ Error generando clave de aplicacion
    pause
    exit /b 1
)

echo 📦 Instalando dependencias de Node.js...
call npm install
if %errorlevel% neq 0 (
    echo ❌ Error instalando dependencias de Node.js
    pause
    exit /b 1
)

echo 🗄️ Configurando base de datos...
echo ⚠️  IMPORTANTE: Asegurate de que WAMPSERVER este ejecutandose y la base de datos 'Proyecto' exista en MySQL.
echo.
set /p db_ready="¿Has creado la base de datos 'Proyecto' en phpMyAdmin? (y/n): "

if /i not "%db_ready%"=="y" (
    echo.
    echo ❌ Por favor crea la base de datos 'Proyecto' en phpMyAdmin primero:
    echo 1. Abre WAMPSERVER
    echo 2. Ve a phpMyAdmin ^(http://localhost/phpmyadmin/^)
    echo 3. Crea una nueva base de datos llamada 'Proyecto'
    echo 4. Vuelve a ejecutar este script
    echo.
    pause
    exit /b 1
)

echo.
echo 🔄 Ejecutando migraciones...
call php artisan migrate --force
if %errorlevel% neq 0 (
    echo ❌ Error ejecutando migraciones. Verifica que:
    echo   - WAMPSERVER este ejecutandose
    echo   - La base de datos 'Proyecto' exista
    echo   - Las credenciales en .env sean correctas
    pause
    exit /b 1
)

echo 🌱 Ejecutando seeders...
call php artisan db:seed --force
if %errorlevel% neq 0 (
    echo ❌ Error ejecutando seeders
    pause
    exit /b 1
)

echo 🎨 Compilando assets...
call npm run build
if %errorlevel% neq 0 (
    echo ❌ Error compilando assets
    pause
    exit /b 1
)

echo 🧹 Limpiando cache...
call php artisan config:clear
call php artisan cache:clear
call php artisan view:clear

echo.
echo ✅ ¡Configuracion completada exitosamente!
echo.
echo 🌐 Para ejecutar la aplicacion:
echo    php artisan serve --port=8000
echo.
echo 📋 Luego visita: http://localhost:8000
echo 📊 phpMyAdmin: http://localhost/phpmyadmin/
echo.
echo 🔐 El sistema incluye:
echo   - Registro de usuarios con preguntas de seguridad
echo   - Login con cedula
echo   - Recuperacion de contraseña
echo   - 20 preguntas de seguridad en español
echo.

set /p start_server="¿Quieres iniciar el servidor ahora? (y/n): "
if /i "%start_server%"=="y" (
    echo.
    echo 🚀 Iniciando servidor en http://localhost:8000...
    echo Presiona Ctrl+C para detener el servidor
    echo.
    call php artisan serve --port=8000
) else (
    echo.
    echo 💡 Para iniciar el servidor manualmente ejecuta:
    echo    php artisan serve --port=8000
    echo.
)

echo ¡Listo para usar! 🎉
pause