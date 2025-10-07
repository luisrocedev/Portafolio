# 🚀 Deployment a VPS IONOS - Guía SSH

## 📋 Prerrequisitos

- [x] VPS IONOS activo
- [x] Acceso SSH (usuario y contraseña o clave SSH)
- [ ] IP del servidor o dominio configurado
- [ ] Archivos listos en tu Mac

---

## 🔧 Stack del VPS

Tu VPS necesita:

- **Sistema Operativo:** Linux (Ubuntu/Debian recomendado)
- **Web Server:** Apache o Nginx
- **PHP:** 7.4 o superior
- **MySQL:** 5.7 o superior
- **Acceso:** SSH con usuario root o sudo

---

## 📡 PASO 1: Conectar al VPS por SSH

### Desde tu Mac Terminal:

```bash
# Conectar al VPS
ssh usuario@tu-ip-o-dominio

# Ejemplo:
ssh root@123.456.789.012
# o
ssh admin@tu-dominio.com
```

**Ingresa tu contraseña** cuando te la pida.

### Verificar sistema:

```bash
# Ver sistema operativo
cat /etc/os-release

# Ver versión PHP (si está instalado)
php -v

# Ver MySQL (si está instalado)
mysql --version

# Ver Apache (si está instalado)
apache2 -v
# o
nginx -v
```

**Copia y pega aquí el resultado** para saber qué tenemos que instalar.

---

## 🛠️ PASO 2: Instalar/Verificar Stack LAMP

### A. Actualizar sistema

```bash
sudo apt update
sudo apt upgrade -y
```

### B. Instalar Apache (si no está)

```bash
sudo apt install apache2 -y

# Habilitar y arrancar
sudo systemctl enable apache2
sudo systemctl start apache2

# Verificar
sudo systemctl status apache2
```

### C. Instalar PHP 7.4+ (si no está)

```bash
# PHP y extensiones necesarias
sudo apt install php php-cli php-fpm php-mysql php-gd php-mbstring php-curl php-xml php-zip -y

# Verificar
php -v
```

### D. Instalar MySQL (si no está)

```bash
sudo apt install mysql-server -y

# Arrancar MySQL
sudo systemctl enable mysql
sudo systemctl start mysql

# Verificar
sudo systemctl status mysql
```

### E. Configurar MySQL de forma segura

```bash
sudo mysql_secure_installation
```

**Responde:**

- Validate Password Plugin: `Y` (sí)
- Password Level: `2` (strong)
- Set root password: `[TU_CONTRASEÑA_MYSQL_SEGURA]`
- Remove anonymous users: `Y`
- Disallow root login remotely: `Y`
- Remove test database: `Y`
- Reload privilege tables: `Y`

---

## 💾 PASO 3: Crear Base de Datos

### Acceder a MySQL:

```bash
sudo mysql -u root -p
# Ingresa tu contraseña MySQL
```

### Ejecutar en MySQL:

```sql
-- Crear base de datos
CREATE DATABASE portafolio_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Crear usuario
CREATE USER 'portafolio_user'@'localhost' IDENTIFIED BY 'TU_CONTRASEÑA_SUPER_SEGURA';

-- Dar privilegios
GRANT ALL PRIVILEGES ON portafolio_db.* TO 'portafolio_user'@'localhost';

-- Aplicar cambios
FLUSH PRIVILEGES;

-- Verificar
SHOW DATABASES;
SELECT User, Host FROM mysql.user;

-- Salir
EXIT;
```

**Guarda estos datos:**

```
Host: localhost
Usuario: portafolio_user
Contraseña: TU_CONTRASEÑA_SUPER_SEGURA
Base de datos: portafolio_db
Puerto: 3306
```

---

## 📤 PASO 4: Subir Archivos al VPS

### Opción A: SCP desde tu Mac (Recomendado)

**Desde tu Mac Terminal (nueva ventana):**

