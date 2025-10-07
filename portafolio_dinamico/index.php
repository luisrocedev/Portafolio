<?php
require_once 'config/database.php';

// Obtener datos del perfil
$conn = getConnection();
$profile_query = "SELECT * FROM profile LIMIT 1";
$profile_result = $conn->query($profile_query);
$profile = $profile_result->fetch_assoc();

// Obtener proyectos destacados
$projects_query = "SELECT * FROM projects WHERE featured = 1 AND status = 'active' ORDER BY order_position ASC";
$projects_result = $conn->query($projects_query);

// Obtener habilidades agrupadas por categoría
$skills_query = "SELECT * FROM skills ORDER BY category, order_position ASC";
$skills_result = $conn->query($skills_query);
$skills = [];
while ($skill = $skills_result->fetch_assoc()) {
    $skills[$skill['category']][] = $skill;
}

closeConnection($conn);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="<?php echo htmlspecialchars($profile['bio'] ?? ''); ?>" />
    <title><?php echo htmlspecialchars($profile['name'] ?? 'Portfolio'); ?> | <?php echo htmlspecialchars($profile['title'] ?? 'Developer'); ?></title>
    <link rel="stylesheet" href="assets/css/style.css" />
</head>

<body>
    <!-- LOADING SCREEN -->
    <div class="loading-screen">
        <div class="loading-content">
            <h2>C A R G A N D O . . .</h2>
            <div class="loading-bar-container">
                <div class="loading-bar"></div>
            </div>
        </div>
    </div>

    <!-- Background Canvas -->
    <canvas id="bgCanvas"></canvas>

    <!-- NAVBAR -->
    <nav class="navbar">
        <div class="logo"><?php echo htmlspecialchars($profile['name'] ?? 'Portfolio'); ?></div>
        <ul class="nav-menu">
            <li><a href="#home">Home</a></li>
            <li><a href="#projects">Works</a></li>
            <li><a href="#skills">Skills</a></li>
            <li><a href="#about">About</a></li>
            <li><a href="#contact">Contact</a></li>
        </ul>
        <div class="theme-toggle" id="theme-toggle">
            <span>☀</span>
        </div>
    </nav>

    <!-- HERO SECTION -->
    <section class="hero" id="home">
        <div class="hero-content fade-up">
            <span class="hero-label">DISPONIBLE PARA TRABAJAR</span>
            <h1 class="hero-title">
                <?php echo htmlspecialchars($profile['name'] ?? 'Tu Nombre'); ?>,<br />
                <span class="gradient-text"><?php echo htmlspecialchars($profile['title'] ?? 'Developer'); ?></span>
            </h1>
            <p class="hero-description">
                <?php
                $shortBio = substr($profile['bio'] ?? '', 0, 200);
                echo htmlspecialchars($shortBio);
                if (strlen($profile['bio'] ?? '') > 200) echo '...';
                ?>
            </p>
            <div class="hero-cta">
                <a href="#contact" class="btn btn-primary">Contactar →</a>
                <a href="#projects" class="btn btn-secondary">Ver Proyectos</a>
            </div>
        </div>
    </section>

    <!-- PROJECTS SECTION -->
    <section id="projects">
        <div class="section-header fade-up">
            <p class="section-label">(PROYECTOS)</p>
            <h2 class="section-title">Trabajos Seleccionados /</h2>
            <p class="section-subtitle">
                Experiencias digitales cuidadosamente elaboradas que combinan funcionalidad con estética.
            </p>
        </div>

        <div class="projects-grid">
            <?php
            // Reset el puntero del resultado
            $projects_result->data_seek(0);
            while ($project = $projects_result->fetch_assoc()):
                $technologies = json_decode($project['technologies'], true) ?? [];
                $has_video = !empty($project['video_url']);
            ?>
                <div class="project-card fade-up">
                    <?php if ($has_video): ?>
                        <a href="<?php echo htmlspecialchars($project['video_url']); ?>"
                            target="_blank"
                            rel="noopener"
                            class="project-image-link"
                            title="Ver video demo">
                            <div class="project-image" style="background-image: url('<?php echo htmlspecialchars($project['image_url'] ?? 'assets/images/placeholder.svg'); ?>');">
                                <div class="play-overlay">
                                    <span class="play-icon">▶</span>
                                </div>
                            </div>
                        </a>
                    <?php else: ?>
                        <div class="project-image" style="background-image: url('<?php echo htmlspecialchars($project['image_url'] ?? 'assets/images/placeholder.svg'); ?>');">
                        </div>
                    <?php endif; ?>

                    <div class="project-content">
                        <p class="project-category"><?php echo htmlspecialchars($project['short_description'] ?? 'DESARROLLO'); ?></p>
                        <h3 class="project-title"><?php echo htmlspecialchars($project['title']); ?></h3>
                        <p class="project-description"><?php echo htmlspecialchars($project['description']); ?></p>

                        <?php if (!empty($technologies)): ?>
                            <div class="project-tech">
                                <?php foreach (array_slice($technologies, 0, 4) as $tech): ?>
                                    <span class="tech-badge"><?php echo htmlspecialchars($tech); ?></span>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>

                        <div class="project-links">
                            <?php if ($has_video): ?>
                                <a href="<?php echo htmlspecialchars($project['video_url']); ?>" target="_blank" rel="noopener" class="project-link project-link-primary">
                                    🎥 Ver Demo →
                                </a>
                            <?php endif; ?>
                            <?php if ($project['github_url']): ?>
                                <a href="<?php echo htmlspecialchars($project['github_url']); ?>" target="_blank" rel="noopener" class="project-link">
                                    GitHub →
                                </a>
                            <?php endif; ?>
                            <?php if ($project['live_url']): ?>
                                <a href="<?php echo htmlspecialchars($project['live_url']); ?>" target="_blank" rel="noopener" class="project-link">
                                    Ver Live →
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </section>

    <!-- SKILLS SECTION -->
    <section id="skills">
        <div class="section-header fade-up">
            <p class="section-label">(HABILIDADES)</p>
            <h2 class="section-title">Stack Técnico /</h2>
            <p class="section-subtitle">
                Tecnologías y herramientas que utilizo para crear soluciones digitales escalables y mantenibles.
            </p>
        </div>

        <div class="skills-container">
            <?php foreach ($skills as $category => $category_skills): ?>
                <div class="skills-category fade-up">
                    <h3><?php echo ucfirst($category); ?></h3>
                    <div class="skills-grid">
                        <?php foreach ($category_skills as $skill): ?>
                            <div class="skill-item">
                                <span class="skill-name"><?php echo htmlspecialchars($skill['name']); ?></span>
                                <span class="skill-level"><?php echo htmlspecialchars($skill['level']); ?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- ABOUT SECTION -->
    <section id="about">
        <div class="section-header fade-up">
            <p class="section-label">(SOBRE MÍ)</p>
            <h2 class="section-title">Desarrollador / Diseñador / Creador</h2>
        </div>

        <div class="about-content fade-up">
            <p><?php echo nl2br(htmlspecialchars($profile['bio'] ?? '')); ?></p>

            <?php if ($profile['location']): ?>
                <p><strong>📍 Ubicación:</strong> <?php echo htmlspecialchars($profile['location']); ?></p>
            <?php endif; ?>
        </div>
    </section>

    <!-- CONTACT SECTION -->
    <section id="contact">
        <div class="section-header fade-up">
            <p class="section-label">(CONTACTO)</p>
            <h2 class="section-title">Hagámoslo Realidad /</h2>
        </div>

        <div class="contact-content fade-up">
            <p>¿Tienes un proyecto en mente? ¿Quieres colaborar? Hablemos.</p>

            <ul class="contact-list">
                <?php if ($profile['email']): ?>
                    <li>
                        <a href="mailto:<?php echo htmlspecialchars($profile['email']); ?>">
                            ✉️ <?php echo htmlspecialchars($profile['email']); ?>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>

            <div style="margin-top: 3rem;">
                <a href="mailto:<?php echo htmlspecialchars($profile['email'] ?? ''); ?>" class="btn btn-primary">
                    Enviar Mensaje →
                </a>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer>
        <div class="footer-content">
            <p class="footer-text">&copy; <?php echo date('Y'); ?> <?php echo htmlspecialchars($profile['name'] ?? ''); ?>. Todos los derechos reservados.</p>

            <div class="social-links">
                <?php if ($profile['github_url']): ?>
                    <a href="<?php echo htmlspecialchars($profile['github_url']); ?>" target="_blank" rel="noopener" class="social-link" title="GitHub">
                        <span>GH</span>
                    </a>
                <?php endif; ?>
                <?php if ($profile['linkedin_url']): ?>
                    <a href="<?php echo htmlspecialchars($profile['linkedin_url']); ?>" target="_blank" rel="noopener" class="social-link" title="LinkedIn">
                        <span>LI</span>
                    </a>
                <?php endif; ?>
                <?php if ($profile['replit_url']): ?>
                    <a href="<?php echo htmlspecialchars($profile['replit_url']); ?>" target="_blank" rel="noopener" class="social-link" title="Replit">
                        <span>RP</span>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </footer>

    <script src="assets/js/script.js"></script>
</body>

</html>