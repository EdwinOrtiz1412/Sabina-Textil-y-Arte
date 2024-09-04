<?php
// Incluir archivo de configuración de la base de datos
include 'config.php';

// Obtener el ID del artículo desde la URL
$idarticulo = $_GET['id'];

// Consultar datos del artículo
$sql = "SELECT a.idarticulo, a.idcategoria, a.codigo, a.nombre, a.precio_venta, a.descripcion, a.modelo, a.id_imagen, c.nombre as categoria
        FROM articulo a
        JOIN categoria c ON a.idcategoria = c.idcategoria
        WHERE a.idarticulo = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $idarticulo);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("Artículo no encontrado.");
}

$articulo = $result->fetch_assoc();

// Consultar categorías para los menús desplegables
$categoria_query = "SELECT idcategoria, nombre FROM categoria";
$categoria_result = $conn->query($categoria_query);

// Consultar imágenes para el menú desplegable
$imagen_query = "SELECT Id_imagen, nombre FROM img";
$imagen_result = $conn->query($imagen_query);

$stmt->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Artículo</title>
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
    <h1>Editar Artículo</h1>
    <form method="post" action="procesar_editar_articulo.php" enctype="multipart/form-data">
        <input type="hidden" name="idarticulo" value="<?php echo $articulo['idarticulo']; ?>">

        <label for="idcategoria">Categoría:</label>
        <select name="idcategoria" id="idcategoria" required>
            <?php
            if ($categoria_result->num_rows > 0) {
                while ($row = $categoria_result->fetch_assoc()) {
                    $selected = ($row['idcategoria'] == $articulo['idcategoria']) ? 'selected' : '';
                    echo "<option value='" . $row['idcategoria'] . "' $selected>" . $row['nombre'] . "</option>";
                }
            }
            ?>
        </select>

        <label for="codigo">Código:</label>
        <input type="text" name="codigo" id="codigo" value="<?php echo htmlspecialchars($articulo['codigo']); ?>" required>

        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" id="nombre" value="<?php echo htmlspecialchars($articulo['nombre']); ?>" required>

        <label for="precio_venta">Precio de Venta:</label>
        <input type="number" name="precio_venta" id="precio_venta" step="0.01" value="<?php echo htmlspecialchars($articulo['precio_venta']); ?>" required>

        <label for="descripcion">Descripción:</label>
        <textarea name="descripcion" id="descripcion" required><?php echo htmlspecialchars($articulo['descripcion']); ?></textarea>

        <label for="modelo">Modelo:</label>
        <input type="text" name="modelo" id="modelo" value="<?php echo htmlspecialchars($articulo['modelo']); ?>" required>

        <label for="id_imagen">Imagen Actual:</label>
        <?php
        // Mostrar la imagen actual si existe
        if ($articulo['id_imagen']) {
            $imagen_sql = "SELECT imagen FROM img WHERE Id_imagen = ?";
            $imagen_stmt = $conn->prepare($imagen_sql);
            $imagen_stmt->bind_param("i", $articulo['id_imagen']);
            $imagen_stmt->execute();
            $imagen_result = $imagen_stmt->get_result();
            $imagen_data = $imagen_result->fetch_assoc();
            if ($imagen_data) {
                echo "<img src='data:image/jpeg;base64," . base64_encode($imagen_data['imagen']) . "' alt='Imagen Actual' style='width:100px; height:100px;'>";
            } else {
                echo "<p>No hay imagen disponible.</p>";
            }
        } else {
            echo "<p>No hay imagen disponible.</p>";
        }
        ?>

       <!-- <label for="nueva_imagen">Cargar Nueva Imagen:</label>
        <input type="file" name="nueva_imagen" id="nueva_imagen" accept="image/*">
    -->

        <button type="submit">Actualizar Artículo</button>
    </form>
</body><br><br><br>
<footer>
    <p>&copy; 2024 Sabina Textil y Arte</p>
</footer>
</html>

<?php
$conn->close();
?>
