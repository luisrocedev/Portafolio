# 🎬 Sistema de Subida de Imágenes y Videos Demo

## ✅ Instalación Completada

### 📁 Archivos Creados:

1. **`/uploads/projects/`** - Carpeta para imágenes subidas
2. **`/admin/includes/ImageUploader.php`** - Clase para gestionar subidas
3. **`database_update_video.sql`** - Script SQL para añadir campo video_url

### 🔧 Actualizaciones Realizadas:

#### Admin Panel:

- ✅ **`admin/project_new.php`** - Formulario con subida de imagen/GIF
- ✅ **`admin/project_edit.php`** - Formulario de edición con subida

#### Frontend:

- ✅ **`index.php`** - Imágenes clicables que abren videos
- ✅ **`assets/css/style.css`** - Estilos para overlay de play

---

## 🚀 Cómo Usar

### Paso 1: Actualizar la Base de Datos

✅ **Ya completado** - El campo `video_url` está añadido a la tabla `projects`

### Paso 2: Subir Imágenes/GIFs

1. Ve al panel admin → Proyectos → Nuevo/Editar
2. En la sección **"🎬 Imagen / GIF Demo"**:
   - Haz clic en "📁 Seleccionar Archivo"
   - Elige un JPG, PNG, GIF o WEBP (máx 10MB)
   - Verás una previsualización del archivo
   - **¡IMPORTANTE!** Haz clic en **"✅ Crear Proyecto"** o **"✅ Guardar Cambios"** para que se suba
3. La imagen se subirá automáticamente a `/uploads/projects/`
4. Verás un mensaje verde: **"✅ Imagen subida: nombre_archivo.gif"**

**💡 Nota:** La subida ocurre cuando guardas el formulario, no al seleccionar el archivo.

### Alternativa - Usar URL Externa:

Si prefieres usar una imagen alojada en otro servidor:

- Deja el campo de archivo vacío
- Pega la URL en **"O usa una URL externa"**
- Ejemplo: `https://i.imgur.com/abc123.gif`

### Paso 3: Añadir Video Demo

1. Sube tu video a YouTube/Vimeo/etc.
2. Copia la URL completa
3. Pégala en el campo **"🎥 URL del Video Demo"**
4. Ejemplos:
   - `https://youtube.com/watch?v=ABC123`
   - `https://vimeo.com/123456789`
   - `https://tu-servidor.com/video.mp4`

### Paso 4: Ver en el Portafolio

- La imagen/GIF aparecerá en la card del proyecto
- Si hay video demo:
  - Aparece un **botón de play** al pasar el ratón
  - El botón **"🎥 Ver Demo →"** es destacado
  - Al hacer clic en la imagen → abre el video

---

## 📋 Características

### Formatos Soportados:

- ✅ **JPG/JPEG** - Imágenes estáticas
- ✅ **PNG** - Con transparencia
- ✅ **GIF** - Animados (perfecto para demos)
- ✅ **WEBP** - Formato moderno y ligero

### Optimizaciones:

- 🔄 Redimensionamiento automático a 1200px
- 📦 Compresión inteligente (85% calidad)
- 🎬 GIFs animados se mantienen intactos
- 🗑️ Elimina imagen anterior al subir nueva

### Seguridad:

- ✅ Validación de tipo MIME
- ✅ Límite de 10MB
- ✅ Nombres únicos (timestamp + random)
- ✅ .htaccess protege contra ejecución PHP

---

## 🎨 Ejemplo de Uso

### Crear Proyecto con GIF Demo:

1. **Título:** Mi Proyecto Increíble
2. **Imagen:** Subir `demo.gif` (GIF animado mostrando el proyecto)
3. **Video:** `https://youtube.com/watch?v=ABC123`
4. **Resultado:**
   - Card muestra GIF animado
   - Al pasar ratón → botón play
   - Al hacer clic → abre YouTube

### Solo Imagen (sin video):

1. **Título:** Otro Proyecto
2. **Imagen:** Subir `screenshot.png`
3. **Video:** (dejar vacío)
4. **Resultado:**
   - Card muestra imagen estática
   - No hay botón play
   - Links normales (GitHub, Live)

---

## 🛠️ Solución de Problemas

### Error: "No se puede escribir en /uploads/projects/"

```bash
chmod 755 /Applications/MAMP/htdocs/GitHub/Portafolio/portafolio_dinamico/uploads/projects
```

### Error: "El archivo es demasiado grande"

- GIFs pueden ser pesados
- Optimiza el GIF con [ezgif.com](https://ezgif.com/optimize)
- O aumenta el límite en `ImageUploader.php`:

```php
private $max_size = 20971520; // 20MB
```

### Video no se abre:

- Verifica que la URL sea correcta
- Usa URLs completas (con `https://`)
- YouTube: `https://youtube.com/watch?v=...`
- Vimeo: `https://vimeo.com/123456`

---

## 📊 Estructura Final

```
portafolio_dinamico/
├── uploads/
│   └── projects/
│       ├── .htaccess (seguridad)
│       ├── project_1696351234_a1b2c3d4.gif
│       └── project_1696351567_e5f6g7h8.jpg
├── admin/
│   ├── includes/
│   │   └── ImageUploader.php
│   ├── project_new.php (✨ actualizado)
│   └── project_edit.php (✨ actualizado)
├── index.php (✨ actualizado)
└── assets/
    └── css/
        └── style.css (✨ actualizado)
```

---

## 🎉 ¡Listo!

Tu portafolio ahora tiene:

- ✅ Subida de imágenes y GIFs
- ✅ Optimización automática
- ✅ Videos demo clicables
- ✅ Overlay de play animado
- ✅ Diseño profesional

**Recomendación:** Usa GIFs de 3-5 segundos mostrando las funcionalidades principales de cada proyecto. ¡Impresionarás a los recruiters! 🚀
