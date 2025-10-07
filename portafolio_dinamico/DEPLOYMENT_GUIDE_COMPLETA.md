# 🚀 Guía de Deployment - Portafolio Dinámico a Producción

## ✅ Pre-requisitos

Antes de empezar, asegúrate de tener:

- [ ] Hosting contratado (Hostinger, SiteGround, DigitalOcean, etc.)
- [ ] Acceso FTP o SSH
- [ ] Panel de control (cPanel, Plesk, o similar)
- [ ] Dominio configurado (opcional pero recomendado)

### Requisitos del Servidor:

- PHP 7.4 o superior
- MySQL 5.7 o superior
- mod_rewrite habilitado (Apache)
- GD Library (para procesamiento de imágenes)

---

## 📋 Checklist Pre-Deployment

### 1. Seguridad Local (HACER ANTES DE SUBIR)

```bash
# 1. Cambiar contraseña del admin
# Ve a: http://localhost:8888/.../admin/change_password.php
# Usa una contraseña FUERTE (min 12 caracteres, números, símbolos)
```

### 2. Limpiar Archivos de Desarrollo

Elimina estos archivos antes de subir:

```bash
cd /Applications/MAMP/htdocs/GitHub/Portafolio/portafolio_dinamico

# Archivos de test
rm test_images.php
rm reset_password.php

# Archivos de documentación (opcional, pueden quedar en .gitignore)
# rm CHECKLIST_PRODUCCION.md
# rm GUIA_IMAGENES_VIDEO.md
# rm RESUMEN_IMAGENES.md
```

### 3. Exportar Base de Datos

```bash
# Desde terminal (MAMP):
/Applications/MAMP/Library/bin/mysql80/bin/mysqldump \
  -u root \
  -proot \
  -P 8889 \
  portafolio_db > backup_portafolio_$(date +%Y%m%d).sql

# O desde phpMyAdmin:
# 1. Abrir: http://localhost:8888/phpMyAdmin
# 2. Seleccionar "portafolio_db"
# 3. Clic en "Exportar"
# 4. Método: Rápido
# 5. Formato: SQL
# 6. Descargar
```

---

## 🌐 Deployment Paso a Paso

### PASO 1: Preparar el Servidor

#### A. Crear Base de Datos en cPanel/Hosting

1. **Accede a tu panel de control** (cPanel)
2. **MySQL Databases** o **Bases de Datos MySQL**
3. **Crear nueva base de datos:**
   - Nombre: `tu_usuario_portafolio` (ejemplo: `luisro_portfolio`)
   - Click "Crear"
4. **Crear usuario MySQL:**
   - Usuario: `tu_usuario_admin`
   - Contraseña: **Genera una segura** (guárdala)
   - Click "Crear usuario"
5. **Asignar usuario a base de datos:**
   - Selecciona usuario y base de datos
   - Marca "TODOS LOS PRIVILEGIOS"
   - Click "Hacer cambios"

📝 **Guarda estos datos:**

```
Host: localhost (o IP que te proporcione el hosting)
Usuario: tu_usuario_admin
Contraseña: ************
Base de datos: tu_usuario_portafolio
Puerto: 3306 (por defecto)
```

#### B. Importar Base de Datos

1. **phpMyAdmin en tu hosting**
2. Selecciona tu base de datos
3. Click en "Importar"
4. "Seleccionar archivo" → Elige tu `backup_portafolio_*.sql`
5. Formato: SQL
6. Click "Continuar"
7. Espera confirmación: "Importación finalizada exitosamente"

---

### PASO 2: Configurar Archivos

#### A. Actualizar config/database.php

**Opción 1: Usar el nuevo sistema multi-entorno (RECOMENDADO)**

```bash
# Renombrar archivo
mv config/database.php config/database.OLD.php
mv config/database.NEW.php config/database.php
```

Luego edita `config/database.php` y actualiza la sección de PRODUCCIÓN:

```php
define('DB_HOST', 'localhost');
define('DB_USER', 'tu_usuario_admin'); // ← Cambiar
define('DB_PASS', 'tu_contraseña_segura'); // ← Cambiar
define('DB_NAME', 'tu_usuario_portafolio'); // ← Cambiar
define('DB_PORT', 3306);
```

