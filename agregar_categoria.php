<?php
// Incluir archivo de configuración de la base de datos
include 'config.php';

// Obtener los materiales disponibles para el campo idmaterial
$sql_materiales = "SELECT idmaterial, nombre FROM material";
$resultado_materiales = $conn->query($sql_materiales);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener los datos del formulario
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $idmaterial = $_POST['idmaterial'];

    // Manejar la carga de la imagen
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == UPLOAD_ERR_OK) {
        $nombre_imagen = $_FILES['imagen']['name'];
        $tipo_imagen = $_FILES['imagen']['type'];
        $imagen_blob = file_get_contents($_FILES['imagen']['tmp_name']);
        
        // Preparar y ejecutar la consulta de inserción en la tabla img
        $sql_imagen = "INSERT INTO img (nombre, imagen, Tipo, nuevaImagen) VALUES (?, ?, ?, ?)";
        $stmt_imagen = $conn->prepare($sql_imagen);
        $stmt_imagen->bind_param("bsss", $nombre_imagen, $imagen_blob, $tipo_imagen, $nombre_imagen);

        if ($stmt_imagen->execute()) {
            // Obtener el Id_imagen insertado
            $id_imagen = $stmt_imagen->insert_id;
            
            // Preparar y ejecutar la consulta de inserción en la tabla categoria
            $sql_categoria = "INSERT INTO categoria (nombre, descripcion, idmaterial, id_imagen) VALUES (?, ?, ?, ?)";
            $stmt_categoria = $conn->prepare($sql_categoria);
            $stmt_categoria->bind_param("ssii", $nombre, $descripcion, $idmaterial, $id_imagen);

            if ($stmt_categoria->execute()) {
                echo "Categoría agregada exitosamente.";
                // Redirigir a la página principal de categorías
                header("Location: categoria.php");
                exit();
            } else {
                echo "Error al agregar la categoría: " . $conn->error;
            }
            $stmt_categoria->close();
        } else {
            echo "Error al agregar la imagen: " . $conn->error;
        }
        $stmt_imagen->close();
    } else {
        echo "Error al cargar la imagen.";
    }

    // Cerrar la conexión
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Nueva Categoría</title>
    <link rel="stylesheet" href="styles1.css"> 
    <link rel="stylesheet" href="styles2.css"> 
</head>
<header>
        <h1>Sabina Textil Y Arte </h1>
        <nav class="sidebar">
            <ul>
                <li><a href="admin_dashboard.php">Inicio</a></li>
                <li><a href="logout.php">Cerrar sesión</a></li>
            </ul>
        </nav>
    </header>
<body>

    <h1>Agregar Nueva Categoría</h1>

    <form action="agregar_categoria.php" method="POST" enctype="multipart/form-data">
        <label for="nombre">Nombre de la Categoría:</label>
        <input type="text" id="nombre" name="nombre" required>

        <label for="descripcion">Descripción:</label>
        <textarea id="descripcion" name="descripcion" required></textarea>

        <label for="idmaterial">Material:</label>
        <select id="idmaterial" name="idmaterial" required>
            <option value="" disabled selected>Selecciona un material</option>
            <?php
            if ($resultado_materiales->num_rows > 0) {
                while($fila_material = $resultado_materiales->fetch_assoc()) {
                    echo "<option value='" . $fila_material['idmaterial'] . "'>" . $fila_material['nombre'] . "</option>";
                }
            } else {
                echo "<option value='' disabled>No hay materiales disponibles</option>";
            }
            ?>
        </select>

        <label for="imagen">Imagen:</label>
        <input type="file" id="imagen" name="imagen" accept="image/*" required>

        <button type="submit">Agregar Categoría</button>
        <button type="button" onclick="window.location.href='categoria.php'">Cancelar</button>
    </form>

</body>
<footer>
        <p>&copy; 2024 Sabina Textil y Arte</p>
    </footer>
</html>
