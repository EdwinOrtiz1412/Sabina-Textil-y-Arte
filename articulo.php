<?php
// Incluir archivo de configuración de la base de datos
include 'config.php';

// Consulta para obtener los artículos
$sql = "SELECT a.idarticulo, a.codigo, a.nombre, a.precio_venta, a.descripcion, a.modelo, c.nombre as categoria, i.imagen
        FROM articulo a
        JOIN categoria c ON a.idcategoria = c.idcategoria
        JOIN img i ON a.id_imagen = i.Id_imagen";
$resultado = $conn->query($sql);

if (!$resultado) {
    die("Error en la consulta: " . $conn->error);
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
    <h1>Lista de Artículos</h1>
    

     <!-- Botón para agregar una nueva categoría -->
     <button onclick="window.location.href='agregar_articulo.php'">
        <img src="Icons/agregar.png" alt="Agregar" style="width:20px; height:20px; vertical-align:middle;"> Agregar Nuevo Articulo
    </button>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Código</th>
                <th>Nombre</th>
                <th>Precio de Venta</th>
                <th>Descripción</th>
                <th>Modelo</th>
                <th>Categoría</th>
                <th>Imagen</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($resultado->num_rows > 0) {
                while ($fila = $resultado->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $fila['idarticulo'] . "</td>";
                    echo "<td>" . $fila['codigo'] . "</td>";
                    echo "<td>" . $fila['nombre'] . "</td>";
                    echo "<td>" . $fila['precio_venta'] . "</td>";
                    echo "<td>" . $fila['descripcion'] . "</td>";
                    echo "<td>" . $fila['modelo'] . "</td>";
                    echo "<td>" . $fila['categoria'] . "</td>";
                    // Mostrar la imagen
                    echo "<td><img src='data:image/jpeg;base64," . base64_encode($fila['imagen']) . "' alt='Imagen' style='width:50px; height:50px;'></td>";
                    echo "<td>";
                    echo "<button onclick=\"window.location.href='editar_articulo.php?id=" . $fila['idarticulo'] . "'\">Editar</button>";

                    echo "<button onclick=\"confirmarEliminacion(" . $fila['idarticulo'] . ")\">Eliminar</button>";
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='9'>No hay artículos disponibles</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <script>
        function confirmarEliminacion(id) {
            if (confirm("¿Estás seguro de que deseas eliminar este artículo?")) {
                window.location.href = "eliminar_articulo.php?id=" + id;
            }
        }
    </script>
</body>
<footer>
        <p>&copy; 2024 Sabina Textil y Arte</p>
    </footer>
</html>

<?php
// Cerrar la conexión
$conn->close();
?>
