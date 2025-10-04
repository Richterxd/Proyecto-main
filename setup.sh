#!/bin/bash

echo "🚀 Iniciando configuración del sistema CMBEY..."

# Check if Composer is installed
if ! command -v composer &> /dev/null; then
    echo "❌ Composer no está instalado. Por favor instala Composer primero."
    echo "Visita: https://getcomposer.org/download/"
    exit 1
fi

# Check if Node.js is installed
if ! command -v node &> /dev/null; then
    echo "❌ Node.js no está instalado. Por favor instala Node.js primero."
    echo "Visita: https://nodejs.org/"
    exit 1
fi

echo "📦 Instalando dependencias de PHP..."
composer install

echo "🔑 Generando clave de aplicación..."
php artisan key:generate

echo "📦 Instalando dependencias de Node.js..."
npm install

echo "🗄️ Configurando base de datos..."
echo "⚠️  IMPORTANTE: Asegúrate de que WAMPSERVER esté ejecutándose y la base de datos 'Proyecto' exista en MySQL."
read -p "¿Has creado la base de datos 'Proyecto' en phpMyAdmin? (y/n): " db_ready

if [ "$db_ready" != "y" ]; then
    echo "❌ Por favor crea la base de datos 'Proyecto' en phpMyAdmin primero."
    echo "1. Abre WAMPSERVER"
    echo "2. Ve a phpMyAdmin (http://localhost/phpmyadmin/)"
    echo "3. Crea una nueva base de datos llamada 'Proyecto'"
    echo "4. Vuelve a ejecutar este script"
    exit 1
fi

echo "🔄 Ejecutando migraciones..."
php artisan migrate

echo "🌱 Ejecutando seeders..."
php artisan db:seed

echo "🎨 Compilando assets..."
npm run build

echo "✅ ¡Configuración completada!"
echo ""
echo "🌐 Para ejecutar la aplicación:"
echo "1. Asegúrate de que WAMPSERVER esté ejecutándose"
echo "2. Ejecuta: php artisan serve --port=8000"
echo "3. Visita: http://localhost:8000"
echo ""
echo "📋 Credenciales de prueba se crearán automáticamente"
echo "🔐 Usa cualquier cédula registrada para hacer login"
echo ""
echo "¡Listo para usar! 🎉"