-- ============================================
-- BASE DE DATOS PORTAFOLIO DINÁMICO
-- Autor: Luis Rodriguez
-- Fecha: 3 de octubre de 2025
-- ============================================

-- Crear base de datos
CREATE DATABASE IF NOT EXISTS portafolio_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE portafolio_db;

-- ============================================
-- TABLA: profile (Información personal)
-- ============================================
CREATE TABLE IF NOT EXISTS profile (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    title VARCHAR(255) NOT NULL,
    bio TEXT,
    email VARCHAR(255),
    phone VARCHAR(50),
    location VARCHAR(255),
    github_url VARCHAR(500),
    linkedin_url VARCHAR(500),
    replit_url VARCHAR(500),
    avatar_url VARCHAR(500),
    cv_url VARCHAR(500),
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- TABLA: projects (Proyectos)
-- ============================================
CREATE TABLE IF NOT EXISTS projects (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) UNIQUE NOT NULL,
    description TEXT NOT NULL,
    short_description VARCHAR(500),
    image_url VARCHAR(500),
    technologies JSON,
    github_url VARCHAR(500),
    live_url VARCHAR(500),
    featured BOOLEAN DEFAULT 0,
    order_position INT DEFAULT 0,
    status ENUM('active', 'archived', 'draft') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- TABLA: skills (Habilidades)
-- ============================================
CREATE TABLE IF NOT EXISTS skills (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    category ENUM('frontend', 'backend', 'database', 'tools', 'other') DEFAULT 'other',
    level ENUM('básico', 'intermedio', 'avanzado', 'experto') DEFAULT 'intermedio',
    icon_class VARCHAR(100),
    order_position INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- TABLA: admin_users (Usuarios administradores)
-- ============================================
CREATE TABLE IF NOT EXISTS admin_users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(255),
    last_login TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- INSERTAR DATOS DE EJEMPLO
-- ============================================

-- Insertar perfil
INSERT INTO profile (name, title, bio, email, github_url, linkedin_url, replit_url, location) VALUES (
    'Luis Jahir Rodríguez Cedeño',
    'Full Stack Developer & Designer',
    'Desarrollador en formación con enfoque Full Stack. Actualmente estudio DAM, combinando habilidades de frontend atractivo con lógica backend estructurada. He desarrollado desde portales modulares hasta sistemas de gestión reales como TPVs, PMS hoteleros y microservicios de IA.',
    'luisrocedev@gmail.com',
    'https://github.com/luisrocedev',
    'https://es.linkedin.com/in/luisrocedev',
    'https://replit.com/@luisrocedev',
    'España'
);

-- Insertar proyectos
INSERT INTO projects (title, slug, description, short_description, technologies, github_url, live_url, featured, order_position, status) VALUES
(
    'TaronjaBoxValencia',
    'taronjaboxvalencia',
    'Web dinámica para centro deportivo desarrollada con HTML, CSS y JavaScript. Sistema modular con gestión de clases, horarios y reservas. Diseño responsive y optimizado para dispositivos móviles.',
    'Web dinámica para centro deportivo',
    '["HTML", "CSS", "JavaScript", "PHP"]',
    'https://github.com/luisrocedev/taronjaboxvalencia',
    NULL,
    1,
    1,
    'active'
),
(
    'DarkOrange',
    'darkorange',
    'Panel de control administrativo con sistema de login y CRUDs completos. Gestión modular de usuarios, productos y configuraciones. Interfaz intuitiva con validaciones en tiempo real.',
    'Panel Admin con login y CRUDs',
    '["PHP", "MySQL", "JavaScript", "Bootstrap"]',
    'https://github.com/luisrocedev/darkorange',
    NULL,
    1,
    2,
    'active'
),
(
    'PMS Daniya',
    'pms-daniya',
    'Sistema de gestión hotelera completo (Property Management System). Incluye gestión de reservas, pagos, usuarios y reportes. Arquitectura monolítica robusta con panel administrativo.',
    'Sistema de gestión hotelera completo',
    '["PHP", "MySQL", "JavaScript", "AJAX"]',
    'https://github.com/luisrocedev/PMS-Daniya',
    NULL,
    1,
    3,
    'active'
),
(
    'CRM Sistema',
    'crm',
    'Sistema de gestión de clientes (Customer Relationship Management) diseñado para seguimiento y atención al cliente. Incluye gestión de leads, tickets y historial de interacciones.',
    'Sistema para seguimiento y atención al cliente',
    '["PHP", "MySQL", "JavaScript"]',
    'https://github.com/luisrocedev/CRM',
    NULL,
    1,
    4,
    'active'
),
(
    'TPV Voltereta',
    'tpv-voltereta',
    'Punto de venta para restauración con gestión de caja, pedidos en tiempo real y sistema de chat interno. Interfaz optimizada para uso en tablets y dispositivos táctiles.',
    'Punto de venta con caja, pedidos y chat',
    '["PHP", "MySQL", "JavaScript", "WebSockets"]',
    'https://github.com/luisrocedev/TPV-Voltereta',
    NULL,
    1,
    5,
    'active'
),
(
    'LChat',
    'lchat',
    'Sistema de chat en tiempo real desarrollado con Node.js y WebSockets. Diseño moderno con soporte para salas, notificaciones y emojis. Arquitectura escalable y eficiente.',
    'Chat en tiempo real con diseño moderno',
    '["Node.js", "Express", "Socket.io", "JavaScript"]',
    'https://github.com/luisrocedev/LChat',
    NULL,
    1,
    6,
    'active'
),
(
    'Asistente IA PMS',
    'asistente-ia-pms',
    'Microservicio de inteligencia artificial para hoteles con detección de intenciones. Utiliza procesamiento de lenguaje natural (NLP) con clasificadores Bayesianos para interpretar consultas de usuarios.',
    'Microservicio de IA para hoteles',
    '["Node.js", "Natural", "NLP", "IA"]',
    'https://github.com/luisrocedev/asistente-ia-pms',
    NULL,
    1,
    7,
    'active'
);

-- Insertar habilidades
INSERT INTO skills (name, category, level, order_position) VALUES
-- Frontend
('HTML', 'frontend', 'avanzado', 1),
('CSS', 'frontend', 'avanzado', 2),
('JavaScript', 'frontend', 'avanzado', 3),
('Tailwind CSS', 'frontend', 'intermedio', 4),
('Bootstrap', 'frontend', 'avanzado', 5),

-- Backend
('PHP', 'backend', 'avanzado', 6),
('Node.js', 'backend', 'intermedio', 7),
('Express.js', 'backend', 'intermedio', 8),

-- Database
('MySQL', 'database', 'avanzado', 9),
('JSON', 'database', 'avanzado', 10),

-- Tools
('Git', 'tools', 'avanzado', 11),
('GitHub', 'tools', 'avanzado', 12),
('VS Code', 'tools', 'avanzado', 13),
('MAMP', 'tools', 'avanzado', 14),

-- Other
('NLP', 'other', 'intermedio', 15),
('WebSockets', 'other', 'intermedio', 16),
('REST APIs', 'other', 'intermedio', 17);

-- Insertar usuario admin (password: admin123)
-- IMPORTANTE: Cambiar en producción
INSERT INTO admin_users (username, password, email) VALUES (
    'admin',
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', -- password: admin123
    'luisrocedev@gmail.com'
);

-- ============================================
-- ÍNDICES PARA OPTIMIZACIÓN
-- ============================================
CREATE INDEX idx_projects_featured ON projects(featured);
CREATE INDEX idx_projects_status ON projects(status);
CREATE INDEX idx_projects_slug ON projects(slug);
CREATE INDEX idx_skills_category ON skills(category);

-- ============================================
-- VISTAS ÚTILES
-- ============================================

-- Vista de proyectos destacados activos
CREATE OR REPLACE VIEW featured_projects AS
SELECT * FROM projects 
WHERE featured = 1 AND status = 'active'
ORDER BY order_position ASC;

-- Vista de estadísticas
CREATE OR REPLACE VIEW stats AS
SELECT 
    (SELECT COUNT(*) FROM projects WHERE status = 'active') as total_projects,
    (SELECT COUNT(*) FROM projects WHERE featured = 1 AND status = 'active') as featured_projects,
    (SELECT COUNT(*) FROM skills) as total_skills;

-- ============================================
-- FIN DEL SCRIPT
-- ============================================