```bash
# Ir a la carpeta donde está el ZIP
cd /Applications/MAMP/htdocs/GitHub/Portafolio/portafolio_dinamico

# Subir ZIP al VPS
scp portafolio_produccion_*.zip usuario@tu-ip:/tmp/

# Subir backup SQL
scp backup_*/portafolio_db_*.sql usuario@tu-ip:/tmp/

# Ejemplo completo:
scp portafolio_produccion_20251004_000345.zip root@123.456.789.012:/tmp/
scp backup_20251004_000345/portafolio_db_20251004.sql root@123.456.789.012:/tmp/
```

### Opción B: Git Clone (Alternativa)

**En el VPS:**

```bash
# Si tienes el repo en GitHub
cd /var/www/html
sudo git clone https://github.com/tuusuario/Portafolio.git portfolio
cd portfolio/portafolio_dinamico
```

---

## 📂 PASO 5: Configurar Archivos en el VPS

### En tu sesión SSH del VPS:

```bash
# Ir al directorio web
cd /var/www/html

# Crear carpeta para el portfolio
sudo mkdir -p portfolio

# Ir a la carpeta
cd portfolio

# Descomprimir archivos (si usaste SCP)
sudo unzip /tmp/portafolio_produccion_*.zip -d .

# Ver estructura
ls -la
```

**Deberías ver:**

```
admin/
assets/
config/
uploads/
index.php
.htaccess.production
database.NEW.php
...
```

### Configurar database.php:

```bash
# Renombrar archivos
sudo mv config/database.php config/database.OLD.php
sudo mv config/database.NEW.php config/database.php

# Editar configuración
sudo nano config/database.php
```

**En el editor nano, busca y modifica la sección PRODUCCIÓN:**

```php
// CONFIGURACIÓN PRODUCCIÓN
define('DB_HOST', 'localhost');
define('DB_USER', 'portafolio_user');
define('DB_PASS', 'TU_CONTRASEÑA_SUPER_SEGURA'); // ← La que creaste antes
define('DB_NAME', 'portafolio_db');
define('DB_PORT', 3306);
define('DB_CHARSET', 'utf8mb4');
```

**Guardar:**

- `Ctrl + O` (Write Out)
- `Enter` (confirmar)
- `Ctrl + X` (salir)

### Configurar .htaccess:

```bash
# Renombrar
sudo mv .htaccess .htaccess.local
sudo mv .htaccess.production .htaccess

# Editar para activar HTTPS (cuando lo tengas)
sudo nano .htaccess
```

**Busca y descomenta (si tienes SSL):**

```apache
RewriteEngine On
RewriteCond %{HTTPS} off
RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
```

---

## 💾 PASO 6: Importar Base de Datos

```bash
# Importar el backup SQL
mysql -u portafolio_user -p portafolio_db < /tmp/portafolio_db_*.sql

# Te pedirá la contraseña del usuario portafolio_user
```

### Verificar importación:

```bash
mysql -u portafolio_user -p portafolio_db
```

**En MySQL:**

```sql
SHOW TABLES;
SELECT COUNT(*) FROM projects;
SELECT COUNT(*) FROM skills;
SELECT * FROM admin_users;
EXIT;
```

**Deberías ver:**

- 4 tablas (admin_users, profile, projects, skills)
- 7 proyectos
- 17 skills
- 1 admin user

---

## 🔐 PASO 7: Configurar Permisos

```bash
# Cambiar propietario a www-data (usuario de Apache)
sudo chown -R www-data:www-data /var/www/html/portfolio

# Permisos de carpetas
sudo find /var/www/html/portfolio -type d -exec chmod 755 {} \;

# Permisos de archivos
sudo find /var/www/html/portfolio -type f -exec chmod 644 {} \;

# Carpeta uploads necesita ser escribible
sudo chmod -R 775 /var/www/html/portfolio/uploads
sudo chown -R www-data:www-data /var/www/html/portfolio/uploads
```

---

## 🌐 PASO 8: Configurar Apache Virtual Host

### Crear archivo de configuración:

```bash
sudo nano /etc/apache2/sites-available/portfolio.conf
```

### Pegar esta configuración:

```apache
<VirtualHost *:80>
    ServerName tu-dominio.com
    ServerAlias www.tu-dominio.com

    DocumentRoot /var/www/html/portfolio

    <Directory /var/www/html/portfolio>
        Options -Indexes +FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>

    # Logs
    ErrorLog ${APACHE_LOG_DIR}/portfolio-error.log
    CustomLog ${APACHE_LOG_DIR}/portfolio-access.log combined
</VirtualHost>
```

