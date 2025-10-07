# 🚀 Portafolio Dinámico con PHP + MySQL

**Portafolio profesional dinámico inspirado en zunedaalim.com**

Un portafolio moderno, minimalista y completamente gestionable desde un panel de administración. Añade, edita y elimina proyectos sin tocar código.

---

## ✨ Características

✅ **Diseño Moderno** - Inspirado en zunedaalim.com  
✅ **100% Dinámico** - Datos desde MySQL  
✅ **Panel Admin** - CRUD completo de proyectos  
✅ **Responsive** - Se adapta a todos los dispositivos  
✅ **Dark/Light Mode** - Tema claro y oscuro  
✅ **Animaciones Suaves** - Scroll animations y parallax  
✅ **Seguro** - Protección contra SQL Injection  
✅ **Fácil de Desplegar** - Compatible con cualquier hosting PHP

---

## 🛠️ Stack Tecnológico

- **Frontend**: HTML5, CSS3, JavaScript (Vanilla)
- **Backend**: PHP 7.4+
- **Base de Datos**: MySQL 5.7+
- **Servidor Local**: MAMP
- **Hosting**: Compatible con cualquier hosting PHP (IONOS, Hostinger, etc.)

---

## 📦 Instalación Rápida (10 minutos)

### Paso 1: Configurar MAMP

1. Abre **MAMP**
2. Inicia los servidores Apache y MySQL
3. Verifica que estén corriendo en:
   - Apache: `http://localhost:8888`
   - MySQL: Puerto `8889`

### Paso 2: Crear Base de Datos

1. Abre phpMyAdmin: `http://localhost:8888/phpMyAdmin`
2. Crea una nueva base de datos llamada: `portafolio_db`
3. Importa el archivo `database.sql` o ejecuta el script completo

**Opción A: Importar archivo**

- Click en "Importar"
- Selecciona `database.sql`
- Click en "Continuar"

**Opción B: Ejecutar SQL**

- Click en la pestaña "SQL"
- Copia y pega todo el contenido de `database.sql`
- Click en "Continuar"

### Paso 3: Verificar Configuración

Abre `config/database.php` y verifica que las credenciales sean correctas:

```php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', 'root');
define('DB_NAME', 'portafolio_db');
define('DB_PORT', '8889'); // Puerto MAMP
```

### Paso 4: Acceder al Portafolio

Abre en tu navegador:

```
http://localhost:8888/GitHub/Portafolio/portafolio_dinamico/
```

¡Listo! 🎉

---

## 👨‍💼 Panel de Administración

### Acceder al Panel Admin

```
http://localhost:8888/GitHub/Portafolio/portafolio_dinamico/admin/
```

**Credenciales por defecto:**

- **Usuario**: `admin`
- **Contraseña**: `admin123`

⚠️ **IMPORTANTE**: Cambia estas credenciales antes de subir a producción.

### ¿Qué puedes hacer desde el admin?

✅ Ver todos los proyectos  
✅ Añadir nuevos proyectos  
✅ Editar proyectos existentes  
✅ Eliminar proyectos  
✅ Marcar proyectos como destacados  
✅ Cambiar el orden de visualización  
✅ Editar información del perfil  
✅ Gestionar habilidades (skills)

---

## 📁 Estructura del Proyecto

```
portafolio_dinamico/
├── index.php              # Página principal (pública)
├── database.sql           # Script de base de datos
├── config/
│   ├── database.php       # Configuración de BD
│   └── .env.example       # Ejemplo de variables de entorno
├── admin/
│   ├── index.php          # Login admin
│   ├── dashboard.php      # Panel principal
│   ├── projects.php       # Gestión de proyectos
│   ├── profile.php        # Editar perfil
│   └── skills.php         # Gestión de skills
├── assets/
│   ├── css/
│   │   └── style.css      # Estilos principales
│   ├── js/
│   │   └── script.js      # JavaScript
│   └── images/            # Imágenes de proyectos
└── includes/
    ├── header.php         # Header compartido
    └── footer.php         # Footer compartido
```

---

## 🚀 Despliegue a Producción

### Preparación

1. **Cambiar credenciales admin**

   ```sql
   UPDATE admin_users
   SET password = '$2y$10$TU_PASSWORD_HASHEADO'
   WHERE username = 'admin';
   ```

2. **Actualizar configuración de BD**

   Edita `config/database.php`:

   ```php
   define('DB_HOST', 'tu-servidor-mysql.com');
   define('DB_USER', 'tu_usuario_hosting');
   define('DB_PASS', 'tu_password_seguro');
   define('DB_NAME', 'portafolio_db');
   define('DB_PORT', '3306'); // Puerto estándar
   ```

3. **Actualizar URL del sitio**
   ```php
   define('SITE_URL', 'https://tudominio.com');
   ```

### Subir a Hosting (IONOS, Hostinger, etc.)

1. **Exportar base de datos**

   - En phpMyAdmin local: Exportar → SQL → Guardar

2. **Crear base de datos en hosting**

   - Panel de hosting → MySQL → Crear BD

3. **Importar base de datos**

   - phpMyAdmin del hosting → Importar → Seleccionar archivo

4. **Subir archivos por FTP**

   - Usa FileZilla o el File Manager del hosting
   - Sube toda la carpeta `portafolio_dinamico` a `public_html/`

