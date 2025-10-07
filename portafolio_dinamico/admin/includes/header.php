<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title ?? 'Admin'; ?> | Portfolio Admin</title>
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>

<body>
    <div class="admin-layout">
        <!-- SIDEBAR -->
        <aside class="admin-sidebar">
            <div class="admin-logo">
                <h2>⚡ Portfolio</h2>
                <p>Panel de Administración</p>
            </div>

            <ul class="admin-nav">
                <li>
                    <a href="dashboard.php" class="<?php echo ($page_title === 'Dashboard') ? 'active' : ''; ?>">
                        <span class="icon">📊</span>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="projects.php" class="<?php echo ($page_title === 'Proyectos') ? 'active' : ''; ?>">
                        <span class="icon">📁</span>
                        <span>Proyectos</span>
                    </a>
                </li>
                <li>
                    <a href="skills.php" class="<?php echo ($page_title === 'Skills') ? 'active' : ''; ?>">
                        <span class="icon">🛠️</span>
                        <span>Skills</span>
                    </a>
                </li>
                <li>
                    <a href="profile.php" class="<?php echo ($page_title === 'Perfil') ? 'active' : ''; ?>">
                        <span class="icon">👤</span>
                        <span>Mi Perfil</span>
                    </a>
                </li>
                <li>
                    <a href="change_password.php" class="<?php echo ($page_title === 'Cambiar Contraseña') ? 'active' : ''; ?>">
                        <span class="icon">🔐</span>
                        <span>Cambiar Contraseña</span>
                    </a>
                </li>
                <li style="margin-top: 2rem; border-top: 1px solid var(--admin-border); padding-top: 1rem;">
                    <a href="../index.php" target="_blank">
                        <span class="icon">🌐</span>
                        <span>Ver Portafolio</span>
                    </a>
                </li>
                <li>
                    <a href="logout.php" onclick="return confirm('¿Cerrar sesión?')">
                        <span class="icon">🚪</span>
                        <span>Cerrar Sesión</span>
                    </a>
                </li>
            </ul>

            <div style="padding: 1.5rem; margin-top: 2rem; border-top: 1px solid var(--admin-border);">
                <p class="text-muted" style="font-size: 0.8rem; text-align: center;">
                    Logueado como:<br>
                    <strong><?php echo htmlspecialchars($admin_username); ?></strong>
                </p>
            </div>
        </aside>

        <!-- MAIN CONTENT -->
        <main class="admin-main">