**Guardar:** `Ctrl + O`, `Enter`, `Ctrl + X`

### Activar sitio:

```bash
# Habilitar mod_rewrite (necesario para .htaccess)
sudo a2enmod rewrite

# Activar el sitio
sudo a2ensite portfolio.conf

# Desactivar sitio default (opcional)
sudo a2dissite 000-default.conf

# Test de configuración
sudo apache2ctl configtest

# Reiniciar Apache
sudo systemctl restart apache2
```

---

## 🔒 PASO 9: Configurar SSL con Let's Encrypt (HTTPS)

### Instalar Certbot:

```bash
sudo apt install certbot python3-certbot-apache -y
```

### Obtener certificado SSL:

```bash
sudo certbot --apache -d tu-dominio.com -d www.tu-dominio.com
```

**Responde:**

- Email: `tu-email@gmail.com`
- Terms of Service: `A` (Agree)
- Redirect HTTP to HTTPS: `2` (Redirect)

### Verificar renovación automática:

```bash
sudo certbot renew --dry-run
```

---

## 👤 PASO 10: Actualizar Contraseña Admin

### Crear script temporal:

```bash
sudo nano /var/www/html/portfolio/admin/setup_production.php
```

### Pegar este código:

```php
<?php
require_once '../config/database.php';

$conn = getConnection();

// ⚠️ CAMBIAR ESTOS VALORES:
$new_username = 'admin';
$new_password = 'TU_CONTRASEÑA_ADMIN_SUPER_SEGURA_123!@#';
$new_email = 'tuemailreal@gmail.com';

$hashed = password_hash($new_password, PASSWORD_DEFAULT);

$stmt = $conn->prepare("UPDATE admin_users SET username=?, password=?, email=? WHERE id=1");
$stmt->bind_param("sss", $new_username, $hashed, $new_email);

if ($stmt->execute()) {
    echo "✅ Admin actualizado exitosamente<br>";
    echo "Usuario: <strong>{$new_username}</strong><br>";
    echo "Email: <strong>{$new_email}</strong><br>";
    echo "<br><p style='color: red; font-weight: bold;'>⚠️ ELIMINA ESTE ARCHIVO INMEDIATAMENTE</p>";
    echo "<br><a href='index.php'>→ Ir al Login</a>";
} else {
    echo "❌ Error: " . $stmt->error;
}

$stmt->close();
closeConnection($conn);
?>
```

**Guardar:** `Ctrl + O`, `Enter`, `Ctrl + X`

### Acceder desde navegador:

```
http://tu-ip-o-dominio/admin/setup_production.php
```

### ELIMINAR inmediatamente después:

```bash
sudo rm /var/www/html/portfolio/admin/setup_production.php
```

---

## 🧪 PASO 11: Pruebas Finales

### A. Verificar Frontend

```
http://tu-ip-o-dominio/
# o
https://tu-dominio.com/
```

**Checklist:**

- [ ] Página carga sin errores
- [ ] Se ven proyectos y skills
- [ ] Imágenes cargan
- [ ] Modo dark/light funciona
- [ ] Responsive en móvil

### B. Verificar Admin

```
https://tu-dominio.com/admin/
```

**Checklist:**

- [ ] Login funciona
- [ ] Dashboard muestra stats
- [ ] CRUD de proyectos funciona
- [ ] CRUD de skills funciona
- [ ] Subida de imágenes funciona
- [ ] Cambios se reflejan en frontend

### C. Verificar Seguridad

**Estos URLs deben dar error 403/404:**

```
https://tu-dominio.com/config/database.php  ❌
https://tu-dominio.com/database.sql          ❌
https://tu-dominio.com/.htaccess             ❌
```

---

## 🔧 Comandos Útiles del VPS

### Ver logs de Apache:

```bash
# Errores
sudo tail -f /var/log/apache2/portfolio-error.log

# Accesos
sudo tail -f /var/log/apache2/portfolio-access.log
```

