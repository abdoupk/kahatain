@echo off
@echo off
set "parent_path=%cd%"

:loop
cd ..
set "parent_path=%cd%"

for %%f in (%parent_path%) do set "dirname=%%~nxf"
if "%dirname%" == "kafil.elyatim" (
    php artisan generate:locales
    goto :end
)

goto :loop

:end
