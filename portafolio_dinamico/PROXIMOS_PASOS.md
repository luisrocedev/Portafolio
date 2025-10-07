# 🎯 Próximos Pasos - Portafolio Online

## ✅ Estado Actual

**Tu portafolio está ONLINE y funcionando:** http://82.165.43.137

---

## 🔒 PASO 1: Configurar SSL/HTTPS (CRÍTICO)

### ¿Por qué es importante?

- 🔐 Seguridad para el panel admin
- 🌐 Google prioriza sitios HTTPS
- ✅ Navegadores no muestran advertencias

### Instalación con Let's Encrypt (GRATIS):

**Conecta al VPS y ejecuta:**

```bash
# Instalar Certbot
apt update
apt install certbot python3-certbot-apache -y

# Obtener certificado (necesitas dominio configurado)
certbot --apache -d tu-dominio.com -d www.tu-dominio.com

# Responde:
# Email: tu-email@gmail.com
# Terms: A (Agree)
# Redirect: 2 (Redirect HTTP to HTTPS)

# Verificar renovación automática
certbot renew --dry-run
```

**⚠️ IMPORTANTE:** Necesitas un **dominio apuntando a la IP** 82.165.43.137 antes de instalar SSL.

---

## 🌐 PASO 2: Configurar Dominio

### Opción A: Dominio propio (Recomendado)

Si tienes un dominio (ejemplo: luisroce.com):

**En tu proveedor de dominio (GoDaddy, Namecheap, etc.):**

1. Ve a DNS Settings
2. Agrega/Edita estos registros:

```
Tipo: A
Nombre: @
Valor: 82.165.43.137
TTL: 3600

Tipo: A
Nombre: www
Valor: 82.165.43.137
TTL: 3600
```

3. Espera 5-30 minutos para propagación
4. Verifica: `ping tu-dominio.com` → debe responder con 82.165.43.137

### Opción B: Subdominio de IONOS

Si IONOS te da un subdominio (ejemplo: usuario.ionos.space):

- Ya debería estar configurado automáticamente
- Verifica en panel de IONOS

### Actualizar VirtualHost en el VPS:

```bash
# Editar configuración Apache
nano /etc/apache2/sites-enabled/pms-daniya.conf

# Cambiar:
ServerName tu-dominio.com
ServerAlias www.tu-dominio.com

# Reiniciar
systemctl restart apache2
```

---

## 🔑 PASO 3: Cambiar Contraseña Admin

### Opción A: Desde el panel (Recomendado)

1. Accede: http://82.165.43.137/admin/
2. Login con credenciales actuales
3. Ve a: **Cambiar Contraseña** (menú lateral 🔐)
4. Ingresa contraseña actual
5. Nueva contraseña: **Mínimo 12 caracteres, mayúsculas, números, símbolos**
6. Confirma y guarda

### Opción B: Desde MySQL

**Si no recuerdas la contraseña actual:**

```bash
# Conectar al VPS
ssh root@82.165.43.137

# Acceder a MySQL
mysql -u portafolio_user -p'P0rtf0lio_Secure_2025!' portafolio_db

# Ejecutar en MySQL:
UPDATE admin_users
SET password = '$2y$10$VeryLongHashHere...'
WHERE username = 'admin';
```

Para generar el hash, crea un archivo temporal:

```bash
# En el VPS
nano /tmp/hash.php
```

```php
<?php
echo password_hash('TU_NUEVA_CONTRASEÑA', PASSWORD_DEFAULT);
?>
```

```bash
php /tmp/hash.php
# Copia el hash generado
# Pégalo en el comando UPDATE de arriba
rm /tmp/hash.php
```

---

## 📧 PASO 4: Configurar Email de Contacto

### Si tu portafolio tiene formulario de contacto:

**Opción A: PHP mail() nativo**

```bash
# Instalar postfix
apt install postfix -y

# Configurar como "Internet Site"
# Domain: tu-dominio.com
```

**Opción B: SMTP externo (más confiable)**

Usa servicios como:

- **SendGrid** (100 emails/día gratis)
- **Mailgun** (5,000 emails/mes gratis)
- **Gmail SMTP** (limitado, no recomendado para producción)

### Implementar en PHP:

```bash
# Instalar PHPMailer
cd /var/www/html/Portafolio/portafolio_dinamico
composer require phpmailer/phpmailer
```

---

## 🔄 PASO 5: Backups Automáticos

### Crear script de backup:

```bash
# Crear script
nano /root/backup_portafolio.sh
```

