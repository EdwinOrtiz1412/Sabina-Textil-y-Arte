<?php
// Incluir archivo de configuración de la base de datos
include 'config.php';

// Función para obtener datos de la base de datos
function obtenerDatos($conn, $sql)
{
    $resultado = $conn->query($sql);
    if (!$resultado) {
        die("Error en la consulta: " . $conn->error);
    }
    return $resultado;
}

// Consulta para obtener las categorías y sus imágenes, incluyendo el idcategoria
$sql_categorias = "SELECT c.idcategoria, c.nombre, c.descripcion, i.imagen 
                   FROM categoria c 
                   JOIN img i ON c.id_imagen = i.Id_imagen";

// Consulta para obtener los artículos y sus imágenes, con un límite de 12 artículos
$sql_articulos = "SELECT a.idarticulo, a.nombre, a.precio_venta, i.imagen 
                  FROM articulo a 
                  JOIN img i ON a.id_imagen = i.Id_imagen
                  LIMIT 12";

// Consulta para obtener recomendaciones aleatorias
$sql_recomendaciones = "SELECT a.idarticulo, a.nombre, a.precio_venta, i.imagen 
                        FROM articulo a 
                        JOIN img i ON a.id_imagen = i.Id_imagen
                        ORDER BY RAND() 
                        LIMIT 6"; // Ajusta el número de recomendaciones

// Consulta para obtener los artículos más recientes (los últimos 4)
$sql_nuevos = "SELECT a.idarticulo, a.nombre, a.precio_venta, i.imagen 
               FROM articulo a 
               JOIN img i ON a.id_imagen = i.Id_imagen
               ORDER BY a.idarticulo DESC 
               LIMIT 4"; // Muestra los últimos 4 artículos

// Obtener los datos
$resultado_categorias = obtenerDatos($conn, $sql_categorias);
$resultado_articulos = obtenerDatos($conn, $sql_articulos);
$resultado_recomendaciones = obtenerDatos($conn, $sql_recomendaciones);
$resultado_nuevos = obtenerDatos($conn, $sql_nuevos);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sabina Textil y Arte</title>
    <link rel="stylesheet" href="styles1.css"> <!-- CSS global -->
    <link rel="stylesheet" href="categorias.css"> <!-- CSS para categorías -->
    <link rel="stylesheet" href="articulos.css"> <!-- CSS para artículos y recomendaciones -->
</head>

<body>
    <header>
        <h1>Sabina Textil y Arte</h1>
        <nav>
            <ul>
                <li><a href="index.php">Inicio</a></li>
               <!-- <li><a href="logout.php">Cerrar sesión</a></li> -->
            </ul>
        </nav>
    </header>

    <div>
        <h2>Categorías disponibles</h2>
        <div class="categorias">
            <?php
            if ($resultado_categorias->num_rows > 0) {
                while ($fila = $resultado_categorias->fetch_assoc()) {
                    // Asegúrate de que 'idcategoria' está definido en el array
                    $idcategoria = htmlspecialchars($fila['idcategoria']);
                    $nombre_categoria = htmlspecialchars($fila['nombre']);
                    $imagen_categoria = base64_encode($fila['imagen']);

                    echo "<a href='categoria_user.php?idcategoria=$idcategoria' class='categoria-boton'>";
                    echo "<img src='data:image/jpeg;base64,$imagen_categoria' alt='Imagen de categoría'>";
                    echo "<h3>$nombre_categoria</h3>";
                    echo "</a>";
                }
            } else {
                echo "<p>No hay categorías disponibles</p>";
            }
            ?>
        </div>

        <!-- Sección de artículos nuevos -->
        <section class="nuevos">
            <h2>Artículos Nuevos</h2>
            <div class="nuevos-container">
                <?php
                if ($resultado_nuevos->num_rows > 0) {
                    while ($fila = $resultado_nuevos->fetch_assoc()) {
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
                    echo "<p>No hay artículos nuevos disponibles.</p>";
                }
                ?>
            </div>
        </section>

        <!-- Sección para artículos -->
        <section class="articulos">
            <h2>Artículos Disponibles</h2>
            <div class="articulos-container">
                <?php
                if ($resultado_articulos->num_rows > 0) {
                    while ($fila = $resultado_articulos->fetch_assoc()) {
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
                    echo "<p>No hay artículos disponibles.</p>";
                }
                ?>
            </div>
        </section>

        <!-- Sección de recomendaciones -->
        <section class="recomendaciones">
            <h2>Recomendaciones</h2>
            <div class="recomendaciones-container">
                <?php
                if ($resultado_recomendaciones->num_rows > 0) {
                    while ($fila = $resultado_recomendaciones->fetch_assoc()) {
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
                    echo "<p>No hay recomendaciones disponibles.</p>";
                }
                ?>
            </div>
        </section>
    </div>

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