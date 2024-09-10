<?php
// Incluir archivo de configuración de la base de datos
include 'config.php';

// Manejar la lógica para guardar las existencias
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['idarticulo'])) {
    $idarticulo = intval($_POST['idarticulo']);
    $conn->begin_transaction(); // Iniciar transacción

    try {
        foreach ($_POST['existencias'] as $id_talla => $cantidad) {
            $id_talla = intval($id_talla);
            $cantidad = intval($cantidad);

            // Consulta para obtener la existencia actual
            $sql_existencia_actual = "SELECT existencia FROM existencia 
                                      WHERE id_articulo = ? AND id_talla = ?";
            $stmt_existencia = $conn->prepare($sql_existencia_actual);
            $stmt_existencia->bind_param("ii", $idarticulo, $id_talla);
            $stmt_existencia->execute();
            $resultado_existencia_actual = $stmt_existencia->get_result();

            if ($resultado_existencia_actual->num_rows > 0) {
                // Existencia actual
                $fila_existencia = $resultado_existencia_actual->fetch_assoc();
                $existencia_actual = intval($fila_existencia['existencia']);
                $nueva_existencia = $existencia_actual + $cantidad;
                
                // Actualizar existencias sumando la nueva cantidad
                $sql_update = "UPDATE existencia 
                               SET existencia = ? 
                               WHERE id_articulo = ? AND id_talla = ?";
                $stmt_update = $conn->prepare($sql_update);
                $stmt_update->bind_param("iii", $nueva_existencia, $idarticulo, $id_talla);
                $stmt_update->execute();
            } else {
                // Insertar nueva existencia si no existe
                $sql_insert = "INSERT INTO existencia (id_articulo, id_talla, existencia)
                               VALUES (?, ?, ?)";
                $stmt_insert = $conn->prepare($sql_insert);
                $stmt_insert->bind_param("iii", $idarticulo, $id_talla, $cantidad);
                $stmt_insert->execute();
            }
        }

        $conn->commit(); // Confirmar transacción
        echo "<p>Existencias del artículo $idarticulo actualizadas correctamente.</p>";
    } catch (Exception $e) {
        $conn->rollback(); // Revertir transacción en caso de error
        echo "<p>Error al actualizar existencias: " . $e->getMessage() . "</p>";
    }
}

// Consulta para obtener los artículos
$sql_articulos = "SELECT idarticulo, nombre, id_imagen FROM articulo";
$resultado_articulos = $conn->query($sql_articulos);

if (!$resultado_articulos) {
    die("Error en la consulta: " . $conn->error);
}

// Consulta para obtener las tallas
$sql_tallas = "SELECT idtalla, nombre FROM talla";
$resultado_tallas = $conn->query($sql_tallas);
$tallas = [];
while ($fila_talla = $resultado_tallas->fetch_assoc()) {
    $tallas[$fila_talla['idtalla']] = $fila_talla['nombre'];
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Existencias de Artículos</title>
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
    <table>
        <thead>
            <tr>
                <th>ID Artículo</th>
                <th>Nombre</th>
                <th>Imagen</th>
                <?php foreach ($tallas as $talla): ?>
                    <th><?php echo htmlspecialchars($talla); ?></th>
                <?php endforeach; ?>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($resultado_articulos->num_rows > 0) : ?>
                <?php while ($fila = $resultado_articulos->fetch_assoc()) : ?>
                    <tr>
                        <td><?php echo $fila['idarticulo']; ?></td>
                        <td><?php echo htmlspecialchars($fila['nombre']); ?></td>
                        <td>
                            <?php
                            // Consulta para obtener la imagen
                            $sql_imagen = "SELECT imagen FROM img WHERE Id_imagen = ?";
                            $stmt_imagen = $conn->prepare($sql_imagen);
                            $stmt_imagen->bind_param("i", $fila['id_imagen']);
                            $stmt_imagen->execute();
                            $resultado_imagen = $stmt_imagen->get_result();
                            if ($resultado_imagen && $resultado_imagen->num_rows > 0) {
                                $imagen = $resultado_imagen->fetch_assoc()['imagen'];
                                echo '<img src="data:image/jpeg;base64,' . base64_encode($imagen) . '" alt="Imagen del Artículo" style="width: 100px; height: 100px;">';
                            } else {
                                echo "No hay imagen disponible.";
                            }
                            ?>
                        </td>

                        <!-- Crear un formulario por artículo -->
                        <form action="existencia.php" method="POST">
                            <input type="hidden" name="idarticulo" value="<?php echo $fila['idarticulo']; ?>">

                            <?php foreach ($tallas as $idtalla => $talla): ?>
                                <td>
                                    <input type="number" name="existencias[<?php echo $idtalla; ?>]" min="0" placeholder="Cantidad">
                                </td>
                            <?php endforeach; ?>

                            <!-- Botón para guardar existencias de este artículo -->
                            <td>
                                <button type="submit" class="guardar-btn">Guardar</button>
                            </td>
                        </form>
                    </tr>
                <?php endwhile; ?>
            <?php else : ?>
                <tr>
                    <td colspan="<?php echo count($tallas) + 4; ?>">No hay artículos disponibles.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>



</body><br><br><br><br><br>
<footer>
    <p>&copy; 2024 Sabina Textil y Arte</p>
</footer>
</html>

<?php
// Cerrar la conexión después de todo el código PHP
$conn->close();
?>
