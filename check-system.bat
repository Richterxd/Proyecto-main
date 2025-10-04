@echo off
echo 🔍 Verificacion del sistema CMBEY
echo.

echo Verificando archivos esenciales...
echo.

REM Check .env
if exist ".env" (
    echo ✅ .env - OK
) else (
    echo ❌ .env - FALTA
)

REM Check composer.json
if exist "composer.json" (
    echo ✅ composer.json - OK
) else (
    echo ❌ composer.json - FALTA
)

REM Check package.json
if exist "package.json" (
    echo ✅ package.json - OK
) else (
    echo ❌ package.json - FALTA
)

REM Check vendor directory
if exist "vendor" (
    echo ✅ vendor/ - OK
) else (
    echo ❌ vendor/ - FALTA (ejecuta: composer install)
)

REM Check node_modules
if exist "node_modules" (
    echo ✅ node_modules/ - OK
) else (
    echo ❌ node_modules/ - FALTA (ejecuta: npm install)
)

REM Check key Livewire files
if exist "app\Livewire\Auth\LoginForm.php" (
    echo ✅ LoginForm - OK
) else (
    echo ❌ LoginForm - FALTA
)

if exist "app\Livewire\Auth\RegisterForm.php" (
    echo ✅ RegisterForm - OK
) else (
    echo ❌ RegisterForm - FALTA
)

if exist "app\Livewire\Auth\PasswordRecoveryForm.php" (
    echo ✅ PasswordRecoveryForm - OK
) else (
    echo ❌ PasswordRecoveryForm - FALTA
)

REM Check models
if exist "app\Models\SecurityQuestion.php" (
    echo ✅ SecurityQuestion Model - OK
) else (
    echo ❌ SecurityQuestion Model - FALTA
)

if exist "app\Models\UserSecurityAnswer.php" (
    echo ✅ UserSecurityAnswer Model - OK
) else (
    echo ❌ UserSecurityAnswer Model - FALTA
)

echo.
echo Verificando configuracion...
echo.

REM Check APP_KEY in .env
if exist ".env" (
    findstr /C:"APP_KEY=base64:" .env >nul
    if %errorlevel% equ 0 (
        echo ✅ APP_KEY configurada
    ) else (
        echo ❌ APP_KEY no configurada
    )
)

echo.
echo 🔧 Si hay problemas, ejecuta: fix-problems.bat
echo 🚀 Para instalar todo desde cero: setup.bat
echo.
pause