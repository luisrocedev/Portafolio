<?php
require_once 'auth.php';
require_once '../config/database.php';

$conn = getConnection();

$skill_id = intval($_GET['id'] ?? 0);

// Obtener la skill actual
$stmt = $conn->prepare("SELECT * FROM skills WHERE id = ?");
$stmt->bind_param("i", $skill_id);
$stmt->execute();
$result = $stmt->get_result();
$skill = $result->fetch_assoc();
$stmt->close();

if (!$skill) {
    header('Location: skills.php');
    exit;
}

$error = '';
$success = '';

// Procesar formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $category = $_POST['category'] ?? 'other';
    $level = $_POST['level'] ?? 'intermedio';
    $order_position = intval($_POST['order_position'] ?? 0);

    if (empty($name)) {
        $error = 'El nombre de la skill es obligatorio';
    } else {
        $update_stmt = $conn->prepare("
            UPDATE skills 
            SET name = ?, 
                category = ?, 
                level = ?,
                order_position = ?
            WHERE id = ?
        ");
        $update_stmt->bind_param("sssii", $name, $category, $level, $order_position, $skill_id);

        if ($update_stmt->execute()) {
            header('Location: skills.php?success=updated');
            exit;
        } else {
            $error = 'Error al actualizar la skill';
        }
        $update_stmt->close();
    }
}

closeConnection($conn);

$page_title = 'Editar Skill';
include 'includes/header.php';
?>

<div class="admin-header">
    <div>
        <h1>✏️ Editar Skill</h1>
        <p class="text-muted">Modifica la información de la skill</p>
    </div>
    <a href="skills.php" class="btn btn-secondary">← Volver</a>
</div>

<?php if ($error): ?>
    <div class="alert alert-error">
        ❌ <?php echo htmlspecialchars($error); ?>
    </div>
<?php endif; ?>

<?php if ($success): ?>
    <div class="alert alert-success">
        ✅ <?php echo htmlspecialchars($success); ?>
    </div>
<?php endif; ?>

<div class="table-container">
    <form method="POST" action="">
        <div class="form-group">
            <label for="name">Nombre de la Skill *</label>
            <input
                type="text"
                id="name"
                name="name"
                value="<?php echo htmlspecialchars($skill['name']); ?>"
                required>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="category">Categoría *</label>
                <select id="category" name="category">
                    <option value="frontend" <?php echo $skill['category'] === 'frontend' ? 'selected' : ''; ?>>
                        🎨 Frontend
                    </option>
                    <option value="backend" <?php echo $skill['category'] === 'backend' ? 'selected' : ''; ?>>
                        ⚙️ Backend
                    </option>
                    <option value="database" <?php echo $skill['category'] === 'database' ? 'selected' : ''; ?>>
                        💾 Database
                    </option>
                    <option value="tools" <?php echo $skill['category'] === 'tools' ? 'selected' : ''; ?>>
                        🔧 Tools
                    </option>
                    <option value="other" <?php echo $skill['category'] === 'other' ? 'selected' : ''; ?>>
                        📦 Other
                    </option>
                </select>
            </div>

            <div class="form-group">
                <label for="level">Nivel *</label>
                <select id="level" name="level">
                    <option value="básico" <?php echo $skill['level'] === 'básico' ? 'selected' : ''; ?>>
                        Básico
                    </option>
                    <option value="intermedio" <?php echo $skill['level'] === 'intermedio' ? 'selected' : ''; ?>>
                        Intermedio
                    </option>
                    <option value="avanzado" <?php echo $skill['level'] === 'avanzado' ? 'selected' : ''; ?>>
                        Avanzado
                    </option>
                    <option value="experto" <?php echo $skill['level'] === 'experto' ? 'selected' : ''; ?>>
                        Experto
                    </option>
                </select>
            </div>

            <div class="form-group">
                <label for="order_position">Posición de Orden</label>
                <input
                    type="number"
                    id="order_position"
                    name="order_position"
                    value="<?php echo htmlspecialchars($skill['order_position']); ?>"
                    min="0">
                <small class="form-help">
                    Número más bajo = aparece primero en su categoría
                </small>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">
                💾 Guardar Cambios
            </button>
            <a href="skills.php" class="btn btn-secondary">
                ❌ Cancelar
            </a>
        </div>
    </form>
</div>

<!-- INFORMACIÓN ADICIONAL -->
<div class="table-container" style="margin-top: 2rem;">
    <div class="table-header">
        <h2>📊 Información de la Skill</h2>
    </div>
    <div style="padding: 2rem;">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
            <div>
                <p class="text-muted" style="margin-bottom: 0.5rem;">ID</p>
                <p><strong>#<?php echo $skill['id']; ?></strong></p>
            </div>
            <div>
                <p class="text-muted" style="margin-bottom: 0.5rem;">Fecha de Creación</p>
                <p><?php echo date('d/m/Y H:i', strtotime($skill['created_at'])); ?></p>
            </div>
            <div>
                <p class="text-muted" style="margin-bottom: 0.5rem;">Categoría Actual</p>
                <p><strong><?php echo ucfirst($skill['category']); ?></strong></p>
            </div>
            <div>
                <p class="text-muted" style="margin-bottom: 0.5rem;">Nivel Actual</p>
                <p><strong><?php echo ucfirst($skill['level']); ?></strong></p>
            </div>
        </div>
    </div>
</div>

<!-- ZONA DE PELIGRO -->
<div class="table-container danger-zone" style="margin-top: 2rem;">
    <div class="table-header">
        <h2>⚠️ Zona de Peligro</h2>
    </div>
    <div style="padding: 2rem;">
        <p class="text-muted" style="margin-bottom: 1rem;">
            Esta acción es permanente y no se puede deshacer.
        </p>
        <a href="skills.php?delete=<?php echo $skill['id']; ?>"
            class="btn btn-danger"
            onclick="return confirm('⚠️ ¿Estás seguro de eliminar esta skill?\n\nNombre: <?php echo addslashes($skill['name']); ?>\n\nEsta acción no se puede deshacer.')">
            🗑️ Eliminar Skill
        </a>
    </div>
</div>

<style>
    .danger-zone {
        border: 2px solid #dc3545;
    }

    .danger-zone .table-header {
        background: rgba(220, 53, 69, 0.1);
        color: #dc3545;
    }
</style>

<?php include 'includes/footer.php'; ?>