# 🔐 Sistema de Autenticación - CineCrítica

## Descripción General

El sistema de autenticación de CineCrítica usa **Laravel Breeze** con dos métodos:
1. **Session-based** para el backend web (vistas tradicionales)
2. **API Tokens (Sanctum)** para la API y aplicaciones SPA (Vue.js)

---

## 📊 Arquitectura

```
┌─────────────────────────────────────────────────────────────┐
│                     USUARIOS                                │
│                   (App\Models\User)                         │
│  - HasApiTokens  (para tokens Sanctum)                      │
│  - Authenticatable (hereda de Laravel)                      │
│  - Notifiable (para notificaciones)                         │
└─────────────────────────────────────────────────────────────┘
                          │
            ┌─────────────┴─────────────┐
            │                           │
   ┌────────▼──────────┐      ┌────────▼──────────┐
   │   SESSION GUARD   │      │   SANCTUM GUARD   │
   │  (Web Backend)    │      │   (API & SPA)     │
   │                   │      │                   │
   │ routes/auth.php   │      │ routes/api.php    │
   │ Protegidas con    │      │ Protegidas con    │
   │ middleware 'auth' │      │ auth:sanctum      │
   └───────────────────┘      └───────────────────┘
```

---

## 🔑 Tipos de Autenticación

### 1. **Session-Based (Backend Web)**

**Ubicación:** `routes/auth.php` y `routes/web.php`

#### Flujo de Login:
```
POST /backend/login
    ↓
LoginRequest->authenticate()
    ↓
Verifica credenciales
    ↓
Verifica rol = 'admin'
    ↓
Session se regenera
    ↓
Redirige a /dashboard (protegido)
```

#### Middleware Aplicado:
```php
// Rutas protegidas
Route::group(['prefix' => 'backend', 'middleware' => ['auth', 'verified', 'admin']], function(){
    // Solo ADMIN puede acceder
    // invitados son redirigidos a home
    Route::resources(['peliculas', 'series', 'posts', ...]);
});
```

**Requisitos:**
- ✅ Email verificado (`verified` middleware)
- ✅ Contraseña correcta
- ✅ Rol = 'admin' (`admin` middleware)
- ✅ Sesión activa en el navegador

---

### 2. **API Tokens (Sanctum)**

**Ubicación:** `routes/api.php`

#### Flujo de Login en API:
```
POST /api/user/login
    ↓
UserController->login()
    ↓
Retorna: { "access_token": "xxx", "token_type": "Bearer" }
    ↓
Cliente guarda token en localStorage
    ↓
Incluye en headers: Authorization: Bearer xxx
```

#### Endpoints Protegidos:
```php
Route::middleware('auth:sanctum')->group(function () {
    // CRUD Operations (Create, Update, Delete)
    Route::post('peliculas', [PeliculaController::class, 'store']);
    Route::put('peliculas/{pelicula}', [PeliculaController::class, 'update']);
    Route::delete('peliculas/{pelicula}', [PeliculaController::class, 'destroy']);
    // ... más recursos
});
```

---

## 🛡️ Protección Implementada

### ✅ Backend Web
- ✓ Todas las rutas bajo `/backend` requieren `auth` + `verified` + `admin`
- ✓ Solo usuarios con rol 'admin' pueden acceder
- ✓ Usuarios 'guest' son redirigidos a home
- ✓ Logout disponible en `POST /backend/logout`
- ✓ Redireccionamiento automático a login si no autenticado

### ✅ API Pública (Read-Only)
- ✓ Todos los GETs son públicos: `/api/peliculas`, `/api/series`, `/api/posts`
- ✗ Sin autenticación requerida para consultas
- ✓ Ideal para el frontend Vue.js público

### ✅ API Protegida (Write Operations)
- ✓ POST, PUT, DELETE requieren `auth:sanctum`
- ✓ Solo usuarios autenticados pueden crear/editar/eliminar
- ✓ Tokens se generan en `/api/user/login`

---

## 📝 Rutas de Autenticación

### Web Routes (`routes/auth.php`)

| Ruta | Método | Middleware | Descripción |
|------|--------|-----------|-------------|
| `/backend/register` | GET/POST | guest | Formulario y guardar registro (rol: guest) |
| `/backend/login` | GET/POST | guest | Formulario y autenticar |
| `/backend/forgot-password` | GET/POST | guest | Recuperar contraseña |
| `/backend/reset-password/{token}` | GET/POST | guest | Restablecer contraseña |
| `/backend/logout` | POST | auth | Cerrar sesión |
| `/backend/verify-email` | GET | auth | Verificar email |
| `/backend/confirm-password` | GET/POST | auth | Confirmar contraseña |

### API Routes (`routes/api.php`)

| Ruta | Método | Middleware | Descripción |
|------|--------|-----------|-------------|
| `/api/user/login` | POST | - | Obtener token API |
| `/api/user/logout` | POST | auth:sanctum | Revocar token |
| `/api/user` | GET | auth:sanctum | Obtener datos del usuario |
| `/api/peliculas` (y otros) | POST/PUT/DELETE | auth:sanctum | Crear/editar/eliminar |
| `/api/peliculas` (y otros) | GET | - | Consultar (público) |

---

