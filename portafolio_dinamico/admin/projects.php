<?php
require_once 'auth.php';
require_once '../config/database.php';

$conn = getConnection();

// Obtener todos los proyectos
$projects_query = "SELECT * FROM projects ORDER BY order_position ASC, created_at DESC";
$projects_result = $conn->query($projects_query);

closeConnection($conn);

$page_title = 'Proyectos';
include 'includes/header.php';
?>

<div class="admin-header">
    <div>
        <h1>📁 Gestión de Proyectos</h1>
        <p class="text-muted">Administra todos tus proyectos del portafolio</p>
    </div>
    <div class="admin-header-actions">
        <a href="project_new.php" class="btn btn-primary">
            ➕ Nuevo Proyecto
        </a>
    </div>
</div>

<?php if (isset($_GET['success'])): ?>
    <div class="alert alert-success">
        ✅ <?php
            if ($_GET['success'] === 'created') echo 'Proyecto creado exitosamente';
            if ($_GET['success'] === 'updated') echo 'Proyecto actualizado exitosamente';
            if ($_GET['success'] === 'deleted') echo 'Proyecto eliminado exitosamente';
            ?>
    </div>
<?php endif; ?>

<!-- PROJECTS TABLE -->
<div class="table-container">
    <div class="table-header">
        <h2>Todos los Proyectos (<?php echo $projects_result->num_rows; ?>)</h2>
    </div>
    <table>
        <thead>
            <tr>
                <th>Orden</th>
                <th>Proyecto</th>
                <th>Tecnologías</th>
                <th>Estado</th>
                <th>Destacado</th>
                <th>Fecha</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($projects_result->num_rows > 0): ?>
                <?php while ($project = $projects_result->fetch_assoc()): ?>
                    <?php $technologies = json_decode($project['technologies'], true) ?? []; ?>
                    <tr>
                        <td>
                            <strong>#<?php echo $project['order_position']; ?></strong>
                        </td>
                        <td>
                            <strong><?php echo htmlspecialchars($project['title']); ?></strong><br>
                            <span class="text-muted" style="font-size: 0.85rem;">
                                <?php echo htmlspecialchars(substr($project['short_description'] ?? '', 0, 50)); ?>...
                            </span>
                        </td>
                        <td>
                            <?php if (!empty($technologies)): ?>
                                <?php foreach (array_slice($technologies, 0, 3) as $tech): ?>
                                    <span class="badge badge-info" style="margin: 2px;">
                                        <?php echo htmlspecialchars($tech); ?>
                                    </span>
                                <?php endforeach; ?>
                                <?php if (count($technologies) > 3): ?>
                                    <span class="text-muted">+<?php echo count($technologies) - 3; ?></span>
                                <?php endif; ?>
                            <?php else: ?>
                                <span class="text-muted">-</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php
                            $badge_class = 'badge-success';
                            if ($project['status'] === 'draft') $badge_class = 'badge-warning';
                            if ($project['status'] === 'archived') $badge_class = 'badge-danger';
                            ?>
                            <span class="badge <?php echo $badge_class; ?>">
                                <?php echo htmlspecialchars($project['status']); ?>
                            </span>
                        </td>
                        <td>
                            <?php if ($project['featured']): ?>
                                <span class="badge badge-success">⭐ Sí</span>
                            <?php else: ?>
                                <span class="text-muted">No</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php
                            $date = new DateTime($project['created_at']);
                            echo $date->format('d/m/Y');
                            ?>
                        </td>
                        <td>
                            <div class="table-actions">
                                <?php if ($project['github_url']): ?>
                                    <a href="<?php echo htmlspecialchars($project['github_url']); ?>"
                                        target="_blank"
                                        class="btn-icon"
                                        title="Ver en GitHub">
                                        🔗
                                    </a>
                                <?php endif; ?>
                                <a href="project_edit.php?id=<?php echo $project['id']; ?>"
                                    class="btn-icon"
                                    title="Editar">
                                    ✏️
                                </a>
                                <a href="project_delete.php?id=<?php echo $project['id']; ?>"
                                    class="btn-icon btn-icon-danger"
                                    title="Eliminar"
                                    onclick="return confirm('¿Estás seguro de eliminar este proyecto?')">
                                    🗑️
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7" class="text-center" style="padding: 3rem;">
                        <p class="text-muted" style="font-size: 1.1rem; margin-bottom: 1rem;">
                            📭 No hay proyectos aún
                        </p>
                        <a href="project_new.php" class="btn btn-primary">
                            Crear tu primer proyecto →
                        </a>
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php include 'includes/footer.php'; ?>