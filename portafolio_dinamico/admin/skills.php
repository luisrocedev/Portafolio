<?php
require_once 'auth.php';
require_once '../config/database.php';

$conn = getConnection();

// Obtener todas las skills agrupadas por categoría
$skills_query = "SELECT * FROM skills ORDER BY category, order_position ASC";
$skills_result = $conn->query($skills_query);

// Agrupar por categoría
$skills_by_category = [];
while ($skill = $skills_result->fetch_assoc()) {
    $skills_by_category[$skill['category']][] = $skill;
}

// Procesar formulario de nueva skill
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_skill'])) {
    $name = trim($_POST['name'] ?? '');
    $category = $_POST['category'] ?? 'other';
    $level = $_POST['level'] ?? 'intermedio';
    $order_position = intval($_POST['order_position'] ?? 0);

    if (!empty($name)) {
        $stmt = $conn->prepare("
            INSERT INTO skills (name, category, level, order_position)
            VALUES (?, ?, ?, ?)
        ");
        $stmt->bind_param("sssi", $name, $category, $level, $order_position);
        $stmt->execute();
        $stmt->close();

        header('Location: skills.php?success=created');
        exit;
    }
}

// Procesar eliminación
if (isset($_GET['delete'])) {
    $skill_id = intval($_GET['delete']);
    $delete_stmt = $conn->prepare("DELETE FROM skills WHERE id = ?");
    $delete_stmt->bind_param("i", $skill_id);
    $delete_stmt->execute();
    $delete_stmt->close();

    header('Location: skills.php?success=deleted');
    exit;
}

closeConnection($conn);

$page_title = 'Skills';
include 'includes/header.php';

$categories = [
    'frontend' => ['name' => 'Frontend', 'icon' => '🎨'],
    'backend' => ['name' => 'Backend', 'icon' => '⚙️'],
    'database' => ['name' => 'Database', 'icon' => '💾'],
    'tools' => ['name' => 'Tools', 'icon' => '🔧'],
    'other' => ['name' => 'Other', 'icon' => '📦']
];
?>

<div class="admin-header">
    <div>
        <h1>🛠️ Gestión de Skills</h1>
        <p class="text-muted">Administra tus habilidades técnicas</p>
    </div>
</div>

<?php if (isset($_GET['success'])): ?>
    <div class="alert alert-success">
        ✅ <?php
            if ($_GET['success'] === 'created') echo 'Skill añadida exitosamente';
            if ($_GET['success'] === 'deleted') echo 'Skill eliminada exitosamente';
            ?>
    </div>
<?php endif; ?>

<!-- FORMULARIO NUEVA SKILL -->
<div class="table-container" style="margin-bottom: 2rem;">
    <div class="table-header">
        <h2>➕ Añadir Nueva Skill</h2>
    </div>
    <form method="POST" action="" style="padding: 2rem;">
        <div style="display: grid; grid-template-columns: 2fr 1fr 1fr 1fr auto; gap: 1rem; align-items: end;">
            <div class="form-group" style="margin-bottom: 0;">
                <label for="name">Nombre de la Skill</label>
                <input
                    type="text"
                    id="name"
                    name="name"
                    placeholder="Ej: JavaScript"
                    required>
            </div>

            <div class="form-group" style="margin-bottom: 0;">
                <label for="category">Categoría</label>
                <select id="category" name="category">
                    <option value="frontend">Frontend</option>
                    <option value="backend">Backend</option>
                    <option value="database">Database</option>
                    <option value="tools">Tools</option>
                    <option value="other">Other</option>
                </select>
            </div>

            <div class="form-group" style="margin-bottom: 0;">
                <label for="level">Nivel</label>
                <select id="level" name="level">
                    <option value="básico">Básico</option>
                    <option value="intermedio" selected>Intermedio</option>
                    <option value="avanzado">Avanzado</option>
                    <option value="experto">Experto</option>
                </select>
            </div>

            <div class="form-group" style="margin-bottom: 0;">
                <label for="order_position">Orden</label>
                <input
                    type="number"
                    id="order_position"
                    name="order_position"
                    value="0"
                    min="0"
                    style="width: 80px;">
            </div>

            <button type="submit" name="add_skill" class="btn btn-primary">
                ➕ Añadir
            </button>
        </div>
    </form>
</div>

<!-- SKILLS POR CATEGORÍA -->
<?php foreach ($categories as $cat_key => $cat_info): ?>
    <?php if (isset($skills_by_category[$cat_key]) && count($skills_by_category[$cat_key]) > 0): ?>
        <div class="table-container" style="margin-bottom: 2rem;">
            <div class="table-header">
                <h2><?php echo $cat_info['icon']; ?> <?php echo $cat_info['name']; ?></h2>
                <span class="badge badge-info">
                    <?php echo count($skills_by_category[$cat_key]); ?> skills
                </span>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>Orden</th>
                        <th>Nombre</th>
                        <th>Nivel</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($skills_by_category[$cat_key] as $skill): ?>
                        <tr>
                            <td><strong>#<?php echo $skill['order_position']; ?></strong></td>
                            <td>
                                <strong><?php echo htmlspecialchars($skill['name']); ?></strong>
                            </td>
                            <td>
                                <?php
                                $level_badges = [
                                    'básico' => 'badge-warning',
                                    'intermedio' => 'badge-info',
                                    'avanzado' => 'badge-success',
                                    'experto' => 'badge-success'
                                ];
                                $badge_class = $level_badges[$skill['level']] ?? 'badge-info';
                                ?>
                                <span class="badge <?php echo $badge_class; ?>">
                                    <?php echo htmlspecialchars(ucfirst($skill['level'])); ?>
                                </span>
                            </td>
                            <td>
                                <div class="table-actions">
                                    <a href="skill_edit.php?id=<?php echo $skill['id']; ?>"
                                        class="btn-icon"
                                        title="Editar">
                                        ✏️
                                    </a>
                                    <a href="skills.php?delete=<?php echo $skill['id']; ?>"
                                        class="btn-icon btn-icon-danger"
                                        title="Eliminar"
                                        onclick="return confirm('¿Eliminar esta skill?')">
                                        🗑️
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
<?php endforeach; ?>

<!-- CATEGORÍAS VACÍAS -->
<?php
$empty_categories = array_diff_key($categories, $skills_by_category);
if (!empty($empty_categories)):
?>
    <div class="table-container">
        <div class="table-header">
            <h2>📋 Categorías Vacías</h2>
        </div>
        <div style="padding: 2rem;">
            <p class="text-muted">Estas categorías no tienen skills todavía:</p>
            <div style="display: flex; gap: 0.5rem; margin-top: 1rem; flex-wrap: wrap;">
                <?php foreach ($empty_categories as $cat_key => $cat_info): ?>
                    <span class="badge badge-warning">
                        <?php echo $cat_info['icon']; ?> <?php echo $cat_info['name']; ?>
                    </span>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php include 'includes/footer.php'; ?>