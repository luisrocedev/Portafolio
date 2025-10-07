<?php

/**
 * Configuración de Base de Datos - Sistema Multi-Entorno
 * Detecta automáticamente local vs producción
 */

// Detectar entorno
function isLocalEnvironment()
{
    $local_hosts = ['localhost', '127.0.0.1', '::1', 'localhost:8888'];
    $current_host = $_SERVER['HTTP_HOST'] ?? $_SERVER['SERVER_NAME'] ?? 'localhost';

    foreach ($local_hosts as $host) {
        if (strpos($current_host, $host) !== false) {
            return true;
        }
    }
    return false;
}

// Configuración según entorno
if (isLocalEnvironment()) {
    // ==========================================
    // CONFIGURACIÓN LOCAL (MAMP/XAMPP/WAMP)
    // ==========================================
    define('DB_HOST', 'localhost');
    define('DB_USER', 'root');
    define('DB_PASS', 'root');
    define('DB_NAME', 'portafolio_db');
    define('DB_PORT', 8889); // Puerto MAMP, cambiar si usas otro
    define('DB_CHARSET', 'utf8mb4');

    // Debug mode
    define('DEBUG_MODE', true);
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    // ==========================================
    // CONFIGURACIÓN PRODUCCIÓN
    // ==========================================
    // ⚠️ IMPORTANTE: Actualizar con datos reales del hosting
    define('DB_HOST', 'localhost'); // O IP del servidor MySQL
    define('DB_USER', 'tu_usuario_mysql');
    define('DB_PASS', 'tu_contraseña_segura');
    define('DB_NAME', 'tu_base_de_datos');
    define('DB_PORT', 3306);
    define('DB_CHARSET', 'utf8mb4');

    // Debug mode OFF en producción
    define('DEBUG_MODE', false);
    error_reporting(0);
    ini_set('display_errors', 0);
}

/**
 * Obtener conexión a la base de datos
 * @return mysqli
 */
function getConnection()
{
    try {
        // Crear conexión con puerto específico
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);

        // Verificar conexión
        if ($conn->connect_error) {
            if (DEBUG_MODE) {
                die("❌ Error de conexión: " . $conn->connect_error);
            } else {
                // En producción, no mostrar detalles del error
                die("Error al conectar con la base de datos. Por favor, contacta al administrador.");
            }
        }

        // Establecer charset
        $conn->set_charset(DB_CHARSET);

        return $conn;
    } catch (Exception $e) {
        if (DEBUG_MODE) {
            die("❌ Excepción: " . $e->getMessage());
        } else {
            die("Error de conexión. Por favor, intenta más tarde.");
        }
    }
}

/**
 * Cerrar conexión a la base de datos
 * @param mysqli $conn
 */
function closeConnection($conn)
{
    if ($conn && $conn instanceof mysqli) {
        $conn->close();
    }
}

/**
 * Función auxiliar: Verificar estado de la conexión
 * @return array
 */
function checkDatabaseConnection()
{
    $conn = getConnection();
    $result = [
        'connected' => true,
        'host' => DB_HOST,
        'database' => DB_NAME,
        'charset' => DB_CHARSET,
        'environment' => isLocalEnvironment() ? 'local' : 'production'
    ];
    closeConnection($conn);
    return $result;
}

// Opcional: Configurar zona horaria
date_default_timezone_set('Europe/Madrid'); // Ajusta según tu ubicación

// Opcional: Configurar sesiones seguras en producción
if (!isLocalEnvironment()) {
    ini_set('session.cookie_httponly', 1);
    ini_set('session.cookie_secure', 1); // Solo con HTTPS
    ini_set('session.use_strict_mode', 1);
}
