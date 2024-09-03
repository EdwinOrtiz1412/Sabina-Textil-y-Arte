<?php
session_start();

// Verificar si el usuario está autenticado y es estándar
if (!isset($_SESSION['nombreUsuario']) || $_SESSION['idrol'] != 1) {
    header("Location: login.php"); // Redirige al login si no está autenticado o no es usuario estándar
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Usuario</title>
    <link rel="stylesheet" href="styles1.css">
</head>
<body>
    <header>
        <h1>Bienvenido a Sabina Textil y Arte</h1>
        <nav>
            <ul>
                <li><a href="user_dashboard.php">Inicio</a></li>
                <li><a href="logout.php">Cerrar sesión</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <h2>Panel de Control</h2>
        <p>Este es el panel de usuario. Aquí puedes ver tus detalles, actualizar tu perfil, y más.</p>
    </main>
    <footer>
        <p>&copy; 2024 Sabina Textil y Arte</p>
    </footer>
</body>
</html>
