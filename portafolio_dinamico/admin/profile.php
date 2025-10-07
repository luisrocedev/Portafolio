<?php
require_once 'auth.php';
require_once '../config/database.php';

$error = '';
$success = '';

$conn = getConnection();

// Obtener datos del perfil
$profile_query = "SELECT * FROM profile LIMIT 1";
$profile_result = $conn->query($profile_query);
$profile = $profile_result->fetch_assoc();

// Procesar formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $title = trim($_POST['title'] ?? '');
    $bio = trim($_POST['bio'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $location = trim($_POST['location'] ?? '');
    $github_url = trim($_POST['github_url'] ?? '');
    $linkedin_url = trim($_POST['linkedin_url'] ?? '');
    $replit_url = trim($_POST['replit_url'] ?? '');
    $avatar_url = trim($_POST['avatar_url'] ?? '');
    $cv_url = trim($_POST['cv_url'] ?? '');

    // Validaciones
    if (empty($name)) {
        $error = 'El nombre es obligatorio';
    } elseif (empty($title)) {
        $error = 'El título es obligatorio';
    } elseif (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'El email no es válido';
    } else {
        if ($profile) {
            // Actualizar perfil existente
            $stmt = $conn->prepare("
                UPDATE profile SET
                    name = ?,
                    title = ?,
                    bio = ?,
                    email = ?,
                    phone = ?,
                    location = ?,
                    github_url = ?,
                    linkedin_url = ?,
                    replit_url = ?,
                    avatar_url = ?,
                    cv_url = ?,
                    updated_at = NOW()
                WHERE id = ?
            ");

            $stmt->bind_param(
                "sssssssssssi",
                $name,
                $title,
                $bio,
                $email,
                $phone,
                $location,
                $github_url,
                $linkedin_url,
                $replit_url,
                $avatar_url,
                $cv_url,
                $profile['id']
            );
        } else {
            // Crear nuevo perfil
            $stmt = $conn->prepare("
                INSERT INTO profile (
                    name, title, bio, email, phone, location,
                    github_url, linkedin_url, replit_url, avatar_url, cv_url
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ");

            $stmt->bind_param(
                "sssssssssss",
                $name,
                $title,
                $bio,
                $email,
                $phone,
                $location,
                $github_url,
                $linkedin_url,
                $replit_url,
                $avatar_url,
                $cv_url
            );
        }

        if ($stmt->execute()) {
            $success = 'Perfil actualizado correctamente';
            $stmt->close();

            // Recargar datos
            $profile_result = $conn->query($profile_query);
            $profile = $profile_result->fetch_assoc();
        } else {
            $error = 'Error al actualizar el perfil: ' . $stmt->error;
            $stmt->close();
        }
    }
}

closeConnection($conn);

$page_title = 'Perfil';
include 'includes/header.php';
?>

<div class="admin-header">
    <div>
        <h1>👤 Mi Perfil</h1>
        <p class="text-muted">Actualiza tu información personal</p>
    </div>
    <div class="admin-header-actions">
        <a href="dashboard.php" class="btn btn-secondary">
            ← Volver al Dashboard
        </a>
    </div>
</div>

<?php if ($error): ?>
    <div class="alert alert-error">
        ⚠️ <?php echo htmlspecialchars($error); ?>
    </div>
<?php endif; ?>

<?php if ($success): ?>
    <div class="alert alert-success">
        ✅ <?php echo htmlspecialchars($success); ?>
    </div>
<?php endif; ?>

<div class="table-container">
    <form method="POST" action="">
        <div style="padding: 2rem;">
            <h3 style="margin-bottom: 1.5rem;">Información Básica</h3>

            <div class="form-group">
                <label for="name">Nombre Completo *</label>
                <input
                    type="text"
                    id="name"
                    name="name"
                    required
                    value="<?php echo htmlspecialchars($_POST['name'] ?? $profile['name'] ?? ''); ?>">
            </div>

            <div class="form-group">
                <label for="title">Título Profesional *</label>
                <input
                    type="text"
                    id="title"
                    name="title"
                    placeholder="Ej: Full Stack Developer"
                    required
                    value="<?php echo htmlspecialchars($_POST['title'] ?? $profile['title'] ?? ''); ?>">
            </div>

            <div class="form-group">
                <label for="bio">Biografía / Sobre Ti</label>
                <textarea
                    id="bio"
                    name="bio"
                    rows="8"
                    placeholder="Cuéntanos sobre ti, tu experiencia, pasiones, etc."><?php echo htmlspecialchars($_POST['bio'] ?? $profile['bio'] ?? ''); ?></textarea>
            </div>

            <hr style="margin: 2rem 0; border: none; border-top: 1px solid var(--admin-border);">

            <h3 style="margin-bottom: 1.5rem;">Contacto</h3>

            <div class="form-group">
                <label for="email">Email</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    placeholder="tu@email.com"
                    value="<?php echo htmlspecialchars($_POST['email'] ?? $profile['email'] ?? ''); ?>">
            </div>

            <div class="form-group">
                <label for="phone">Teléfono</label>
                <input
                    type="tel"
                    id="phone"
                    name="phone"
                    placeholder="+34 123 456 789"
                    value="<?php echo htmlspecialchars($_POST['phone'] ?? $profile['phone'] ?? ''); ?>">
            </div>

            <div class="form-group">
                <label for="location">Ubicación</label>
                <input
                    type="text"
                    id="location"
                    name="location"
                    placeholder="Ciudad, País"
                    value="<?php echo htmlspecialchars($_POST['location'] ?? $profile['location'] ?? ''); ?>">
            </div>

            <hr style="margin: 2rem 0; border: none; border-top: 1px solid var(--admin-border);">

            <h3 style="margin-bottom: 1.5rem;">Redes Sociales & Enlaces</h3>

            <div class="form-group">
                <label for="github_url">GitHub URL</label>
                <input
                    type="url"
                    id="github_url"
                    name="github_url"
                    placeholder="https://github.com/tu-usuario"
                    value="<?php echo htmlspecialchars($_POST['github_url'] ?? $profile['github_url'] ?? ''); ?>">
            </div>

            <div class="form-group">
                <label for="linkedin_url">LinkedIn URL</label>
                <input
                    type="url"
                    id="linkedin_url"
                    name="linkedin_url"
                    placeholder="https://linkedin.com/in/tu-usuario"
                    value="<?php echo htmlspecialchars($_POST['linkedin_url'] ?? $profile['linkedin_url'] ?? ''); ?>">
            </div>

            <div class="form-group">
                <label for="replit_url">Replit URL</label>
                <input
                    type="url"
                    id="replit_url"
                    name="replit_url"
                    placeholder="https://replit.com/@tu-usuario"
                    value="<?php echo htmlspecialchars($_POST['replit_url'] ?? $profile['replit_url'] ?? ''); ?>">
            </div>

            <hr style="margin: 2rem 0; border: none; border-top: 1px solid var(--admin-border);">

            <h3 style="margin-bottom: 1.5rem;">Archivos</h3>

            <div class="form-group">
                <label for="avatar_url">URL del Avatar/Foto</label>
                <input
                    type="text"
                    id="avatar_url"
                    name="avatar_url"
                    placeholder="assets/images/avatar.jpg"
                    value="<?php echo htmlspecialchars($_POST['avatar_url'] ?? $profile['avatar_url'] ?? ''); ?>">
                <small class="text-muted">Sube tu foto a assets/images/</small>
            </div>

            <div class="form-group">
                <label for="cv_url">URL del CV/Resume</label>
                <input
                    type="text"
                    id="cv_url"
                    name="cv_url"
                    placeholder="assets/files/cv.pdf"
                    value="<?php echo htmlspecialchars($_POST['cv_url'] ?? $profile['cv_url'] ?? ''); ?>">
                <small class="text-muted">Sube tu CV en PDF</small>
            </div>

            <div class="flex gap-2" style="margin-top: 2rem;">
                <button type="submit" class="btn btn-primary">
                    ✅ Guardar Cambios
                </button>
                <a href="dashboard.php" class="btn btn-secondary">
                    Cancelar
                </a>
            </div>
        </div>
    </form>
</div>

<?php include 'includes/footer.php'; ?>