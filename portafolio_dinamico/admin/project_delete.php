<?php
require_once 'auth.php';
require_once '../config/database.php';

// Obtener ID del proyecto
$project_id = intval($_GET['id'] ?? 0);

if ($project_id === 0) {
    header('Location: projects.php');
    exit;
}

$conn = getConnection();

// Verificar que el proyecto existe
$stmt = $conn->prepare("SELECT title FROM projects WHERE id = ?");
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

// Procesar confirmación de eliminación
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm_delete'])) {
    $delete_stmt = $conn->prepare("DELETE FROM projects WHERE id = ?");
    $delete_stmt->bind_param("i", $project_id);

    if ($delete_stmt->execute()) {
        $delete_stmt->close();
        closeConnection($conn);
        header('Location: projects.php?success=deleted');
        exit;
    } else {
        $error = 'Error al eliminar el proyecto';
        $delete_stmt->close();
    }
}

closeConnection($conn);

$page_title = 'Eliminar Proyecto';
include 'includes/header.php';
?>

<div class="admin-header">
    <div>
        <h1>🗑️ Eliminar Proyecto</h1>
        <p class="text-muted">Esta acción no se puede deshacer</p>
    </div>
    <div class="admin-header-actions">
        <a href="projects.php" class="btn btn-secondary">
            ← Volver
        </a>
    </div>
</div>

<div class="table-container" style="max-width: 600px; margin: 0 auto;">
    <div style="padding: 2rem; text-align: center;">
        <div style="font-size: 4rem; margin-bottom: 1rem;">⚠️</div>

        <h2 style="margin-bottom: 1rem;">¿Estás seguro?</h2>

        <p style="margin-bottom: 2rem; color: var(--admin-text-muted);">
            Estás a punto de eliminar el proyecto:<br>
            <strong style="font-size: 1.2rem;"><?php echo htmlspecialchars($project['title']); ?></strong>
        </p>

        <div class="alert alert-warning" style="text-align: left;">
            <strong>⚠️ Advertencia:</strong> Esta acción eliminará permanentemente:
            <ul style="margin-top: 0.5rem; padding-left: 1.5rem;">
                <li>Toda la información del proyecto</li>
                <li>Las tecnologías asociadas</li>
                <li>Los enlaces a GitHub y demo</li>
            </ul>
            <p style="margin-top: 0.5rem; margin-bottom: 0;">
                <strong>Esta acción no se puede deshacer.</strong>
            </p>
        </div>

        <form method="POST" action="" style="margin-top: 2rem;">
            <input type="hidden" name="confirm_delete" value="1">

            <div class="flex gap-2" style="justify-content: center;">
                <a href="projects.php" class="btn btn-secondary">
                    ← Cancelar
                </a>
                <button type="submit" class="btn btn-danger">
                    🗑️ Sí, Eliminar Proyecto
                </button>
            </div>
        </form>
    </div>
</div>

<?php include 'includes/footer.php'; ?>