# Prueba Técnica API RESTful - Laravel 5.8

API RESTful para la gestión de **Autores** y **Libros** construida con **Laravel 5.8** y base de datos **SQLite**.

El proyecto está contenerizado con Docker e implementa prácticas modernas de Desarrollo Backend:
- Autenticación **JWT** para seguridad.
- Colas Asíncronas (Queues) para procesos en segundo plano.
- FormRequests para validaciones estrictas y desacopladas.
- API Resources para la transformación y estandarización de respuestas JSON.

---

## 🚀 Requisitos
- Docker
- Docker Compose
- Git

---

## 🛠️ Instalación y Despliegue

1. **Clonar el repositorio**
```bash
git clone https://github.com/slimesito/api-laravel.git
cd api-laravel
```

2. **Configurar entorno**
```bash
cp .env.example .env
touch database/database.sqlite
```

Asegurarse de que el `.env` contenga las siguientes variables:
```env
DB_CONNECTION=sqlite
DB_DATABASE=/var/www/database/database.sqlite
DB_FOREIGN_KEYS=true
QUEUE_CONNECTION=database
```

3. **Levantar contenedores**
```bash
docker compose up -d --build
```

4. **Instalar dependencias y configurar la app**
```bash
docker compose exec app composer install
docker compose exec app php artisan key:generate
docker compose exec app php artisan jwt:secret
docker compose exec app php artisan migrate
```

5. **Permisos (Linux/Mac)**
```bash
sudo chmod -R 777 storage bootstrap/cache database
```

---

## 🌱 Ejecutar Seeder para crear Usuario
```bash
docker compose exec app php artisan db:seed
```

---

## ✅ Ejecutar Pruebas
```bash
docker compose exec app ./vendor/bin/phpunit
```

---

## 📚 Endpoints Principales

| Grupo | Método | Endpoint | Descripción | Auth |
|-------|--------|----------|-------------|:----:|
| Auth | POST | `/api/auth/register` | Registro de usuario | No |
| Auth | POST | `/api/auth/login` | Iniciar sesión | No |
| Authors | GET | `/api/authors` | Listar autores | Sí |
| Authors | POST | `/api/authors` | Crear autor | Sí |
| Books | POST | `/api/books` | Crear libro (Job asíncrono) | Sí |
| Export | GET | `/api/authors-export` | Descargar Excel | Sí |

---

## ⚙️ Arquitectura y Colas
- Supervisor ejecuta los workers dentro del contenedor.
- Crear un libro dispara `BookCreated` → Listener encola `UpdateAuthorBookCount` → Worker procesa.

---

## 🐛 Problemas Comunes

**404 en Postman**
```
Usar: Accept: application/json
```

**Permisos de escritura**
```bash
sudo chmod -R 777 storage
```

**Clases no encontradas**
```bash
docker compose exec app composer dump-autoload
```

---

## 💻 Desarrollado por William Villegas

