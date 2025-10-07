<?php
require_once 'auth.php';
require_once '../config/database.php';
require_once 'includes/ImageUploader.php';

$error = '';
$success = '';

// Procesar formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $slug = trim($_POST['slug'] ?? '');
    $short_description = trim($_POST['short_description'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $image_url = trim($_POST['image_url'] ?? '');
    $technologies = trim($_POST['technologies'] ?? '');
    $github_url = trim($_POST['github_url'] ?? '');
    $live_url = trim($_POST['live_url'] ?? '');
    $video_url = trim($_POST['video_url'] ?? '');
    $featured = isset($_POST['featured']) ? 1 : 0;
    $order_position = intval($_POST['order_position'] ?? 0);
    $status = $_POST['status'] ?? 'active';

    // Procesar subida de imagen
    if (isset($_FILES['image_file']) && $_FILES['image_file']['error'] !== UPLOAD_ERR_NO_FILE) {
        $uploader = new ImageUploader();
        $upload_result = $uploader->upload($_FILES['image_file']);

        if ($upload_result['success']) {
            $image_url = $upload_result['url'];
            $success = '✅ Imagen subida: ' . $upload_result['filename'];
        } else {
            $error = $upload_result['message'];
        }
    }

    // Validaciones
    if (empty($error)) {
        if (empty($title)) {
            $error = 'El título es obligatorio';
        } elseif (empty($slug)) {
            $error = 'El slug es obligatorio';
        } elseif (empty($description)) {
            $error = 'La descripción es obligatoria';
        } else {
            // Convertir tecnologías de texto a JSON
            $tech_array = [];
            if (!empty($technologies)) {
                $tech_array = array_map('trim', explode(',', $technologies));
            }
            $tech_json = json_encode($tech_array);

            $conn = getConnection();

            // Verificar que el slug no exista
            $check_stmt = $conn->prepare("SELECT id FROM projects WHERE slug = ?");
            $check_stmt->bind_param("s", $slug);
            $check_stmt->execute();
            $check_result = $check_stmt->get_result();

            if ($check_result->num_rows > 0) {
                $error = 'Ya existe un proyecto con ese slug';
                $check_stmt->close();
            } else {
                $check_stmt->close();

                // Insertar proyecto
                $stmt = $conn->prepare("
                    INSERT INTO projects (
                        title, slug, short_description, description, image_url, 
                        technologies, github_url, live_url, video_url, featured, order_position, status
                    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
                ");

                $stmt->bind_param(
                    "sssssssssiis",
                    $title,
                    $slug,
                    $short_description,
                    $description,
                    $image_url,
                    $tech_json,
                    $github_url,
                    $live_url,
                    $video_url,
                    $featured,
                    $order_position,
                    $status
                );

                if ($stmt->execute()) {
                    $stmt->close();
                    closeConnection($conn);
                    header('Location: projects.php?success=created');
                    exit;
                } else {
                    $error = 'Error al crear el proyecto: ' . $stmt->error;
                    $stmt->close();
                }
            }

            closeConnection($conn);
        }
    }
}

$page_title = 'Nuevo Proyecto';
include 'includes/header.php';
?>

<div class="admin-header">
    <div>
        <h1>➕ Nuevo Proyecto</h1>
        <p class="text-muted">Crea un nuevo proyecto para tu portafolio</p>
    </div>
    <div class="admin-header-actions">
        <a href="projects.php" class="btn btn-secondary">
            ← Volver
        </a>
    </div>
</div>

<?php if ($error): ?>
    <div class="alert alert-error">
        ⚠️ <?php echo htmlspecialchars($error); ?>
    </div>
<?php endif; ?>

<div class="table-container">
    <form method="POST" action="" enctype="multipart/form-data">
        <div style="padding: 2rem;">
            <div class="form-group">
                <label for="title">Título del Proyecto *</label>
                <input
                    type="text"
                    id="title"
                    name="title"
                    placeholder="Ej: Mi Proyecto Increíble"
                    required
                    value="<?php echo htmlspecialchars($_POST['title'] ?? ''); ?>"
                    onblur="generateSlug()">
            </div>

            <div class="form-group">
                <label for="slug">Slug (URL amigable) *</label>
                <input
                    type="text"
                    id="slug"
                    name="slug"
                    placeholder="mi-proyecto-increible"
                    required
                    value="<?php echo htmlspecialchars($_POST['slug'] ?? ''); ?>">
                <small class="text-muted">Formato: minúsculas-separadas-por-guiones (sin espacios ni caracteres especiales)</small>
            </div>

            <div class="form-group">
                <label for="short_description">Descripción Corta</label>
                <input
                    type="text"
                    id="short_description"
                    name="short_description"
                    placeholder="Una breve descripción (ej: Aplicación web moderna)"
                    maxlength="200"
                    value="<?php echo htmlspecialchars($_POST['short_description'] ?? ''); ?>">
            </div>

            <div class="form-group">
                <label for="description">Descripción Completa *</label>
                <textarea
                    id="description"
                    name="description"
                    placeholder="Describe tu proyecto en detalle..."
                    required
                    rows="6"><?php echo htmlspecialchars($_POST['description'] ?? ''); ?></textarea>
            </div>

            <div class="form-group">
                <label for="technologies">Tecnologías (separadas por coma)</label>
                <input
                    type="text"
                    id="technologies"
                    name="technologies"
                    placeholder="HTML, CSS, JavaScript, PHP, MySQL"
                    value="<?php echo htmlspecialchars($_POST['technologies'] ?? ''); ?>">
                <small class="text-muted">Ejemplo: HTML, CSS, JavaScript, React, Node.js</small>
            </div>

            <!-- SUBIDA DE IMAGEN / GIF -->
            <div class="form-group" style="border: 2px dashed #00ff88; padding: 1.5rem; border-radius: 8px; background: rgba(0, 255, 136, 0.05);">
                <label style="display: flex; align-items: center; gap: 0.5rem; font-weight: bold; color: #00ff88; margin-bottom: 1rem;">
                    🎬 Imagen / GIF Demo
                </label>

                <div style="margin-bottom: 1rem;">
                    <label for="image_file" class="btn btn-secondary" style="display: inline-block; cursor: pointer;">
                        📁 Seleccionar Archivo (JPG, PNG, GIF)
                    </label>
                    <input
                        type="file"
                        id="image_file"
                        name="image_file"
                        accept="image/jpeg,image/png,image/gif,image/webp"
                        style="display: none;"
                        onchange="previewImage(this)">
                    <small class="text-muted" style="display: block; margin-top: 0.5rem;">
                        💡 Sube un GIF animado para mostrar tu proyecto en acción (máx 10MB)
                    </small>
                </div>

                <div id="image_preview" style="display: none; margin-top: 1rem;">
                    <img id="preview_img" src="" alt="Preview" style="max-width: 300px; border-radius: 8px; border: 2px solid #00ff88;">
                    <p id="preview_info" style="margin-top: 0.5rem; color: #00ff88;"></p>
                </div>

                <div style="margin-top: 1rem; padding-top: 1rem; border-top: 1px dashed #444;">
                    <label for="image_url">O usa una URL externa</label>
                    <input
                        type="text"
                        id="image_url"
                        name="image_url"
                        placeholder="https://ejemplo.com/mi-proyecto.gif"
                        value="<?php echo htmlspecialchars($_POST['image_url'] ?? ''); ?>">
                </div>
            </div>

            <div class="form-group">
                <label for="video_url">🎥 URL del Video Demo (Opcional)</label>
                <input
                    type="url"
                    id="video_url"
                    name="video_url"
                    placeholder="https://youtube.com/watch?v=... o https://vimeo.com/..."
                    value="<?php echo htmlspecialchars($_POST['video_url'] ?? ''); ?>">
                <small class="text-muted">
                    💡 Al hacer clic en la imagen del proyecto, se abrirá este video
                </small>
            </div>

            <div class="form-group">
                <label for="github_url">URL de GitHub</label>
                <input
                    type="url"
                    id="github_url"
                    name="github_url"
                    placeholder="https://github.com/tu-usuario/tu-proyecto"
                    value="<?php echo htmlspecialchars($_POST['github_url'] ?? ''); ?>">
            </div>

            <div class="form-group">
                <label for="live_url">URL Demo/Live</label>
                <input
                    type="url"
                    id="live_url"
                    name="live_url"
                    placeholder="https://tu-proyecto.com"
                    value="<?php echo htmlspecialchars($_POST['live_url'] ?? ''); ?>">
            </div>

            <div class="form-group">
                <label for="order_position">Orden de Visualización</label>
                <input
                    type="number"
                    id="order_position"
                    name="order_position"
                    placeholder="0"
                    min="0"
                    value="<?php echo htmlspecialchars($_POST['order_position'] ?? '0'); ?>">
                <small class="text-muted">Menor número = aparece primero</small>
            </div>

            <div class="form-group">
                <label for="status">Estado</label>
                <select id="status" name="status">
                    <option value="active" <?php echo ($_POST['status'] ?? 'active') === 'active' ? 'selected' : ''; ?>>Activo</option>
                    <option value="draft" <?php echo ($_POST['status'] ?? '') === 'draft' ? 'selected' : ''; ?>>Borrador</option>
                    <option value="archived" <?php echo ($_POST['status'] ?? '') === 'archived' ? 'selected' : ''; ?>>Archivado</option>
                </select>
            </div>

            <div class="form-group">
                <label>
                    <input
                        type="checkbox"
                        name="featured"
                        value="1"
                        <?php echo isset($_POST['featured']) ? 'checked' : ''; ?>>
                    ⭐ Marcar como proyecto destacado
                </label>
            </div>

            <div class="flex gap-2" style="margin-top: 2rem;">
                <button type="submit" class="btn btn-primary">
                    ✅ Crear Proyecto
                </button>
                <a href="projects.php" class="btn btn-secondary">
                    Cancelar
                </a>
            </div>
        </div>
    </form>
</div>

<script>
    // Generar slug automáticamente desde el título
    function generateSlug() {
        const title = document.getElementById('title').value;
        const slug = title
            .toLowerCase()
            .normalize('NFD')
            .replace(/[\u0300-\u036f]/g, '') // Quitar acentos
            .replace(/[^a-z0-9\s-]/g, '') // Quitar caracteres especiales
            .trim()
            .replace(/\s+/g, '-') // Espacios a guiones
            .replace(/-+/g, '-'); // Múltiples guiones a uno solo

        document.getElementById('slug').value = slug;
    }

    // Previsualización de imagen
    function previewImage(input) {
        const preview = document.getElementById('image_preview');
        const previewImg = document.getElementById('preview_img');
        const previewInfo = document.getElementById('preview_info');

        if (input.files && input.files[0]) {
            const file = input.files[0];
            const reader = new FileReader();

            reader.onload = function(e) {
                previewImg.src = e.target.result;
                preview.style.display = 'block';

                const sizeInMB = (file.size / 1024 / 1024).toFixed(2);
                const fileType = file.type.split('/')[1].toUpperCase();
                previewInfo.textContent = `📁 ${file.name} - ${fileType} - ${sizeInMB}MB`;

                if (file.type === 'image/gif') {
                    previewInfo.textContent += ' 🎬 (GIF Animado - Se subirá al guardar)';
                    previewInfo.style.color = '#00ff88';
                } else {
                    previewInfo.textContent += ' ✅ (Listo para subir)';
                }
            }

            reader.readAsDataURL(file);
        } else {
            preview.style.display = 'none';
        }
    }

    // Previsualización de tecnologías
    const techInput = document.getElementById('technologies');
    if (techInput) {
        techInput.addEventListener('input', function() {
            const techs = this.value.split(',').map(t => t.trim()).filter(t => t);
            console.log('Tecnologías:', techs);
        });
    }
</script>

<?php include 'includes/footer.php'; ?>