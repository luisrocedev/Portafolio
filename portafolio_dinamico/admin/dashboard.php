<?php
require_once 'auth.php';
require_once '../config/database.php';

$conn = getConnection();

// Obtener estadísticas
$stats_query = "SELECT * FROM stats";
$stats_result = $conn->query($stats_query);
$stats = $stats_result->fetch_assoc();

// Proyectos recientes
$recent_projects_query = "SELECT id, title, status, created_at FROM projects ORDER BY created_at DESC LIMIT 5";
$recent_projects = $conn->query($recent_projects_query);

// Obtener información del perfil
$profile_query = "SELECT * FROM profile LIMIT 1";
$profile_result = $conn->query($profile_query);
$profile = $profile_result->fetch_assoc();

closeConnection($conn);

$page_title = 'Dashboard';
include 'includes/header.php';
?>

<div class="admin-header">
    <div>
        <h1>👋 Bienvenido, <?php echo htmlspecialchars($admin_username); ?>!</h1>
        <p class="text-muted">Aquí tienes un resumen de tu portafolio</p>
    </div>
    <div class="admin-header-actions">
        <a href="../index.php" target="_blank" class="btn btn-secondary">
            🌐 Ver Portafolio
        </a>
    </div>
</div>

<!-- STATS CARDS -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-card-header">
            <span class="stat-card-title">Total Proyectos</span>
            <span class="stat-card-icon">📁</span>
        </div>
        <div class="stat-card-value"><?php echo $stats['total_projects']; ?></div>
        <div class="stat-card-label">Proyectos en total</div>
    </div>

    <div class="stat-card">
        <div class="stat-card-header">
            <span class="stat-card-title">Destacados</span>
            <span class="stat-card-icon">⭐</span>
        </div>
        <div class="stat-card-value"><?php echo $stats['featured_projects']; ?></div>
        <div class="stat-card-label">Proyectos destacados</div>
    </div>

    <div class="stat-card">
        <div class="stat-card-header">
            <span class="stat-card-title">Skills</span>
            <span class="stat-card-icon">🛠️</span>
        </div>
        <div class="stat-card-value"><?php echo $stats['total_skills']; ?></div>
        <div class="stat-card-label">Habilidades registradas</div>
    </div>

    <div class="stat-card">
        <div class="stat-card-header">
            <span class="stat-card-title">Perfil</span>
            <span class="stat-card-icon">👤</span>
        </div>
        <div class="stat-card-value">✓</div>
        <div class="stat-card-label">Información completa</div>
    </div>
</div>

<!-- RECENT PROJECTS TABLE -->
<div class="table-container">
    <div class="table-header">
        <h2>📋 Proyectos Recientes</h2>
        <a href="projects.php" class="btn btn-primary btn-sm">
            Ver Todos →
        </a>
    </div>
    <table>
        <thead>
            <tr>
                <th>Proyecto</th>
                <th>Estado</th>
                <th>Fecha de Creación</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($recent_projects->num_rows > 0): ?>
                <?php while ($project = $recent_projects->fetch_assoc()): ?>
                    <tr>
                        <td>
                            <strong><?php echo htmlspecialchars($project['title']); ?></strong>
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
                            <?php
                            $date = new DateTime($project['created_at']);
                            echo $date->format('d/m/Y H:i');
                            ?>
                        </td>
                        <td>
                            <div class="table-actions">
                                <a href="project_edit.php?id=<?php echo $project['id']; ?>" class="btn-icon" title="Editar">
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
                    <td colspan="4" class="text-center">
                        <p class="text-muted">No hay proyectos aún. <a href="project_new.php">Crea uno nuevo</a></p>
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- QUICK INFO -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-card-header">
            <span class="stat-card-title">Información del Perfil</span>
            <span class="stat-card-icon">👤</span>
        </div>
        <p><strong>Nombre:</strong> <?php echo htmlspecialchars($profile['name']); ?></p>
        <p><strong>Título:</strong> <?php echo htmlspecialchars($profile['title']); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($profile['email']); ?></p>
        <div class="mt-2">
            <a href="profile.php" class="btn btn-secondary btn-sm">Editar Perfil →</a>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-card-header">
            <span class="stat-card-title">Acciones Rápidas</span>
            <span class="stat-card-icon">⚡</span>
        </div>
        <div class="flex gap-2" style="flex-direction: column;">
            <a href="project_new.php" class="btn btn-primary btn-sm">➕ Nuevo Proyecto</a>
            <a href="skills.php" class="btn btn-secondary btn-sm">🛠️ Gestionar Skills</a>
            <a href="profile.php" class="btn btn-secondary btn-sm">👤 Editar Perfil</a>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-card-header">
            <span class="stat-card-title">Último Acceso</span>
            <span class="stat-card-icon">🕐</span>
        </div>
        <p class="text-muted">
            <?php
            if (isset($_SESSION['last_activity'])) {
                $last = new DateTime();
                $last->setTimestamp($_SESSION['last_activity']);
                echo $last->format('d/m/Y H:i:s');
            }
            ?>
        </p>
        <div class="mt-2">
            <a href="logout.php" class="btn btn-danger btn-sm">🚪 Cerrar Sesión</a>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>