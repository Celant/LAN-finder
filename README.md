# LAN Finder

## Intro

UK-centric LAN party finder/database.
It uses PostgreSQL with the PostGIS extension to allow for rapid searching of events based on geographic location. 

## Dev Setup

Currently we use Laravel Sail for development.

```bash
cp .env.example .env
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php83-composer:latest \
    composer install --ignore-platform-reqs
```

This will create a .env file, and then install the compose dependencies (including Laravel Sail).

Once Laravel Sail is installed, you can then start the development stack with:
```bash
./vendor/bin/sail up -d
```
