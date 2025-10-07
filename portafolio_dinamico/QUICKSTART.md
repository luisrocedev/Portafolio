# ⚡ INICIO RÁPIDO - 5 MINUTOS

## 🎯 Paso a Paso

### 1️⃣ Inicia MAMP

```
✅ Abre MAMP
✅ Click en "Start Servers"
✅ Espera a que Apache y MySQL estén en verde
```

### 2️⃣ Crea la Base de Datos

**Opción A - Desde phpMyAdmin (Recomendado):**

1. Abre: http://localhost:8888/phpMyAdmin
2. Click en "Nueva" (crear base de datos)
3. Nombre: `portafolio_db`
4. Codificación: `utf8mb4_unicode_ci`
5. Click en "Crear"
6. Click en "Importar"
7. Selecciona el archivo `database.sql`
8. Click en "Continuar"

**Opción B - Desde Terminal:**

```bash
/Applications/MAMP/Library/bin/mysql -u root -p -P 8889 < database.sql
# Password: root
```

### 3️⃣ Abre el Portafolio

```
🌐 http://localhost:8888/GitHub/Portafolio/portafolio_dinamico/
```

### 4️⃣ Accede al Admin

```
🔐 http://localhost:8888/GitHub/Portafolio/portafolio_dinamico/admin/

Usuario: admin
Password: admin123
```

---

## ✅ Verificación

Si todo funciona bien, deberías ver:

✅ Página principal con 7 proyectos  
✅ Sección de skills con categorías  
✅ Información de perfil  
✅ Dark/Light mode funcional  
✅ Animaciones al hacer scroll

---

## 🎨 Personalización Inmediata

### Cambiar tu información

1. Entra al admin
2. Ve a "Perfil" → Edita tu información
3. Guarda

### Añadir un proyecto

1. Admin → "Proyectos" → "Añadir Nuevo"
2. Rellena el formulario
3. Tecnologías formato: `["HTML", "CSS", "JavaScript"]`
4. Guarda

### Cambiar colores

Edita `assets/css/style.css` líneas 15-20:

```css
:root {
  --accent: #00ff88; /* Tu color principal */
}
```

---

## 🐛 ¿Problemas?

### No conecta con la BD

```bash
# Verifica que MySQL esté corriendo
netstat -an | grep 8889

# Debe aparecer: *.8889 LISTEN
```

### Página en blanco

1. Revisa errores PHP en `/Applications/MAMP/logs/php_error.log`
2. Verifica permisos de carpetas
3. Asegúrate que la BD existe

### Admin no deja entrar

```sql
-- En phpMyAdmin ejecuta:
SELECT * FROM admin_users;
-- Debe aparecer el usuario 'admin'
```

---

## 📞 Ayuda

Si tienes problemas:

1. Revisa el `README.md` completo
2. Revisa los logs de MAMP
3. Verifica que todos los archivos estén en su lugar

---

## 🚀 Siguiente Paso

Una vez funcionando:

1. ✅ Personaliza tu información
2. ✅ Añade tus proyectos reales
3. ✅ Sube imágenes de tus proyectos
4. ✅ Ajusta los colores a tu gusto
5. ✅ ¡Prepara para subir a producción!

---

**¡Listo! Ya tienes tu portafolio dinámico funcionando.** 🎉
