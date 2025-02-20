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

composer install

docker exec geopagos_app php artisan migrate:fresh --seed


```

Abre en tu navegador la url http://localhost:8000 . La aplicación debería estar corriendo.

Puedes acceder a la interfaz de la documentación en http://localhost:8000/api/documentation

## Documentado con Swagger

#### Desarrollado por Juan Galarraga @github/juanRGalarraga