```bash
#!/bin/bash
DATE=$(date +%Y%m%d_%H%M%S)
BACKUP_DIR="/root/backups"
DB_USER="portafolio_user"
DB_PASS="P0rtf0lio_Secure_2025!"
DB_NAME="portafolio_db"

# Crear directorio
mkdir -p $BACKUP_DIR

# Backup MySQL
mysqldump -u $DB_USER -p$DB_PASS $DB_NAME > $BACKUP_DIR/db_$DATE.sql

# Backup archivos
tar -czf $BACKUP_DIR/files_$DATE.tar.gz /var/www/html/Portafolio/portafolio_dinamico

# Limpiar backups antiguos (más de 7 días)
find $BACKUP_DIR -type f -mtime +7 -delete

echo "✅ Backup completado: $DATE"
```

```bash
# Dar permisos
chmod +x /root/backup_portafolio.sh

# Probar
/root/backup_portafolio.sh
```

### Automatizar con Cron (diario a las 3 AM):

```bash
crontab -e

# Agregar:
0 3 * * * /root/backup_portafolio.sh >> /var/log/backup.log 2>&1
```

---

## 📊 PASO 6: Analytics y SEO

### Google Analytics

1. Ve a: https://analytics.google.com
2. Crea una propiedad para tu sitio
3. Copia el código de seguimiento (gtag.js)
4. Agrégalo en `index.php` antes del `</head>`:

```php
<!-- Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-XXXXXXXXXX"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', 'G-XXXXXXXXXX');
</script>
```

### SEO Básico

**Editar `index.php`:**

```php
<!-- En el <head> -->
<meta name="description" content="Portfolio de [Tu Nombre] - Desarrollador Web Full Stack especializado en PHP, JavaScript, React">
<meta name="keywords" content="desarrollador web, php, javascript, react, portfolio">
<meta name="author" content="Tu Nombre">

<!-- Open Graph (para redes sociales) -->
<meta property="og:title" content="Portfolio - Tu Nombre">
<meta property="og:description" content="Desarrollador Web Full Stack">
<meta property="og:image" content="https://tu-dominio.com/assets/img/preview.jpg">
<meta property="og:url" content="https://tu-dominio.com">
<meta property="og:type" content="website">

<!-- Twitter Card -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="Portfolio - Tu Nombre">
<meta name="twitter:description" content="Desarrollador Web Full Stack">
<meta name="twitter:image" content="https://tu-dominio.com/assets/img/preview.jpg">
```

### Crear robots.txt:

```bash
nano /var/www/html/Portafolio/portafolio_dinamico/robots.txt
```

```
User-agent: *
Allow: /
Disallow: /admin/
Disallow: /config/

Sitemap: https://tu-dominio.com/sitemap.xml
```

---

## 🛡️ PASO 7: Seguridad Adicional

### Firewall UFW:

```bash
# Instalar y configurar
apt install ufw -y

# Permitir SSH (IMPORTANTE, no te bloquees)
ufw allow 22/tcp

# Permitir HTTP y HTTPS
ufw allow 80/tcp
ufw allow 443/tcp

# Activar
ufw enable

# Verificar
ufw status
```

### Fail2Ban (protección contra ataques):

```bash
# Instalar
apt install fail2ban -y

# Crear config personalizada
cp /etc/fail2ban/jail.conf /etc/fail2ban/jail.local

# Editar
nano /etc/fail2ban/jail.local

# Buscar [sshd] y configurar:
enabled = true
port = 22
maxretry = 3
bantime = 3600

# Reiniciar
systemctl restart fail2ban
systemctl enable fail2ban

# Ver baneados
fail2ban-client status sshd
```

### Cambiar puerto SSH (opcional):

```bash
# Editar config SSH
nano /etc/ssh/sshd_config

# Cambiar:
Port 2222  # En lugar de 22

# Reiniciar SSH
systemctl restart sshd

# ⚠️ Actualizar UFW:
ufw allow 2222/tcp
ufw delete allow 22/tcp

# ⚠️ Actualizar VS Code SSH config:
# ~/.ssh/config
# Port 2222
```

---

## 🚀 PASO 8: Optimización de Rendimiento

### Habilitar Caché de Apache:

```bash
# Módulos de caché
a2enmod cache
a2enmod cache_disk
a2enmod headers
a2enmod expires

# Reiniciar
systemctl restart apache2
```

### Optimizar MySQL:

```bash
# Editar config
nano /etc/mysql/mysql.conf.d/mysqld.cnf

# Agregar al final:
[mysqld]
innodb_buffer_pool_size = 256M
max_connections = 50
query_cache_type = 1
query_cache_size = 32M

# Reiniciar
systemctl restart mysql
```

