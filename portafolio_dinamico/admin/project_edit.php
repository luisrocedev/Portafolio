<?php
require_once 'auth.php';
require_once '../config/database.php';
require_once 'includes/ImageUploader.php';

$error = '';
$success = '';
$project = null;

// Obtener ID del proyecto
$project_id = intval($_GET['id'] ?? 0);

if ($project_id === 0) {
    header('Location: projects.php');
    exit;
}

$conn = getConnection();

// Obtener datos del proyecto
$stmt = $conn->prepare("SELECT * FROM projects WHERE id = ?");
$stmt->bind_param("i", $project_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    $stmt->close();
    closeConnection($conn);
    header('Location: projects.php');
    exit;
}

$project = $result->fetch_assoc();
$stmt->close();

// Procesar formulario de actualización
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
            // Eliminar imagen anterior si existe y es local
            if (!empty($project['image_url']) && strpos($project['image_url'], 'uploads/projects/') !== false) {
                $old_filename = basename($project['image_url']);
                $uploader->delete($old_filename);
            }
            $image_url = $upload_result['url'];
            $success = '✅ Nueva imagen subida: ' . $upload_result['filename'];
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

            // Verificar que el slug no exista en otro proyecto
            $check_stmt = $conn->prepare("SELECT id FROM projects WHERE slug = ? AND id != ?");
            $check_stmt->bind_param("si", $slug, $project_id);
            $check_stmt->execute();
            $check_result = $check_stmt->get_result();

            if ($check_result->num_rows > 0) {
                $error = 'Ya existe otro proyecto con ese slug';
                $check_stmt->close();
            } else {
                $check_stmt->close();

                // Actualizar proyecto
                $update_stmt = $conn->prepare("
                    UPDATE projects SET
                        title = ?,
                        slug = ?,
                        short_description = ?,
                        description = ?,
                        image_url = ?,
                        technologies = ?,
                        github_url = ?,
                        live_url = ?,
                        video_url = ?,
                        featured = ?,
                        order_position = ?,
                        status = ?,
                        updated_at = NOW()
                    WHERE id = ?
                ");

                $update_stmt->bind_param(
                    "sssssssssiisi",
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
                    $status,
                    $project_id
                );

                if ($update_stmt->execute()) {
                    $update_stmt->close();
                    closeConnection($conn);
                    header('Location: projects.php?success=updated');
                    exit;
                } else {
                    $error = 'Error al actualizar el proyecto: ' . $update_stmt->error;
                    $update_stmt->close();
                }
            }
        }
    }
}

// Convertir JSON de tecnologías a texto para el formulario
$technologies_text = '';
$tech_array = json_decode($project['technologies'], true);
if (is_array($tech_array)) {
    $technologies_text = implode(', ', $tech_array);
}

closeConnection($conn);

$page_title = 'Editar Proyecto';
include 'includes/header.php';
?>

