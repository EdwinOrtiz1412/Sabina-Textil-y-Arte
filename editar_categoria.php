<?php
// Incluir archivo de configuración de la base de datos
include 'config.php';

// Verificar si se ha recibido el ID de la categoría
if (isset($_GET['id'])) {
    $idcategoria = $_GET['id'];

    // Preparar la consulta para obtener los datos actuales de la categoría
    $stmt = $conn->prepare("SELECT nombre, descripcion, idmaterial, id_imagen FROM categoria WHERE idcategoria = ?");
    $stmt->bind_param("i", $idcategoria);
    $stmt->execute();
    $stmt->bind_result($nombre, $descripcion, $idmaterial, $id_imagen);
    $stmt->fetch();
    $stmt->close();

    // Verificar si el formulario ha sido enviado para actualizar los datos
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $nombre = $_POST['nombre'];
        $descripcion = $_POST['descripcion'];
        $idmaterial = $_POST['idmaterial'];

        // Verificar si se subió una nueva imagen
        if ($_FILES['imagen']['name']) {
            $nombre_imagen = $_FILES['imagen']['name'];
            $tipo_imagen = $_FILES['imagen']['type'];
            $imagen = file_get_contents($_FILES['imagen']['tmp_name']);
            $nuevaImagen = "uploads/" . $nombre_imagen;

            // Insertar la nueva imagen en la tabla img
            $stmt = $conn->prepare("INSERT INTO img (nombre, imagen, Tipo, nuevaImagen) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("sbss", $nombre_imagen, $imagen, $tipo_imagen, $nuevaImagen);
            $stmt->send_long_data(1, $imagen);
            $stmt->execute();
            $id_imagen = $stmt->insert_id;
            $stmt->close();
        }

        // Preparar la consulta para actualizar los datos de la categoría
        $stmt = $conn->prepare("UPDATE categoria SET nombre = ?, descripcion = ?, idmaterial = ?, id_imagen = ? WHERE idcategoria = ?");
        $stmt->bind_param("ssiii", $nombre, $descripcion, $idmaterial, $id_imagen, $idcategoria);

        if ($stmt->execute()) {
            // Redirigir a la página de categorías después de actualizar
            header("Location: categoria.php");
            exit(); // Asegura que el script se detiene aquí
        } else {
            echo "Error al actualizar la categoría: " . $stmt->error;
        }

        $stmt->close();
    }
} else {
    echo "No se ha especificado una categoría para editar.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Categoría</title>
    <link rel="stylesheet" href="styles1.css">
</head>
<header>
        <h1>Sabina Textil y Arte</h1>
        <nav class="sidebar">
            <ul>
                <li><a href="admin_dashboard.php">Inicio</a></li>
                <li><a href="logout.php">Cerrar sesión</a></li>
            </ul>
        </nav>
    </header>
<body>

    <h1>Editar Categoría</h1>

    <form action="editar_categoria.php?id=<?php echo $idcategoria; ?>" method="POST" enctype="multipart/form-data">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($nombre); ?>" required>

        <label for="descripcion">Descripción:</label>
        <textarea id="descripcion" name="descripcion" required><?php echo htmlspecialchars($descripcion); ?></textarea>

        <label for="idmaterial">Material:</label>
        <input type="number" id="idmaterial" name="idmaterial" value="<?php echo $idmaterial; ?>" required>

        <label for="imagen">Imagen:</label>
        <input type="file" id="imagen" name="imagen">

        <button type="submit">Guardar Cambios</button>
    </form>

</body>
<br><br><br>
<footer>
        <p>&copy; 2024 Sabina Textil y Arte</p>
    </footer>
</html>

<?php
// Cerrar la conexión
$conn->close();
?>
