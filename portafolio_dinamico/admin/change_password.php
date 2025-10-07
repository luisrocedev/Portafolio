<?php
require_once 'auth.php';
require_once '../config/database.php';

$error = '';
$success = '';

// Procesar formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $current_password = $_POST['current_password'] ?? '';
    $new_password = $_POST['new_password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    // Validaciones
    if (empty($current_password) || empty($new_password) || empty($confirm_password)) {
        $error = 'Todos los campos son obligatorios';
    } elseif ($new_password !== $confirm_password) {
        $error = 'Las contraseñas nuevas no coinciden';
    } elseif (strlen($new_password) < 8) {
        $error = 'La nueva contraseña debe tener mínimo 8 caracteres';
    } else {
        $conn = getConnection();

        // Verificar contraseña actual
        $stmt = $conn->prepare("SELECT password FROM admin_users WHERE id = ?");
        $stmt->bind_param("i", $admin_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        $stmt->close();

        if (!password_verify($current_password, $user['password'])) {
            $error = 'La contraseña actual es incorrecta';
        } else {
            // Actualizar contraseña
            $new_hash = password_hash($new_password, PASSWORD_DEFAULT);
            $update_stmt = $conn->prepare("UPDATE admin_users SET password = ? WHERE id = ?");
            $update_stmt->bind_param("si", $new_hash, $admin_id);

            if ($update_stmt->execute()) {
                $success = 'Contraseña actualizada exitosamente';

                // Log de seguridad (opcional)
                $log_stmt = $conn->prepare("UPDATE admin_users SET last_login = NOW() WHERE id = ?");
                $log_stmt->bind_param("i", $admin_id);
                $log_stmt->execute();
                $log_stmt->close();
            } else {
                $error = 'Error al actualizar la contraseña';
            }
            $update_stmt->close();
        }

        closeConnection($conn);
    }
}

$page_title = 'Cambiar Contraseña';
include 'includes/header.php';
?>

<div class="admin-header">
    <div>
        <h1>🔐 Cambiar Contraseña</h1>
        <p class="text-muted">Actualiza tu contraseña de acceso al panel</p>
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

<div class="table-container" style="max-width: 600px;">
    <div class="table-header">
        <h2>Actualizar Contraseña</h2>
    </div>

    <form method="POST" action="" style="padding: 2rem;">
        <div class="form-group">
            <label for="current_password">Contraseña Actual *</label>
            <input
                type="password"
                id="current_password"
                name="current_password"
                required
                autofocus>
        </div>

        <div class="form-group">
            <label for="new_password">Nueva Contraseña *</label>
            <input
                type="password"
                id="new_password"
                name="new_password"
                required
                minlength="8">
            <small class="text-muted">Mínimo 8 caracteres. Recomendado: mayúsculas, números y símbolos</small>
        </div>

        <div class="form-group">
            <label for="confirm_password">Confirmar Nueva Contraseña *</label>
            <input
                type="password"
                id="confirm_password"
                name="confirm_password"
                required
                minlength="8">
        </div>

        <div class="form-group">
            <label>
                <input type="checkbox" id="show_passwords" onclick="togglePasswords()">
                Mostrar contraseñas
            </label>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">
                🔒 Cambiar Contraseña
            </button>
            <a href="dashboard.php" class="btn btn-secondary">
                Cancelar
            </a>
        </div>
    </form>
</div>

<!-- Recomendaciones de Seguridad -->
<div class="table-container" style="max-width: 600px; margin-top: 2rem;">
    <div class="table-header">
        <h2>🛡️ Recomendaciones de Seguridad</h2>
    </div>
    <div style="padding: 2rem;">
        <ul style="line-height: 1.8;">
            <li>✅ Usa mínimo <strong>12 caracteres</strong></li>
            <li>✅ Combina mayúsculas y minúsculas</li>
            <li>✅ Incluye números y símbolos (@, #, $, %, etc.)</li>
            <li>✅ No uses información personal (nombre, fecha)</li>
            <li>✅ No reutilices contraseñas de otros sitios</li>
            <li>✅ Cambia tu contraseña periódicamente</li>
        </ul>

        <div style="margin-top: 1.5rem; padding: 1rem; background: rgba(0, 255, 136, 0.1); border-radius: 8px; border-left: 3px solid var(--accent);">
            <strong style="color: var(--accent);">💡 Ejemplo de contraseña segura:</strong>
            <p style="margin-top: 0.5rem; font-family: monospace;">
                Mi$P0rtf0li0_2025!
            </p>
        </div>
    </div>
</div>

<!-- Información de Usuario -->
<div class="table-container" style="max-width: 600px; margin-top: 2rem;">
    <div class="table-header">
        <h2>👤 Información de tu Cuenta</h2>
    </div>
    <div style="padding: 2rem;">
        <div style="display: grid; gap: 1rem;">
            <div>
                <p class="text-muted" style="margin-bottom: 0.25rem;">Usuario</p>
                <p><strong><?php echo htmlspecialchars($admin_username); ?></strong></p>
            </div>
            <div>
                <p class="text-muted" style="margin-bottom: 0.25rem;">Email</p>
                <p><?php echo htmlspecialchars($admin_email); ?></p>
            </div>
            <div>
                <p class="text-muted" style="margin-bottom: 0.25rem;">ID</p>
                <p>#<?php echo $admin_id; ?></p>
            </div>
        </div>
    </div>
</div>

<script>
    function togglePasswords() {
        const checkbox = document.getElementById('show_passwords');
        const inputs = [
            document.getElementById('current_password'),
            document.getElementById('new_password'),
            document.getElementById('confirm_password')
        ];

        inputs.forEach(input => {
            input.type = checkbox.checked ? 'text' : 'password';
        });
    }

    // Validación en tiempo real
    const newPassword = document.getElementById('new_password');
    const confirmPassword = document.getElementById('confirm_password');

    confirmPassword.addEventListener('input', function() {
        if (newPassword.value !== confirmPassword.value) {
            confirmPassword.setCustomValidity('Las contraseñas no coinciden');
        } else {
            confirmPassword.setCustomValidity('');
        }
    });

    newPassword.addEventListener('input', function() {
        if (confirmPassword.value && newPassword.value !== confirmPassword.value) {
            confirmPassword.setCustomValidity('Las contraseñas no coinciden');
        } else {
            confirmPassword.setCustomValidity('');
        }
    });
</script>

<?php include 'includes/footer.php'; ?>