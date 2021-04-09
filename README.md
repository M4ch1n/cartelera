Ejercicio de desarrollo para Global Standards.

## Requerimientos
- PHP  8
- Node 15.13
- NPM  7.7
- PSQL 13.2
- Host que permita crear symlinks (no Windows)

## Configuracion
Después de clonar el repositorio, ir a la carpeta del proyecto y ejecutar lo siguiente:
- composer install
- npm install
- npm run dev

Generar el nuevo archivo .env
- cp .env.example .env

Generar las llaves
- php artisan key:generate

Crear una base de datos vacía y ajustar los parámetros en el archivo .env:
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD

Generamos el symlink
- php artisan storage:link

Generamos las tablas
- php artisan migrate

Ejecutamos seeders
- php artisan db:seed

No hay usuarios creados para el proyecto, por lo que desde el portal se puede 
generar uno para acceder al panel de administracion

Hay un par de pruebas que se pueden ejecutar con:
- php artisan test --filter PeliculaTest
