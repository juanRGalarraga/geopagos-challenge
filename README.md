# Geopagos Challenge - Tennis Tournament

API desarrollada para la prueba tecnica de Geopagos.

# Requiere

Docker (latest)
Docker Compose (latest)

## Instalación

```bash
git clone https://github.com/juanRGalarraga/geopagos-challenge

cd ./geopagos-challenge

docker-compose up -d --build

docker exec geopagos_app php artisan migrate:fresh --seed

# Opcionalmente puedes ejecutar solo "composer install" si tienes instalado composer en tu máquina

docker exec geopagos_app php artisan migrate:fresh --seed

# En el caso de que figure el error "key was not generate", esto se debe a que por algún motivo Docker
# no ejecutó el comando php artisan generate:key. En ese caso puedes ejecutarlo de la siguiente forma:
docker exec geopagos_app php artisan key:generate


```

Abre en tu navegador la url http://localhost:8000 . La aplicación debería estar corriendo.

Puedes acceder a la interfaz de la documentación en http://localhost:8000/api/documentation

## Documentado con Swagger

#### Desarrollado por Juan Galarraga @github/juanRGalarraga