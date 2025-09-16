# Guía Completa de Despliegue - Proyectos Web

## 📋 Resumen de Proyectos

### 1. PMS-Daniya (PHP + MySQL)

- **Descripción**: Sistema de gestión hotelera
- **Tecnologías**: PHP, MySQL, Bootstrap, JavaScript
- **Puerto**: 80/443 (HTTP/HTTPS)
- **Dominio sugerido**: pms.tudominio.com

### 2. CRM- (Node.js + MySQL)

- **Descripción**: Sistema de gestión de contactos
- **Tecnologías**: Node.js, Express, MySQL
- **Puerto**: 3001
- **Dominio sugerido**: crm.tudominio.com

### 3. Voltereta (Node.js + Socket.io + MySQL)

- **Descripción**: TPV para restaurante con tiempo real
- **Tecnologías**: Node.js, Socket.io, MySQL
- **Puerto**: 3000
- **Dominio sugerido**: voltereta.tudominio.com

## 🚀 Preparación para Despliegue

### Paso 1: Preparación en Local

1. **Clonar repositorios en GitHub** (si aún no lo has hecho):

   ```bash
   # Crear repositorios en GitHub primero, luego:

   cd /Applications/MAMP/htdocs/GitHub/PMS-Daniya
   git remote add origin https://github.com/tuusuario/PMS-Daniya.git
   git branch -M main
   git push -u origin main

   cd /Applications/MAMP/htdocs/GitHub/CRM-
   git remote add origin https://github.com/tuusuario/CRM.git
   git branch -M main
   git push -u origin main

   cd /Applications/MAMP/htdocs/GitHub/voltereta
   git remote add origin https://github.com/tuusuario/TPV-Voltereta.git
   git branch -M main
   git push -u origin main
   ```

2. **Configurar archivos .env en local**:
   ```bash
   # Para cada proyecto, copia el .env.example y configura con datos locales
   cp .env.example .env
   ```

### Paso 2: Configuración en Servidor Ionos

#### Requisitos del servidor:

- **PHP**: 7.4 o superior
- **Node.js**: 16 o superior
- **MySQL**: 5.7 o superior
- **Nginx/Apache**: Como servidor web
- **PM2**: Para gestión de procesos Node.js
- **SSL**: Certificado SSL/TLS

#### Configuración de dominios:

1. **Crear subdominios en Ionos**:

   - pms.tudominio.com → /var/www/pms-daniya/public
   - crm.tudominio.com → proxy a localhost:3001
   - voltereta.tudominio.com → proxy a localhost:3000

2. **Configurar SSL** para cada subdominio

### Paso 3: Instalación en Servidor

#### PMS-Daniya (PHP):

```bash
# Clonar repositorio
git clone https://github.com/tuusuario/PMS-Daniya.git /var/www/pms-daniya
cd /var/www/pms-daniya

# Instalar dependencias
composer install --no-dev --optimize-autoloader

# Configurar variables de entorno
cp .env.example .env
# Editar .env con datos reales

# Configurar base de datos
mysql -u usuario -p < pms_daniya_denia.sql

# Configurar permisos
chown -R www-data:www-data .
chmod -R 755 .
chmod -R 777 public/uploads
chmod 600 .env
```

#### CRM (Node.js):

```bash
# Clonar repositorio
git clone https://github.com/tuusuario/CRM.git /var/www/crm
cd /var/www/crm

# Instalar dependencias
npm install --production

# Configurar variables de entorno
cp .env.example .env
# Editar .env con datos reales

# Configurar base de datos
mysql -u usuario -p < crm_contactos.sql

# Configurar PM2
pm2 start app.js --name "crm-app"
pm2 save
pm2 startup
```

#### Voltereta (Node.js + Socket.io):

```bash
# Clonar repositorio
git clone https://github.com/tuusuario/TPV-Voltereta.git /var/www/voltereta
cd /var/www/voltereta

# Instalar dependencias
npm install --production

# Configurar variables de entorno
cp .env.example .env
# Editar .env con datos reales

# Configurar base de datos
mysql -u usuario -p < voltereta_db.sql

# Crear directorios necesarios
mkdir -p public/uploads public/profile_pics
chmod 777 public/uploads public/profile_pics

# Configurar PM2
pm2 start server.js --name "voltereta-app"
pm2 save
```

## 🔧 Comandos Útiles

### Gestión de PM2:

```bash
pm2 list                    # Ver procesos
pm2 restart crm-app         # Reiniciar CRM
pm2 restart voltereta-app   # Reiniciar Voltereta
pm2 logs crm-app            # Ver logs CRM
pm2 logs voltereta-app      # Ver logs Voltereta
pm2 monit                   # Monitor en tiempo real
```

### Flujo de trabajo con Git:

```bash
# Desarrollo local
git add .
git commit -m "Descripción de cambios"
git push origin main

# Despliegue en producción
cd /var/www/proyecto
./deploy.sh produccion
```