### Ver logs de MySQL:

```bash
sudo tail -f /var/log/mysql/error.log
```

### Reiniciar servicios:

```bash
# Apache
sudo systemctl restart apache2

# MySQL
sudo systemctl restart mysql

# Ver estado
sudo systemctl status apache2
sudo systemctl status mysql
```

### Backup de base de datos:

```bash
# Crear backup
mysqldump -u portafolio_user -p portafolio_db > /tmp/backup_$(date +%Y%m%d).sql

# Descargar a tu Mac
# En tu Mac Terminal:
scp usuario@tu-ip:/tmp/backup_*.sql ~/Desktop/
```

### Limpiar archivos temporales:

```bash
sudo rm /tmp/portafolio_produccion_*.zip
sudo rm /tmp/portafolio_db_*.sql
```

---

## 🚨 Solución de Problemas

### Error: "Connection refused" al conectar SSH

```bash
# Verificar que SSH esté corriendo
sudo systemctl status ssh

# Si no está activo:
sudo systemctl start ssh
sudo systemctl enable ssh
```

### Error: "403 Forbidden"

```bash
# Verificar permisos
ls -la /var/www/html/portfolio

# Reconfigurar
sudo chown -R www-data:www-data /var/www/html/portfolio
sudo chmod -R 755 /var/www/html/portfolio
```

### Error: "500 Internal Server Error"

```bash
# Ver logs
sudo tail -50 /var/log/apache2/portfolio-error.log

# Común: problema con .htaccess
sudo nano /var/www/html/portfolio/.htaccess
# Comenta líneas problemáticas con #
```

### Error: "Can't connect to database"

```bash
# Verificar MySQL
sudo systemctl status mysql

# Verificar credenciales
mysql -u portafolio_user -p portafolio_db

# Ver config
cat /var/www/html/portfolio/config/database.php
```

### Página en blanco (sin errores)

```bash
# Activar display_errors temporalmente
sudo nano /var/www/html/portfolio/config/database.php

# Cambiar:
define('DEBUG_MODE', true);
ini_set('display_errors', 1);

# Recargar página para ver error exacto
# Después desactivar de nuevo
```

---

## 📊 Checklist de Deployment VPS

### Preparación Local

- [x] Backup SQL generado
- [x] ZIP de producción creado
- [x] Archivos de desarrollo eliminados

### Configuración VPS

- [ ] SSH conectado
- [ ] Stack LAMP instalado (Apache, PHP, MySQL)
- [ ] MySQL configurado de forma segura
- [ ] Base de datos creada
- [ ] Usuario MySQL creado

### Deployment

- [ ] Archivos subidos al VPS
- [ ] database.php configurado
- [ ] .htaccess configurado
- [ ] Base de datos importada
- [ ] Permisos configurados (755/644/775)
- [ ] Virtual Host configurado
- [ ] Apache reiniciado

### Seguridad

- [ ] SSL/HTTPS configurado (Let's Encrypt)
- [ ] Contraseña admin actualizada
- [ ] setup_production.php eliminado
- [ ] Archivos sensibles protegidos
- [ ] Firewall configurado (opcional)

### Verificación

- [ ] Frontend accesible
- [ ] Admin panel funciona
- [ ] CRUD operaciones funcionan
- [ ] Imágenes se suben correctamente
- [ ] HTTPS redirige correctamente
- [ ] Responsive funciona
- [ ] No hay errores en logs

---

## 🎯 URLs y Datos Importantes

```
VPS IP: 123.456.789.012
Dominio: tu-dominio.com

SSH: ssh usuario@tu-ip
Frontend: https://tu-dominio.com/
Admin: https://tu-dominio.com/admin/

MySQL:
  Host: localhost
  User: portafolio_user
  Pass: [tu contraseña]
  DB: portafolio_db

Apache Config: /etc/apache2/sites-available/portfolio.conf
Logs: /var/log/apache2/portfolio-error.log
```

---

## 🚀 ¡Ahora sí, vamos paso a paso!

**Tiempo estimado total:** 45-60 minutos

¿Empezamos conectando por SSH y verificando qué tienes instalado en el VPS?
