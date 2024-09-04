<?php
// Incluir archivo de configuración de la base de datos
include 'config.php';

// Consulta para obtener las categorías, incluyendo la descripción
$sql = "SELECT idcategoria, nombre, descripcion FROM categoria";
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
    <title>Categorías</title>
    <link rel="stylesheet" href="styles1.css">
    <link rel="stylesheet" href="styles2.css">

    <script>
        function confirmarEliminacion(id) {
            if (confirm("¿Estás seguro de que deseas eliminar esta categoría?")) {
                window.location.href = "eliminar_categoria.php?id=" + id;
            }
        }
    </script>
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

    <!-- Botón para agregar una nueva categoría -->
    <button onclick="window.location.href='agregar_categoria.php'">
        <img src="Icons/agregar.png" alt="Agregar" style="width:20px; height:20px; vertical-align:middle;"> Agregar Nueva Categoría
    </button>
    <!-- Tabla de categorías -->
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($resultado->num_rows > 0) {
                while($fila = $resultado->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $fila['idcategoria'] . "</td>";
                    echo "<td>" . $fila['nombre'] . "</td>";
                    echo "<td>" . $fila['descripcion'] . "</td>";
                    echo "<td>";
                    echo "<button onclick=\"window.location.href='editar_categoria.php?id=" . $fila['idcategoria'] . "'\">";
                    echo "<img src='Icons/editar.png' alt='Editar' style='width:20px; height:20px; vertical-align:middle;'>Editar </button> ";
                    echo "<button onclick=\"confirmarEliminacion(" . $fila['idcategoria'] . ")\">";
                    echo "<img src='Icons/borrar.png' alt='Eliminar' style='width:20px; height:20px; vertical-align:middle;'> Eliminar</button>";
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>No hay categorías disponibles</td></tr>";
            }
            ?>
        </tbody>
    </table>

</body>
<footer>
    <p>&copy; 2024 Sabina Textil y Arte</p>
</footer>
</html>

<?php
// Cerrar la conexión
$conn->close();
?>
