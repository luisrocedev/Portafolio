<?php

/**
 * Archivo de autenticación
 * Verifica que el usuario esté logueado
 */

session_start();

// Verificar si está logueado
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: index.php');
    exit;
}

// Regenerar ID de sesión por seguridad
if (!isset($_SESSION['session_regenerated'])) {
    session_regenerate_id(true);
    $_SESSION['session_regenerated'] = true;
}

// Verificar timeout de sesión (30 minutos)
$timeout = 1800; // 30 minutos en segundos
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) > $timeout) {
    session_unset();
    session_destroy();
    header('Location: index.php?timeout=1');
    exit;
}

$_SESSION['last_activity'] = time();

// Variables disponibles en todas las páginas admin
$admin_id = $_SESSION['admin_id'];
$admin_username = $_SESSION['admin_username'];
$admin_email = $_SESSION['admin_email'];
