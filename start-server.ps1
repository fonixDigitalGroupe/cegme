# Script PowerShell pour démarrer le serveur Laravel
Write-Host "========================================" -ForegroundColor Cyan
Write-Host "Démarrage du serveur Laravel" -ForegroundColor Cyan
Write-Host "========================================" -ForegroundColor Cyan
Write-Host ""
Write-Host "Le serveur sera accessible sur: http://127.0.0.1:8000" -ForegroundColor Green
Write-Host ""
Write-Host "Pour arrêter le serveur, appuyez sur Ctrl+C" -ForegroundColor Yellow
Write-Host ""
Write-Host "========================================" -ForegroundColor Cyan
Write-Host ""

# Changer vers le répertoire du projet
Set-Location $PSScriptRoot

# Lancer le serveur
php artisan serve

