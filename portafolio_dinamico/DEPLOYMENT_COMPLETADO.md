# 🚀 DEPLOYMENT PORTAFOLIO - COMPLETADO

## 📍 Información del Servidor

- **IP del VPS:** 82.165.43.137
- **Proveedor:** IONOS
- **Sistema Operativo:** Ubuntu 24.04
- **Servidor Web:** Apache 2.4.58
- **PHP:** 8.3.6
- **MySQL:** 8.0.43

## 🌐 Acceso al Portafolio

- **URL Principal:** http://82.165.43.137
- **Panel Admin:** http://82.165.43.137/admin/
- **Usuario Admin:** admin (verificar contraseña en base de datos)

## 📂 Ubicaciones en el Servidor

- **Directorio Web:** `/var/www/html/Portafolio/portafolio_dinamico`
- **Configuración Apache:** `/etc/apache2/sites-enabled/pms-daniya.conf`
- **Config DB:** `/var/www/html/Portafolio/portafolio_dinamico/config/database.php`
- **Uploads:** `/var/www/html/Portafolio/portafolio_dinamico/uploads/`
- **Logs Apache:** `/var/log/apache2/portafolio_*.log`

## 🗄️ Base de Datos

- **Nombre:** portafolio_db
- **Usuario:** portafolio_user
- **Contraseña:** P0rtf0lio_Secure_2025!
- **Host:** localhost
- **Puerto:** 3306

### Estadísticas

- ✅ 7 Proyectos
- ✅ 17 Skills
- ✅ 1 Usuario Admin

## ✅ Configuraciones Aplicadas

1. ✅ Repositorio clonado desde GitHub
2. ✅ Base de datos creada e importada
3. ✅ Usuario MySQL específico creado
4. ✅ VirtualHost configurado para la IP
5. ✅ Permisos establecidos (www-data:www-data)
6. ✅ .htaccess configurado (seguridad y caché)
7. ✅ mod_rewrite habilitado
8. ✅ Carpeta uploads con permisos 777

## 🔧 Comandos Útiles

### Reiniciar Apache

```bash
systemctl restart apache2
```

### Ver logs de errores

```bash
tail -f /var/log/apache2/portafolio_error.log
```

### Acceder a MySQL

```bash
mysql -u portafolio_user -p'P0rtf0lio_Secure_2025!' portafolio_db
```

### Actualizar desde Git

```bash
cd /var/www/html/Portafolio
git pull origin main
```

### Backup de la base de datos

```bash
mysqldump -u portafolio_user -p'P0rtf0lio_Secure_2025!' portafolio_db > backup_$(date +%Y%m%d).sql
```

## 🔐 Seguridad Implementada

- Archivo database.php protegido (permisos 640)
- Archivos .sql bloqueados via .htaccess
- Headers de seguridad configurados (X-Frame-Options, XSS-Protection)
- Directorio /config protegido
- Compresión GZIP habilitada
- Caché del navegador configurado

## 📝 Próximos Pasos Recomendados

1. 🔒 Configurar SSL/HTTPS (Let's Encrypt)
2. 🌐 Configurar dominio personalizado
3. 🔑 Cambiar contraseña del admin en el panel
4. 📧 Configurar email para formulario de contacto
5. 🔄 Configurar backups automáticos
6. 📊 Configurar Google Analytics (si aplica)

## 🎉 Estado Final

**✅ PORTAFOLIO ONLINE Y FUNCIONANDO**

Fecha de deployment: 7 de octubre de 2025
