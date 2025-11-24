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

## 🧪 Ejemplos de Uso (cURL)

Puedes copiar y pegar estos comandos en la terminal. Nota: Reemplaza <TU_TOKEN> con el token que reciba al registrarse o iniciar sesión.

**1. Registro (Obtiene Token Automáticamente)**

```bash
curl -X POST http://localhost:8000/api/auth/register \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{"name": "Usuario Test", "email": "test@example.com", "password": "password123"}'
```

**2. Login (Si ya hay un usuario registrado)**

```bash
curl -X POST http://localhost:8000/api/auth/login \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{"email": "test@example.com", "password": "password123"}'
```

**3. Crear Autor (Requiere Token)**

```bash
curl -X POST http://localhost:8000/api/authors \
  -H "Authorization: Bearer <TU_TOKEN>" \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{"first_name": "Stephen", "last_name": "King"}'
```

**4. Crear Libro (Dispara Job Asíncrono)**

```bash
curl -X POST http://localhost:8000/api/books \
  -H "Authorization: Bearer <TU_TOKEN>" \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{"title": "It", "published_date": "1986-09-15", "author_id": 1}'
```

**5. Listar Autores (Verifica contador actualizado)**

```bash
curl -X GET http://localhost:8000/api/authors \
  -H "Authorization: Bearer <TU_TOKEN>" \
  -H "Accept: application/json"
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