**Opción 2: Editar el archivo actual**

Edita `config/database.php` manualmente con los datos del hosting.

#### B. Actualizar .htaccess

```bash
# Usar la versión de producción
mv .htaccess .htaccess.local
mv .htaccess.production .htaccess
```

Edita `.htaccess` y **descomenta** las líneas de HTTPS:

```apache
# Busca esta sección y DESCOMENTA:
RewriteEngine On
RewriteCond %{HTTPS} off
RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
```

---

### PASO 3: Subir Archivos al Servidor

#### Método A: FTP/SFTP (FileZilla, Cyberduck)

1. **Conectar al servidor:**

   - Host: ftp.tu-dominio.com
   - Usuario: tu usuario FTP
   - Contraseña: tu contraseña FTP
   - Puerto: 21 (FTP) o 22 (SFTP)

2. **Navegar a la carpeta web:**

   - Usualmente: `/public_html/` o `/www/` o `/htdocs/`

3. **Subir archivos:**

   - Arrastra toda la carpeta `portafolio_dinamico`
   - O crea una subcarpeta: `/public_html/portfolio/`
   - Espera a que terminen de subir TODOS los archivos

4. **Verificar estructura:**

```
/public_html/
  └── portfolio/ (o portafolio_dinamico)
      ├── admin/
      ├── assets/
      ├── config/
      ├── uploads/
      ├── index.php
      ├── .htaccess
      └── ...
```

#### Método B: Git (Para usuarios avanzados)

```bash
# En tu servidor (SSH):
cd /home/tu_usuario/public_html
git clone https://github.com/tu_usuario/Portafolio.git portfolio
cd portfolio/portafolio_dinamico

# Configurar permisos
chmod 755 uploads/projects
chmod 644 config/database.php
```

---

### PASO 4: Configurar Permisos

**Muy importante para seguridad:**

```bash
# Permisos recomendados:

# Carpetas: 755
chmod 755 admin/
chmod 755 assets/
chmod 755 config/
chmod 755 uploads/
chmod 755 uploads/projects/

# Archivos PHP: 644
chmod 644 index.php
chmod 644 admin/*.php
chmod 644 config/database.php

# .htaccess: 644
chmod 644 .htaccess

# Uploads debe ser escribible
chmod 775 uploads/projects/
```

O desde cPanel → Administrador de Archivos → Permisos.

---

### PASO 5: Crear Usuario Admin en Producción

Como importaste la BD con el usuario de desarrollo, **debes cambiar la contraseña:**

1. **Crea un archivo temporal:** `admin/setup_admin.php`

```php
<?php
require_once '../config/database.php';

$conn = getConnection();

// CAMBIAR ESTOS VALORES:
$new_username = 'admin';
$new_password = 'TU_CONTRASEÑA_SUPER_SEGURA'; // ← CAMBIAR
$new_email = 'tu@email.com';

$hashed = password_hash($new_password, PASSWORD_DEFAULT);

// Actualizar admin existente
$stmt = $conn->prepare("UPDATE admin_users SET username=?, password=?, email=? WHERE id=1");
$stmt->bind_param("sss", $new_username, $hashed, $new_email);

if ($stmt->execute()) {
    echo "✅ Admin actualizado exitosamente<br>";
    echo "Usuario: {$new_username}<br>";
    echo "Contraseña: ********<br>";
    echo "<br>⚠️ ELIMINA ESTE ARCHIVO INMEDIATAMENTE";
} else {
    echo "❌ Error: " . $stmt->error;
}

$stmt->close();
closeConnection($conn);
?>
```

2. **Accede a:** `https://tu-dominio.com/portfolio/admin/setup_admin.php`
3. Verás: "✅ Admin actualizado exitosamente"
4. **¡ELIMINA el archivo inmediatamente!**

```bash
rm admin/setup_admin.php
```

---

### PASO 6: Pruebas Finales

#### A. Verificar Funcionamiento

