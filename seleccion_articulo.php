<?php
// Incluir archivo de configuración de la base de datos
include 'config.php';

// Obtener el ID del artículo desde la URL
if (isset($_GET['idarticulo'])) {
    $idarticulo = intval($_GET['idarticulo']);

    // Consulta para obtener los detalles del artículo
    $sql_articulo = "SELECT a.nombre, a.precio_venta, i.imagen 
                     FROM articulo a 
                     JOIN img i ON a.id_imagen = i.Id_imagen 
                     WHERE a.idarticulo = $idarticulo";

    $resultado_articulo = $conn->query($sql_articulo);

    if (!$resultado_articulo) {
        die("Error en la consulta: " . $conn->error);
    }

    if ($resultado_articulo->num_rows > 0) {
        $fila = $resultado_articulo->fetch_assoc();
        $nombre_articulo = htmlspecialchars($fila['nombre']);
        $precio_venta = htmlspecialchars($fila['precio_venta']);
        $imagen_articulo = base64_encode($fila['imagen']);
    } else {
        $nombre_articulo = "Artículo no encontrado";
        $precio_venta = "";
        $imagen_articulo = "";
    }

    // Consulta para obtener las existencias por talla
    $sql_existencias = "SELECT t.idtalla, t.nombre AS talla, e.existencia
                        FROM talla t
                        LEFT JOIN existencia e ON t.idtalla = e.id_talla AND e.id_articulo = $idarticulo";
    $resultado_existencias = $conn->query($sql_existencias);
    $tallas = [];
    while ($fila_talla = $resultado_existencias->fetch_assoc()) {
        $tallas[] = $fila_talla;
    }
} else {
    die("ID de artículo no proporcionado.");
}

// Cerrar la conexión
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del Artículo</title>
    <link rel="stylesheet" href="styles1.css"> <!-- CSS global -->
    <link rel="stylesheet" href="details.css"> <!-- CSS específico para detalles -->
</head>

<body>
<header>
    <h1>Sabina Textil y Arte</h1>
    <nav class="sidebar">
        <ul>
            <li><a href="index.php">Inicio</a></li>
           <!-- <li><a href="logout.php">Cerrar sesión</a></li> -->
        </ul>
    </nav>
</header>

    <div>
        <h2 class="titulo_articulo"><?php echo $nombre_articulo; ?></h2>
        <section class="detalle-articulo">
            <?php if ($imagen_articulo): ?>
                <img src="data:image/jpeg;base64,<?php echo $imagen_articulo; ?>" alt="Imagen del Artículo" class="articulo-imagen">
            <?php endif; ?>
            <p>Precio: $<?php echo $precio_venta; ?></p>
            
            <div class="tallas">
                <?php foreach ($tallas as $talla): ?>
                    <button class="talla-btn <?php echo $talla['existencia'] > 0 ? 'disponible' : 'no-disponible'; ?>" 
                            data-talla="<?php echo $talla['idtalla']; ?>"
                            <?php echo $talla['existencia'] > 0 ? '' : 'disabled'; ?>>
                        <?php echo htmlspecialchars($talla['talla']); ?> 
                        <?php echo $talla['existencia'] > 0 ? '(' . $talla['existencia'] . ' disponibles)' : '(No disponible)'; ?>
                    </button>
                <?php endforeach; ?>
            </div>

            <form action="comprar.php" method="POST">
                <input type="hidden" name="idarticulo" value="<?php echo $idarticulo; ?>">
                <input type="hidden" id="tallaSeleccionada" name="idtalla" value="">
                <button type="submit" class="comprar-btn" disabled id="comprarBtn">Comprar</button>
            </form>
        </section>
    </div>

    <footer>
        <p>&copy; 2024 Sabina Textil y Arte</p>
    </footer>

    <script>
        // Script para manejar la selección de talla
        document.querySelectorAll('.talla-btn').forEach(button => {
            button.addEventListener('click', () => {
                // Verificar si el botón está habilitado
                if (!button.disabled) {
                    // Eliminar clase de selección de los demás botones
                    document.querySelectorAll('.talla-btn').forEach(btn => btn.classList.remove('seleccionado'));

                    // Añadir clase de selección al botón clicado
                    button.classList.add('seleccionado');
                    
                    // Actualizar el campo oculto con el ID de la talla seleccionada
                    document.getElementById('tallaSeleccionada').value = button.getAttribute('data-talla');
                    
                    // Habilitar el botón de compra
                    document.getElementById('comprarBtn').disabled = false;
                }
            });
        });
    </script>
</body>

</html>
