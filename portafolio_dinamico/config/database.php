<?php

/**
 * Configuración de Base de Datos
 * 
 * Para desarrollo local (MAMP):
 * - Host: localhost
 * - Usuario: root
 * - Password: root
 * - Puerto: 8889 (MAMP por defecto)
 * 
 * Para producción:
 * - Cambia estos valores por los de tu hosting
 */

// Configuración de base de datos
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', 'root');
define('DB_NAME', 'portafolio_db');
define('DB_PORT', '8889'); // Puerto MAMP por defecto

// Configuración del sitio
define('SITE_URL', 'http://localhost:8888/GitHub/Portafolio/portafolio_dinamico');
define('SITE_NAME', 'Luis Rodriguez | Portfolio');

// Configuración de seguridad
define('ADMIN_SESSION_NAME', 'portfolio_admin_session');
define('SESSION_LIFETIME', 3600); // 1 hora en segundos

// Crear conexión
function getConnection()
{
    try {
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);

        if ($conn->connect_error) {
            throw new Exception("Error de conexión: " . $conn->connect_error);
        }

        // Establecer charset UTF-8
        $conn->set_charset("utf8mb4");

        return $conn;
    } catch (Exception $e) {
        die("Error al conectar con la base de datos: " . $e->getMessage());
    }
}

// Función para cerrar conexión
function closeConnection($conn)
{
    if ($conn) {
        $conn->close();
    }
}
