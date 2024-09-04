<?php
// Incluir archivo de configuración de la base de datos
include 'config.php';

// Consultar categorías para el menú desplegable
$categoria_query = "SELECT idcategoria, nombre FROM categoria";
$categoria_result = $conn->query($categoria_query);

// Procesar el formulario cuando se envíe
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idcategoria = $_POST['idcategoria'];
    $codigo = $_POST['codigo'];
    $nombre = $_POST['nombre'];
    $precio_venta = $_POST['precio_venta'];
    $descripcion = $_POST['descripcion'];
    $modelo = $_POST['modelo'];

    // Procesar la imagen cargada
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == UPLOAD_ERR_OK) {
        $imagen_tmp_name = $_FILES['imagen']['tmp_name'];
        $imagen_name = $_FILES['imagen']['name'];
        $imagen_type = $_FILES['imagen']['type'];
        $imagen_data = file_get_contents($imagen_tmp_name);

        // Subir la imagen a la base de datos
        $sql_img = "INSERT INTO img (nombre, imagen, Tipo, nuevaImagen) VALUES (?, ?, ?, ?)";
        if ($stmt_img = $conn->prepare($sql_img)) {
            $nueva_imagen = $imagen_name; // Puedes cambiar esto si necesitas un nombre de imagen único
            $stmt_img->bind_param("ssss", $imagen_name, $imagen_data, $imagen_type, $nueva_imagen);
            if ($stmt_img->execute()) {
                $id_imagen = $conn->insert_id; // Obtener el ID de la imagen insertada
            } else {
                echo "Error al guardar la imagen: " . $stmt_img->error;
                $id_imagen = null;
            }
            $stmt_img->close();
        }
    } else {
        $id_imagen = $_POST['id_imagen']; // Usar la imagen seleccionada si no se subió una nueva
    }

    // Insertar el artículo en la base de datos
    if ($id_imagen) {
        $sql_art = "INSERT INTO articulo (idcategoria, codigo, nombre, precio_venta, descripcion, modelo, id_imagen)
                    VALUES (?, ?, ?, ?, ?, ?, ?)";
        if ($stmt_art = $conn->prepare($sql_art)) {
            $stmt_art->bind_param("issdssi", $idcategoria, $codigo, $nombre, $precio_venta, $descripcion, $modelo, $id_imagen);
            if ($stmt_art->execute()) {
                header("Location: articulo.php"); // Redirige a la lista de artículos
                exit();
            } else {
                echo "Error: " . $stmt_art->error;
            }
            $stmt_art->close();
        }
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Artículos</title>
    <link rel="stylesheet" href="styles1.css">
    <link rel="stylesheet" href="styles2.css">
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
    <h1>Agregar Nuevo Artículo</h1>
    <form method="post" action="" enctype="multipart/form-data">
        <label for="idcategoria">Categoría:</label>
        <select name="idcategoria" id="idcategoria" required>
            <?php
            if ($categoria_result->num_rows > 0) {
                while ($row = $categoria_result->fetch_assoc()) {
                    echo "<option value='" . $row['idcategoria'] . "'>" . $row['nombre'] . "</option>";
                }
            }
            ?>
        </select>

        <label for="codigo">Código:</label>
        <input type="text" name="codigo" id="codigo" required>

        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" id="nombre" required>

        <label for="precio_venta">Precio de Venta:</label>
        <input type="number" name="precio_venta" id="precio_venta" step="0.01" required>

        <label for="descripcion">Descripción:</label>
        <textarea name="descripcion" id="descripcion" required></textarea>

        <label for="modelo">Modelo:</label>
        <input type="text" name="modelo" id="modelo" required>

        <label for="imagen">Imagen:</label>
        <input type="file" name="imagen" id="imagen" accept="image/*">

        <label for="id_imagen">Imagen Existente:</label>
        <select name="id_imagen" id="id_imagen">
            <option value="">Seleccionar Imagen</option>
            <?php
            if ($imagen_result->num_rows > 0) {
                while ($row = $imagen_result->fetch_assoc()) {
                    echo "<option value='" . $row['Id_imagen'] . "'>" . $row['nombre'] . "</option>";
                }
            }
            ?>
        </select>

        <button type="submit">Agregar Artículo</button>
    </form>
</body>
<br><br><br>
<footer>
    <p>&copy; 2024 Sabina Textil y Arte</p>
</footer>
</html>