## � Sistema de Roles

### Roles Disponibles

#### **Admin** 
```
role = 'admin'
```
- ✅ Acceso total al backend (`/backend/*`)
- ✅ Puede crear, editar, eliminar contenido
- ✅ Acceso a todas las funciones administrativas

#### **Guest** 
```
role = 'guest'
```
- ❌ Sin acceso al backend
- ✅ Puede usar la API pública (lectura)
- ✅ Puede votar y usar funciones públicas

### Verificar Rol en Controladores

```php
// En cualquier controlador
public function store(Request $request)
{
    // Verificar si es admin
    if (!$request->user()->isAdmin()) {
        return abort(403, 'Acceso denegado');
    }
    
    // O verificar directamente
    if ($request->user()->role !== 'admin') {
        return abort(403);
    }
}
```

### Verificar Rol en Vistas Blade

```blade
@if($user->isAdmin())
    <a href="/backend/dashboard">Panel Admin</a>
@endif

@if($user->role === 'admin')
    <!-- Contenido solo para admins -->
@endif
```

### Cambiar Rol de Usuario

En Tinker:
```php
$user = User::find(1);
$user->update(['role' => 'admin']);
```

---

### Desde el Frontend Vue.js

#### 1. Login y obtener token
```javascript
// Login
const response = await axios.post('/api/user/login', {
    email: 'user@example.com',
    password: 'password'
});

// Guardar token
localStorage.setItem('token', response.data.access_token);
```

#### 2. Usar token en requests protegidas
```javascript
// Crear película
axios.post('/api/peliculas', {
    titulo: 'Nueva película',
    // ...
}, {
    headers: {
        'Authorization': `Bearer ${localStorage.getItem('token')}`
    }
});

// O configurar por defecto
axios.defaults.headers.common['Authorization'] = 
    `Bearer ${localStorage.getItem('token')}`;
```

#### 3. Logout
```javascript
// Revocar token
await axios.post('/api/user/logout');

// Limpiar localStorage
localStorage.removeItem('token');
```

### Desde el Backend Web

#### 1. Usar rutas protegidas
```php
// Automáticamente protegidas con middleware
Route::group(['middleware' => ['auth', 'verified']], function () {
    Route::resources(['peliculas' => PeliculaController::class]);
});
```

#### 2. Verificar usuario en controlador
```php
public function store(Request $request)
{
    // El usuario está autenticado y verificado
    $user = $request->user(); // Obtener usuario actual
    
    // Crear película
    $pelicula = Pelicula::create($request->all());
    
    return redirect('/dashboard');
}
```

#### 3. Logout
```html
<form method="POST" action="{{ route('logout') }}">
    @csrf
    <button type="submit">Cerrar Sesión</button>
</form>
```

---

## 🚀 Mejoras Implementadas (Recientes)

### ✅ Protección del Backend Web
```php
// ANTES: Sin protección
Route::group(['prefix' => 'backend'], function(){...});

// AHORA: Con autenticación y verificación de email
Route::group(['prefix' => 'backend', 'middleware' => ['auth', 'verified']], function(){...});
```

### ✅ Separación de Rutas API
```
PUBLIC (GET only):
  - /api/peliculas/index
  - /api/series/votos
  - /api/posts/estrenos

PROTECTED (POST/PUT/DELETE):
  - /api/peliculas (create/update/delete)
  - /api/series (create/update/delete)
  - /api/user/logout
```

---

## 🔍 Verificación de Seguridad

### Checklist
- [x] Backend web protegido con `auth` middleware
- [x] API de escritura protegida con `auth:sanctum`
- [x] Verificación de email requerida
- [x] Sessions se regeneran en login
- [x] Tokens se revocan en logout
- [x] API pública para lectura solamente
- [x] CSRF protection en formularios web

---

## 📋 Configuración Relevante

### `config/auth.php`
```php
'defaults' => [
    'guard' => 'web',           // Guard por defecto
    'passwords' => 'users',
],

'guards' => [
    'web' => [
        'driver' => 'session',  // Usa sesiones
        'provider' => 'users',
    ],
],

'providers' => [
    'users' => [
        'driver' => 'eloquent',
        'model' => App\Models\User::class,
    ],
],
```

### `config/sanctum.php`
```php
// Gestiona tokens API
// Tokens se almacenan en tabla personal_access_tokens
```

---

## ⚠️ Notas Importantes

1. **Email Verificado:** Se requiere verificación de email para acceder al backend
2. **Tokens Sanctum:** Nunca compartas tokens públicamente
3. **Password Reset:** Usa tokens con expiración de 60 minutos
4. **Rate Limiting:** Login intenta limitados por IP
5. **CSRF:** Todos los formularios deben incluir `@csrf`

---

## 🆘 Troubleshooting

### Usuario no puede loguear
1. Verificar email en base de datos
2. Asegurarse de que email_verified_at no es null
3. Comprobar contraseña (no se guarda en texto plano)

### Token de API expirado
- Tokens Sanctum no expiran por defecto
- Para limpiar: `php artisan tinker` → `PersonalAccessToken::truncate()`

### CSRF mismatch
- Asegurarse de incluir `@csrf` en todos los formularios POST

---

**Última actualización:** 7 de febrero de 2026
