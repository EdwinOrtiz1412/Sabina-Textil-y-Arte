<?php
// Incluir archivo de configuración de la base de datos
include 'config.php';

// Obtener el idcategoria de la URL
$idcategoria = isset($_GET['idcategoria']) ? intval($_GET['idcategoria']) : 0;

// Consulta para obtener los artículos de la categoría seleccionada
$sql_articulos_categoria = "SELECT a.idarticulo, a.nombre, a.precio_venta, i.imagen 
                            FROM articulo a 
                            JOIN img i ON a.id_imagen = i.Id_imagen
                            WHERE a.idcategoria = $idcategoria";

// Función para obtener datos de la base de datos
function obtenerDatos($conn, $sql)
{
    $resultado = $conn->query($sql);
    if (!$resultado) {
        die("Error en la consulta: " . $conn->error);
    }
    return $resultado;
}

// Obtener los datos
$resultado_articulos_categoria = obtenerDatos($conn, $sql_articulos_categoria);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Artículos de Categoría</title>
    <link rel="stylesheet" href="styles1.css"> <!-- CSS global -->
    <link rel="stylesheet" href="categorias.css"> <!-- CSS para categorías -->
</head>

<body>
    <header>
        <h1>Artículos en Categoría</h1>
        <nav>
            <ul>
                <li><a href="index.php">Inicio</a></li>
                <li><a href="logout.php">Cerrar sesión</a></li>
            </ul>
        </nav>
    </header>

    <div>
        <section class="articulos">
            <h2>Artículos Disponibles</h2>
            <div class="articulos-container">
                <?php
                if ($resultado_articulos_categoria->num_rows > 0) {
                    while ($fila = $resultado_articulos_categoria->fetch_assoc()) {
                        $idarticulo = htmlspecialchars($fila['idarticulo']);
                        $nombre_articulo = htmlspecialchars($fila['nombre']);
                        $precio_venta = htmlspecialchars($fila['precio_venta']);
                        $imagen_articulo = base64_encode($fila['imagen']);

                        echo "<a href='seleccion_articulo.php?idarticulo=$idarticulo' class='articulo-boton'>";
                        echo "<img src='data:image/jpeg;base64,$imagen_articulo' alt='Imagen' class='articulo-imagen'>";
                        echo "<div class='articulo-info'>";
                        echo "<h3>$nombre_articulo</h3>";
                        echo "<p>Precio: $$precio_venta</p>";
                        echo "</div>";
                        echo "</a>";
                    }
                } else {
                    echo "<p>No hay artículos disponibles en esta categoría.</p>";
                }
                ?>
            </div>
        </section>
    </div>

</body>
</html>

<?php
// Cerrar la conexión
$conn->close();
?>