<div class="admin-header">
    <div>
        <h1>✏️ Editar Proyecto</h1>
        <p class="text-muted">Modificando: <?php echo htmlspecialchars($project['title']); ?></p>
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
                    required
                    value="<?php echo htmlspecialchars($_POST['title'] ?? $project['title']); ?>">
            </div>

            <div class="form-group">
                <label for="slug">Slug (URL amigable) *</label>
                <input
                    type="text"
                    id="slug"
                    name="slug"
                    required
                    value="<?php echo htmlspecialchars($_POST['slug'] ?? $project['slug']); ?>">
            </div>

            <div class="form-group">
                <label for="short_description">Descripción Corta</label>
                <input
                    type="text"
                    id="short_description"
                    name="short_description"
                    maxlength="200"
                    value="<?php echo htmlspecialchars($_POST['short_description'] ?? $project['short_description']); ?>">
            </div>

            <div class="form-group">
                <label for="description">Descripción Completa *</label>
                <textarea
                    id="description"
                    name="description"
                    required
                    rows="6"><?php echo htmlspecialchars($_POST['description'] ?? $project['description']); ?></textarea>
            </div>

            <div class="form-group">
                <label for="technologies">Tecnologías (separadas por coma)</label>
                <input
                    type="text"
                    id="technologies"
                    name="technologies"
                    value="<?php echo htmlspecialchars($_POST['technologies'] ?? $technologies_text); ?>">
            </div>

            <!-- SUBIDA DE IMAGEN / GIF -->
            <div class="form-group" style="border: 2px dashed #00ff88; padding: 1.5rem; border-radius: 8px; background: rgba(0, 255, 136, 0.05);">
                <label style="display: flex; align-items: center; gap: 0.5rem; font-weight: bold; color: #00ff88; margin-bottom: 1rem;">
                    🎬 Imagen / GIF Demo
                </label>

                <?php if (!empty($project['image_url'])): ?>
                    <div style="margin-bottom: 1rem; padding: 1rem; background: rgba(0, 255, 136, 0.1); border-radius: 8px;">
                        <p style="margin-bottom: 0.5rem; color: #00ff88;">📷 Imagen actual:</p>
                        <img src="<?php echo htmlspecialchars($project['image_url']); ?>"
                            alt="Current"
                            style="max-width: 300px; border-radius: 8px; border: 2px solid #00ff88;">
                        <p style="margin-top: 0.5rem; font-size: 0.9em;">
                            <?php echo htmlspecialchars($project['image_url']); ?>
                        </p>
                    </div>
                <?php endif; ?>

                <div style="margin-bottom: 1rem;">
                    <label for="image_file" class="btn btn-secondary" style="display: inline-block; cursor: pointer;">
                        📁 Cambiar Archivo (JPG, PNG, GIF)
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
                    <p style="color: #00ff88; margin-bottom: 0.5rem;">🆕 Nueva imagen:</p>
                    <img id="preview_img" src="" alt="Preview" style="max-width: 300px; border-radius: 8px; border: 2px solid #ff6b6b;">
                    <p id="preview_info" style="margin-top: 0.5rem; color: #ff6b6b;"></p>
                </div>

                <div style="margin-top: 1rem; padding-top: 1rem; border-top: 1px dashed #444;">
                    <label for="image_url">O usa una URL externa</label>
                    <input
                        type="text"
                        id="image_url"
                        name="image_url"
                        placeholder="https://ejemplo.com/mi-proyecto.gif"
                        value="<?php echo htmlspecialchars($_POST['image_url'] ?? $project['image_url']); ?>">
                </div>
            </div>

            <div class="form-group">
                <label for="video_url">🎥 URL del Video Demo (Opcional)</label>
                <input
                    type="url"
                    id="video_url"
                    name="video_url"
                    placeholder="https://youtube.com/watch?v=... o https://vimeo.com/..."
                    value="<?php echo htmlspecialchars($_POST['video_url'] ?? $project['video_url'] ?? ''); ?>">
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
                    value="<?php echo htmlspecialchars($_POST['github_url'] ?? $project['github_url']); ?>">
            </div>

            <div class="form-group">
                <label for="live_url">URL Demo/Live</label>
                <input
                    type="url"
                    id="live_url"
                    name="live_url"
                    value="<?php echo htmlspecialchars($_POST['live_url'] ?? $project['live_url']); ?>">
            </div>

            <div class="form-group">
                <label for="order_position">Orden de Visualización</label>
                <input
                    type="number"
                    id="order_position"
                    name="order_position"
                    min="0"
                    value="<?php echo htmlspecialchars($_POST['order_position'] ?? $project['order_position']); ?>">
            </div>

            <div class="form-group">
                <label for="status">Estado</label>
                <select id="status" name="status">
                    <?php $current_status = $_POST['status'] ?? $project['status']; ?>
                    <option value="active" <?php echo $current_status === 'active' ? 'selected' : ''; ?>>Activo</option>
                    <option value="draft" <?php echo $current_status === 'draft' ? 'selected' : ''; ?>>Borrador</option>
                    <option value="archived" <?php echo $current_status === 'archived' ? 'selected' : ''; ?>>Archivado</option>
                </select>
            </div>

            <div class="form-group">
                <label>
                    <input
                        type="checkbox"
                        name="featured"
                        value="1"
                        <?php echo (isset($_POST['featured']) || $project['featured']) ? 'checked' : ''; ?>>
                    ⭐ Marcar como proyecto destacado
                </label>
            </div>

            <div class="flex gap-2" style="margin-top: 2rem;">
                <button type="submit" class="btn btn-primary">
                    ✅ Guardar Cambios
                </button>
                <a href="projects.php" class="btn btn-secondary">
                    Cancelar
                </a>
                <a href="project_delete.php?id=<?php echo $project_id; ?>"
                    class="btn btn-danger"
                    onclick="return confirm('¿Estás seguro de eliminar este proyecto?')"
                    style="margin-left: auto;">
                    🗑️ Eliminar Proyecto
                </a>
            </div>
        </div>
    </form>
</div>

<script>
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
                    previewInfo.textContent += ' 🎬 (GIF Animado - Reemplazará la imagen actual)';
                    previewInfo.style.color = '#ff6b6b';
                } else {
                    previewInfo.textContent += ' ✅ (Listo para subir)';
                }
            }

            reader.readAsDataURL(file);
        } else {
            preview.style.display = 'none';
        }
    }
</script>

<?php include 'includes/footer.php'; ?>