### Configurar OPcache para PHP:

```bash
# Editar
nano /etc/php/8.3/apache2/php.ini

# Buscar y modificar:
opcache.enable=1
opcache.memory_consumption=128
opcache.max_accelerated_files=10000
opcache.revalidate_freq=60

# Reiniciar Apache
systemctl restart apache2
```

---

## 📱 PASO 9: Testing

### Checklist de Pruebas:

- [ ] **Acceso Frontend:** http://82.165.43.137 ✅
- [ ] **Acceso Admin:** http://82.165.43.137/admin/ ✅
- [ ] **Login funciona** ✅
- [ ] **Crear proyecto nuevo** ⏳
- [ ] **Subir imagen** ⏳
- [ ] **Editar skill** ⏳
- [ ] **Cambios reflejan en frontend** ⏳
- [ ] **Responsive en móvil** ⏳
- [ ] **Modo dark/light funciona** ⏳
- [ ] **Videos demo funcionan** ⏳
- [ ] **Formulario de contacto** (si aplica) ⏳

### Testing de Rendimiento:

**Google PageSpeed Insights:**
https://pagespeed.web.dev/

**GTmetrix:**
https://gtmetrix.com/

**Pingdom:**
https://tools.pingdom.com/

---

## 📚 PASO 10: Documentación

### Crear archivo INFO en el servidor:

```bash
nano /var/www/html/Portafolio/portafolio_dinamico/SERVER_INFO.txt
```

```
===========================================
INFORMACIÓN DEL SERVIDOR - PORTAFOLIO
===========================================

IP: 82.165.43.137
Dominio: [tu-dominio.com cuando lo configures]
Sistema: Ubuntu 24.04
Apache: 2.4.58
PHP: 8.3.6
MySQL: 8.0.43

Base de Datos:
- Nombre: portafolio_db
- Usuario: portafolio_user
- Password: [guardada en 1Password/gestor]

Admin Panel:
- Usuario: admin
- Password: [guardada en 1Password/gestor]

SSH:
- Usuario: root
- Password: y9N1QEeq [CAMBIAR]
- Puerto: 22

Ubicaciones:
- Web: /var/www/html/Portafolio/portafolio_dinamico
- Logs: /var/log/apache2/portafolio_*.log
- Backups: /root/backups/

Última actualización: 7 de octubre de 2025
===========================================
```

---

## 🎯 Prioridades Recomendadas

### ALTA PRIORIDAD (Esta semana):

1. 🔒 **Configurar SSL/HTTPS** (crítico para seguridad)
2. 🌐 **Configurar dominio personalizado**
3. 🔑 **Cambiar contraseña admin** (más segura)
4. 🔑 **Cambiar contraseña SSH** (más segura)

### MEDIA PRIORIDAD (Este mes):

5. 🔄 **Configurar backups automáticos**
6. 🛡️ **Instalar firewall y fail2ban**
7. 📧 **Configurar email de contacto**

### BAJA PRIORIDAD (Cuando tengas tiempo):

8. 📊 **Google Analytics**
9. 🚀 **Optimizaciones de rendimiento**
10. 📱 **Testing completo en todos los dispositivos**

---

## 📞 Contacto y Soporte

### Recursos útiles:

- **IONOS Support:** https://www.ionos.es/ayuda
- **Let's Encrypt:** https://letsencrypt.org/
- **DigitalOcean Tutorials:** https://www.digitalocean.com/community/tutorials (excelentes guías Ubuntu)
- **Stack Overflow:** Para dudas específicas de código

### Comandos de emergencia:

```bash
# Si algo falla, ver logs:
tail -100 /var/log/apache2/portafolio_error.log
tail -100 /var/log/mysql/error.log

# Reiniciar todo:
systemctl restart apache2
systemctl restart mysql

# Restaurar backup:
mysql -u portafolio_user -p'P0rtf0lio_Secure_2025!' portafolio_db < /root/backups/db_XXXXXXXX.sql
```

---

## 🎉 ¡Felicidades!

Tu portafolio está **ONLINE y funcionando**. Has completado:

- ✅ Configuración completa del VPS
- ✅ Instalación del stack LAMP
- ✅ Deployment del portafolio
- ✅ Configuración de base de datos
- ✅ Seguridad básica implementada

**¡Ahora sigue mejorando y actualizando tu portafolio!** 🚀

---

**Fecha:** 7 de octubre de 2025  
**Versión:** 1.0  
**Estado:** ✅ ONLINE
