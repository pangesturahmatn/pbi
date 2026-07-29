@echo off
:: Check for Administrator privileges
net session >nul 2>&1
if %errorLevel% == 0 (
    goto :run
) else (
    powershell -Command "Start-Process '%~f0' -Verb RunAs"
    exit /b
)

:run
powershell -ExecutionPolicy Bypass -WindowStyle Hidden -File "c:\laragon\www\pbi-theme-deploy\cache-cleaner\cleaner.ps1"
exit
