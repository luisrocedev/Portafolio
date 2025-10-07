<?php

/**
 * Panel Admin - Login
 * Sistema de autenticación seguro
 */

session_start();

// Si ya está logueado, redirigir al dashboard
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header('Location: dashboard.php');
    exit;
}

require_once '../config/database.php';

$error = '';
$success = '';

// Procesar login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($password)) {
        $error = 'Por favor, completa todos los campos.';
    } else {
        $conn = getConnection();

        // Buscar usuario
        $stmt = $conn->prepare("SELECT id, username, password, email FROM admin_users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();

            // Verificar contraseña
            if (password_verify($password, $user['password'])) {
                // Login exitoso
                $_SESSION['admin_logged_in'] = true;
                $_SESSION['admin_id'] = $user['id'];
                $_SESSION['admin_username'] = $user['username'];
                $_SESSION['admin_email'] = $user['email'];

                // Actualizar último login
                $update_stmt = $conn->prepare("UPDATE admin_users SET last_login = NOW() WHERE id = ?");
                $update_stmt->bind_param("i", $user['id']);
                $update_stmt->execute();
                $update_stmt->close();

                $stmt->close();
                closeConnection($conn);

                header('Location: dashboard.php');
                exit;
            } else {
                $error = 'Credenciales incorrectas.';
            }
        } else {
            $error = 'Credenciales incorrectas.';
        }

        $stmt->close();
        closeConnection($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | Portfolio</title>
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>

<body class="login-page">
    <div class="login-container">
        <div class="login-box">
            <div class="login-header">
                <h1>🔐 Admin Panel</h1>
                <p>Inicia sesión para gestionar tu portafolio</p>
            </div>

            <?php if ($error): ?>
                <div class="alert alert-error">
                    ⚠️ <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>

            <?php if ($success): ?>
                <div class="alert alert-success">
                    ✅ <?php echo htmlspecialchars($success); ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="" class="login-form">
                <div class="form-group">
                    <label for="username">Usuario</label>
                    <input
                        type="text"
                        id="username"
                        name="username"
                        placeholder="admin"
                        required
                        autofocus
                        value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>">
                </div>

                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="••••••••"
                        required>
                </div>

                <button type="submit" class="btn btn-primary btn-block">
                    Iniciar Sesión →
                </button>
            </form>

            <div class="login-footer">
                <p>
                    <a href="../index.php">← Volver al portafolio</a>
                </p>
                <p class="text-muted">
                    Credenciales por defecto: <code>admin</code> / <code>admin123</code>
                </p>
            </div>
        </div>
    </div>

    <script>
        // Efecto de typing en el título
        const title = document.querySelector('.login-header h1');
        const text = title.textContent;
        title.textContent = '';
        let i = 0;

        function typeWriter() {
            if (i < text.length) {
                title.textContent += text.charAt(i);
                i++;
                setTimeout(typeWriter, 100);
            }
        }

        setTimeout(typeWriter, 300);
    </script>
</body>

</html>