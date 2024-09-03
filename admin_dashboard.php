<?php
session_start();

// Verificar si el usuario está autenticado y es administrador
if (!isset($_SESSION['nombreUsuario']) || $_SESSION['idrol'] != 2) {
    header("Location: login.php"); // Redirige al login si no está autenticado o no es administrador
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administrador</title>
    <link rel="stylesheet" href="styles1.css"> 
</head>
<body>
    <header>
        <h1>Bienvenido al Panel de Administrador</h1>
        <nav>
            <ul>
                <li><a href="admin_dashboard.php">Inicio</a></li>
                <li><a href="logout.php">Cerrar sesión</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <h2>Panel de Control</h2>
        <p>Este es el panel de administrador. Aquí puedes gestionar los usuarios, ver informes, y más.</p>
    </main>
    <footer>
        <p>&copy; 2024 Sabina Textil y Arte</p>
    </footer>
</body>
</html>
