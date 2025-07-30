# Prueba Técnica - API de Restaurantes

Este proyecto es una API RESTful desarrollada en Symfony para la gestión de restaurantes. 

##  Tecnologías
- PHP 8+
- Symfony 6+
- MySQL (Railway)
- Doctrine ORM

## 🔧 Instalación local

```bash
git clone https://github.com/usuario/restaurante-api.git
cd restaurante-api
composer install
cp .env.example .env
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
symfony server:start
