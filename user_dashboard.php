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
    <link rel="stylesheet" href="menu-lateral.css">
</head>
<body>
    <header>
        <h1> Sabina Textil y Arte</h1>
        <!--<nav>
            <ul>
                <li><a href="user_dashboard.php">Inicio</a></li>
                <li><a href="logout.php">Cerrar sesión</a></li>
            </ul>
        </nav>-->
    </header>

    <div class="menu-lateral">
        <ul>
        
        <li><a class="welcome-link">Bienvenid@: <?php echo $_SESSION['nombreUsuario']; ?></a></li>

            <li><a href="user_dashboard.php"><img src="Icons/inicio.png" alt="Inicio"> Inicio</a></li>
            <li><a href="buscar.php"><img src="Icons/buscar.png" alt="Buscar"> Buscar</a></li>
            <li><a href="compras.php"><img src="Icons/compras .png" alt="Compras"> Compras</a></li>
            <li><a href="mi_cuenta.php"><img src="Icons/usuario.png" alt="Mi Cuenta"> Mi Cuenta</a></li>
            <li><a href="acerca_de.php"><img src="Icons/acerca-de.png" alt="Acerca de"> Acerca de</a></li>
            <li><a href="logout.php"><img src="Icons/salir.png" alt="Cerrar sesion"> Cerrar sesion</a></li>

        </ul>
    </div>

    <main>
        <h2>Panel de Control</h2>
        <p>Este es el panel de usuario. Aquí puedes ver tus detalles, actualizar tu perfil, y más.</p>
    </main>

    <footer>
        <p>&copy; 2024 Sabina Textil y Arte</p>
    </footer>
</body>
</html>
