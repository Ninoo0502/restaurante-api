# 🍽️ API de Gestión de Restaurantes

Prueba técnica desarrollada en Symfony para la gestión de restaurantes. Esta API RESTful permite crear, leer, actualizar y eliminar restaurantes, así como obtener el listado completo. Ha sido diseñada con buenas prácticas y está desplegada para facilitar su evaluación.

## 🚀 Tecnologías utilizadas

- **PHP 8.2+**
- **Symfony 6.4+**
- **Doctrine ORM**
- **MySQL (Railway)**
- **Composer**
- **API RESTful**

---

##  Despliegue en producción

- 🔗 **API REST desplegada en Railway:**  
  [`https://restaurante-api-production-005e.up.railway.app`](https://restaurante-api-production-005e.up.railway.app)

---

##  Instalación local

### 1. Clonar el repositorio

```bash
git clone https://github.com/Ninoo0502/restaurante-api.git
cd restaurante-api
```

### 2. Instalar dependencias

```bash
composer install
```

### 3. Configurar variables de entorno

Renombrar el archivo `.env.example` a `.env` y ajustar la conexión a base de datos:

```
DATABASE_URL="mysql://root:uokZFHcUuZFmnKcizmyiSxsBJWOlpBSJ@tramway.proxy.rlwy.net:58629/railway"
```

### 4. Crear la base de datos y ejecutar migraciones

```bash
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
```

### 5. Iniciar el servidor local

```bash
symfony server:start
```

> Alternativamente:  
> `php -S localhost:8000 -t public`

---

##  Endpoints disponibles

| Método | Ruta                    | Descripción                  |
|--------|-------------------------|------------------------------|
| GET    | /restaurantes           | Lista todos los restaurantes |
| GET    | /restaurantes/{id}      | Muestra un restaurante       |
| POST   | /restaurantes           | Crea un nuevo restaurante    |
| PUT    | /restaurantes/{id}      | Edita un restaurante         |
| DELETE | /restaurantes/{id}      | Elimina un restaurante       |

---

##  Estructura del proyecto

- `src/Entity/Restaurante.php`: entidad principal
- `src/Controller/RestauranteController.php`: controlador REST
- `src/Repository/RestauranteRepository.php`: consultas personalizadas
- `migrations/`: versiones de la base de datos
- `config/routes.yaml`: rutas configuradas

---

##  Funcionalidades implementadas

- CRUD completo de restaurantes
- Validaciones básicas
- API RESTful limpia y estructurada
- Migraciones automáticas con Doctrine
- Configuración adaptable mediante `.env`
- Despliegue activo en Railway

---
