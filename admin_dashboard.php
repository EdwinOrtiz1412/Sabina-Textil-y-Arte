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
    <link rel="stylesheet" href="styles2.css">
</head>

<body>
    <header>
        <h1>Bienvenido al Panel de Administrador</h1>
        <nav class="sidebar">
            <ul>
                <li><a href="admin_dashboard.php">Inicio</a></li>
                <li><a href="logout.php">Cerrar sesión</a></li>
            </ul>
        </nav>
    </header>

    <?php
    $buttons = [
        ['img' => 'Icons/Articulo.png', 'alt' => 'Artículo', 'label' => 'Artículo', 'link' => 'articulo.php'],
        ['img' => 'Icons/categoria.png', 'alt' => 'Categoría', 'label' => 'Categoría', 'link' => 'categoria.php'],
        ['img' => 'Icons/Envio.png', 'alt' => 'Envíos', 'label' => 'Envíos', 'link' => 'envios.php'],
        ['img' => 'Icons/Ventas.png', 'alt' => 'Ventas', 'label' => 'Ventas', 'link' => 'ventas.php'],
        ['img' => 'Icons/Reporte General.png', 'alt' => 'Reporte General', 'label' => 'Reporte General', 'link' => 'reporte_general.php']
    ];
    ?>

    <div class="button-container">
        <?php foreach ($buttons as $button) : ?>
            <button class="action-button" onclick="window.location.href='<?php echo $button['link']; ?>'">
                <img src="<?php echo $button['img']; ?>" alt="<?php echo $button['alt']; ?>">
                <?php echo $button['label']; ?>
            </button>
        <?php endforeach; ?>
    </div>


    <footer>
        <p>&copy; 2024 Sabina Textil y Arte</p>
    </footer>
</body>

</html>