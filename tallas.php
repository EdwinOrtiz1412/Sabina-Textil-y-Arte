<?php
// Incluir archivo de configuración de la base de datos
include 'config.php';

// Manejar la lógica para agregar una nueva talla
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['nombre_talla']) && isset($_POST['letra_talla'])) {
    $nombre_talla = htmlspecialchars($_POST['nombre_talla']);
    $letra_talla = htmlspecialchars($_POST['letra_talla']);

    // Insertar nueva talla
    $sql_insert = "INSERT INTO talla (nombre, letra) VALUES (?, ?)";
    $stmt_insert = $conn->prepare($sql_insert);
    $stmt_insert->bind_param("ss", $nombre_talla, $letra_talla);
    $stmt_insert->execute();

    echo "<p>Talla '$nombre_talla' agregada correctamente.</p>";
}

// Manejar la lógica para eliminar una talla
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id_talla_eliminar'])) {
    $id_talla_eliminar = intval($_POST['id_talla_eliminar']);

    // Eliminar talla
    $sql_delete = "DELETE FROM talla WHERE idtalla = ?";
    $stmt_delete = $conn->prepare($sql_delete);
    $stmt_delete->bind_param("i", $id_talla_eliminar);
    $stmt_delete->execute();

    echo "<p>Talla eliminada correctamente.</p>";
}

// Consulta para obtener las tallas
$sql_tallas = "SELECT idtalla, nombre, letra FROM talla";
$resultado_tallas = $conn->query($sql_tallas);

if (!$resultado_tallas) {
    die("Error en la consulta: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tallas</title>
    <link rel="stylesheet" href="styles1.css">
    <link rel="stylesheet" href="styles2.css">
</head>

<body>
<header>
    <h1>Sabina Textil y Arte</h1>
    <nav class="sidebar">
        <ul>
            <li><a href="admin_dashboard.php">Inicio</a></li>
            <li><a href="logout.php">Cerrar sesión</a></li>
        </ul>
    </nav>
</header>

<div>
    <h2>Lista de Tallas</h2>

    <table class="table-tallas">
    <thead>
        <tr>
            <th>ID</th>
            <th>Letra</th>
            <th>Nombre</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php if ($resultado_tallas->num_rows > 0) : ?>
            <?php while ($fila = $resultado_tallas->fetch_assoc()) : ?>
                <tr>
                    <td data-label="ID"><?php echo $fila['idtalla']; ?></td>
                    <td data-label="Letra"><?php echo htmlspecialchars($fila['letra']); ?></td>
                    <td data-label="Nombre"><?php echo htmlspecialchars($fila['nombre']); ?></td>
                    <td data-label="Acciones">
                        <form action="tallas.php" method="POST" style="display: inline;">
                            <input type="hidden" name="id_talla_eliminar" value="<?php echo $fila['idtalla']; ?>">
                            <button type="submit" onclick="return confirm('¿Estás seguro de que quieres eliminar esta talla?');">Eliminar</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else : ?>
            <tr>
                <td colspan="4">No hay tallas disponibles.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

    <h2>Agregar Nueva Talla</h2>
    <form action="tallas.php" method="POST">
        <label for="nombre_talla">Letra:</label>
        <input type="text" id="nombre_talla" name="nombre_talla" required>

        <label for="letra_talla">Nombre:</label>
        <input type="text" id="letra_talla" name="letra_talla" required>

        <button type="submit">Agregar Talla</button>
    </form>
</div>



</body><br><br><br>
<footer>
    <p>&copy; 2024 Sabina Textil y Arte</p>
</footer>
</html>

<?php
// Cerrar la conexión después de todo el código PHP
$conn->close();
?>