5. **Configurar permisos**

   - Carpeta `assets/images/`: 755
   - Archivos PHP: 644

6. **Probar**
   - Visita: `https://tudominio.com`
   - Visita admin: `https://tudominio.com/admin`

---

## 🔐 Seguridad

### Implementado ✅

- ✅ Contraseñas hasheadas con `password_hash()`
- ✅ Prepared statements (PDO) contra SQL Injection
- ✅ Validación de datos de entrada
- ✅ Protección de sesiones PHP
- ✅ `htmlspecialchars()` para prevenir XSS

### Recomendaciones adicionales

- 🔒 Usa HTTPS en producción (SSL)
- 🔒 Cambia las credenciales por defecto
- 🔒 Limita intentos de login
- 🔒 Usa `.htaccess` para proteger carpetas sensibles
- 🔒 Mantén PHP y MySQL actualizados

---

## 🎨 Personalización

### Cambiar colores

Edita `assets/css/style.css`:

```css
:root {
  --bg-primary: #0a0a0a; /* Fondo principal */
  --text-primary: #ffffff; /* Texto principal */
  --accent: #00ff88; /* Color de acento */
}
```

### Cambiar fuentes

```css
@import url("https://fonts.googleapis.com/css2?family=TU_FUENTE");

:root {
  --font-display: "TU FUENTE", sans-serif;
}
```

### Añadir secciones

1. Añade la sección en `index.php`
2. Añade el link en el navbar
3. Añade estilos en `style.css`

---

## 📊 Base de Datos

### Tablas principales

**profile** - Información personal  
**projects** - Proyectos del portafolio  
**skills** - Habilidades técnicas  
**admin_users** - Usuarios administradores

### Campos de `projects`

| Campo             | Tipo    | Descripción            |
| ----------------- | ------- | ---------------------- |
| id                | INT     | ID único               |
| title             | VARCHAR | Título del proyecto    |
| slug              | VARCHAR | URL amigable           |
| description       | TEXT    | Descripción completa   |
| short_description | VARCHAR | Descripción corta      |
| image_url         | VARCHAR | URL de la imagen       |
| technologies      | JSON    | Array de tecnologías   |
| github_url        | VARCHAR | URL de GitHub          |
| live_url          | VARCHAR | URL demo live          |
| featured          | BOOLEAN | Si es destacado        |
| order_position    | INT     | Orden de visualización |
| status            | ENUM    | active/archived/draft  |

---

## ❓ Preguntas Frecuentes

### ¿Cómo añado un nuevo proyecto?

1. Entra al panel admin
2. Click en "Proyectos" → "Añadir Nuevo"
3. Rellena el formulario
4. Guarda
5. ¡Aparecerá automáticamente en el portafolio!

### ¿Cómo subo imágenes de proyectos?

1. Sube la imagen a `assets/images/`
2. En el admin, pon la ruta: `assets/images/tu-imagen.jpg`
3. Guarda

### ¿Puedo usar PostgreSQL en vez de MySQL?

Sí, pero tendrás que adaptar las queries y la conexión en `config/database.php`.

### ¿Funciona en hosting compartido?

Sí, funciona en cualquier hosting con PHP 7.4+ y MySQL.

---

## 🐛 Solución de Problemas

### Error: "Connection failed"

- ✅ Verifica que MySQL esté corriendo
- ✅ Revisa las credenciales en `config/database.php`
- ✅ Verifica el puerto (8889 en MAMP, 3306 en producción)

### No se muestran los proyectos

- ✅ Verifica que la tabla `projects` tenga datos
- ✅ Ejecuta: `SELECT * FROM projects WHERE status = 'active'`
- ✅ Verifica que `featured = 1` si quieres que aparezcan

### Página en blanco

- ✅ Activa errores de PHP: `ini_set('display_errors', 1);`
- ✅ Revisa logs de Apache/PHP
- ✅ Verifica permisos de archivos

### Admin: "Invalid credentials"

- ✅ Verifica la contraseña en la BD
- ✅ Usuario por defecto: `admin` / `admin123`
- ✅ Si olvidaste la contraseña, regenera el hash

---

## 📝 TODO / Próximas Mejoras

- [ ] Sistema de contacto con email
- [ ] Subida de imágenes desde admin
- [ ] Blog integrado
- [ ] Multiidioma (ES/EN)
- [ ] Analytics dashboard
- [ ] API REST para proyectos
- [ ] PWA (Progressive Web App)

---

## 📄 Licencia

Este proyecto es de código abierto. Úsalo libremente en tus proyectos.

---

## 👨‍💻 Autor

**Luis Jahir Rodríguez Cedeño**  
🌐 [GitHub](https://github.com/luisrocedev)  
💼 [LinkedIn](https://linkedin.com/in/luisrocedev)  
✉️ luisrocedev@gmail.com

---

## 🙏 Créditos

- Diseño inspirado en [zunedaalim.com](https://zunedaalim.com)
- Fuentes: Google Fonts (Space Grotesk, Inter)
- Iconos: Unicode emojis

---

## 🚀 ¡A por ello!

¿Listo para crear tu portafolio profesional?

```bash
cd /Applications/MAMP/htdocs/GitHub/Portafolio/portafolio_dinamico
open http://localhost:8888/GitHub/Portafolio/portafolio_dinamico/
```

**¡Happy coding! 💻✨**