1. **Frontend:**

   - [ ] Abre: `https://tu-dominio.com/portfolio/`
   - [ ] Verifica que carga correctamente
   - [ ] Verifica que se ven los proyectos
   - [ ] Verifica que se ven las skills
   - [ ] Prueba el modo dark/light
   - [ ] Prueba en móvil

2. **Admin Panel:**
   - [ ] Abre: `https://tu-dominio.com/portfolio/admin/`
   - [ ] Inicia sesión con nuevas credenciales
   - [ ] Verifica Dashboard
   - [ ] Crea un proyecto de prueba
   - [ ] Edita un proyecto
   - [ ] Sube una imagen
   - [ ] Verifica que aparece en el frontend

#### B. Verificar Seguridad

```bash
# Intenta acceder a archivos protegidos (deben dar error 403/404):

https://tu-dominio.com/portfolio/config/database.php  # ❌ Debe dar error
https://tu-dominio.com/portfolio/database.sql          # ❌ Debe dar error
https://tu-dominio.com/portfolio/test_images.php       # ❌ No debe existir
https://tu-dominio.com/portfolio/reset_password.php    # ❌ No debe existir
```

#### C. Verificar SSL/HTTPS

1. **Instalar certificado SSL** (Let's Encrypt gratis):

   - En cPanel: SSL/TLS → Let's Encrypt
   - O contacta a tu hosting para activarlo

2. **Verificar redirección automática a HTTPS**
   - Abre: `http://tu-dominio.com` (sin 's')
   - Debe redirigir automáticamente a `https://`

---

## 🎯 Post-Deployment

### Mantenimiento

1. **Backup regular de base de datos:**

   - Semanal o mensual
   - Descarga desde phpMyAdmin
   - O automatiza con cron jobs

2. **Actualizar contenido:**

   - Usa el panel admin
   - No edites archivos directamente en el servidor

3. **Monitoreo:**
   - Verifica que el sitio esté online
   - Revisa logs de errores en cPanel

### Optimizaciones Adicionales (Opcional)

1. **CDN para imágenes:**

   - Cloudinary, ImageKit, Cloudflare

2. **Google Analytics:**

   - Añadir tracking code en `index.php`

3. **SEO:**
   - Añadir meta tags dinámicos
   - Crear sitemap.xml

---

## ❓ Problemas Comunes

### Error: "No se puede conectar a la base de datos"

- ✅ Verifica credenciales en `config/database.php`
- ✅ Verifica que el usuario tenga privilegios
- ✅ Verifica que el host sea correcto (localhost o IP)

### Error: "Internal Server Error 500"

- ✅ Revisa permisos de archivos
- ✅ Revisa `.htaccess` (renómbralo temporalmente para probar)
- ✅ Revisa logs de error en cPanel

### Admin panel no carga (página en blanco)

- ✅ Verifica que PHP esté instalado (7.4+)
- ✅ Activa display_errors temporalmente
- ✅ Revisa logs de PHP

### Imágenes no se suben

- ✅ Verifica permisos de `uploads/projects/` (775)
- ✅ Verifica `upload_max_filesize` en PHP
- ✅ Verifica espacio en disco del hosting

---

## 📞 Soporte

Si tienes problemas:

1. Revisa los logs de error del servidor
2. Contacta al soporte de tu hosting
3. Verifica la documentación de tu hosting sobre PHP/MySQL

---

## ✅ Checklist Final

- [ ] Base de datos creada e importada
- [ ] config/database.php actualizado
- [ ] .htaccess configurado con HTTPS
- [ ] Archivos subidos por FTP/Git
- [ ] Permisos configurados (755/644)
- [ ] Admin password cambiado
- [ ] Archivos de desarrollo eliminados
- [ ] SSL/HTTPS activo
- [ ] Frontend funciona correctamente
- [ ] Admin panel funciona correctamente
- [ ] Pruebas en móvil completadas
- [ ] Backup de base de datos guardado

---

🎉 **¡Felicidades! Tu portafolio está en producción.**

Ahora puedes compartir tu URL:
`https://tu-dominio.com/portfolio/`
