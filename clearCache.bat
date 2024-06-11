@echo off
cd /d %~dp0
php artisan config:clear
php artisan config:cache
php artisan route:clear
php artisan view:clear
php artisan cache:clear

echo Semua Cache telah dibersihkan.
pause