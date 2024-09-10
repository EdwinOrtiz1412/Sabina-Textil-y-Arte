<?php
// Incluir archivo de configuración de la base de datos
include 'config.php';

// Configuración de paginación
$limit = 10; // Número de artículos por página
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($page - 1) * $limit;

// Variables de búsqueda y filtro
$search = isset($_GET['search']) ? '%' . $conn->real_escape_string($_GET['search']) . '%' : '%';

// Consulta para obtener los artículos, sus existencias y tallas con paginación y búsqueda
$sql_count = "
    SELECT COUNT(DISTINCT a.idarticulo) AS total
    FROM articulo a
    LEFT JOIN existencia e ON a.idarticulo = e.id_articulo
    WHERE a.nombre LIKE '$search'
";
$result_count = $conn->query($sql_count);
$total_articles = $result_count->fetch_assoc()['total'];
$total_pages = ceil($total_articles / $limit);

$sql_inventario = "
    SELECT a.idarticulo, a.nombre, i.imagen, t.nombre AS talla, t.letra, COALESCE(SUM(e.existencia), 0) AS existencia
    FROM articulo a
    LEFT JOIN img i ON a.id_imagen = i.Id_imagen
    LEFT JOIN existencia e ON a.idarticulo = e.id_articulo
    LEFT JOIN talla t ON e.id_talla = t.idtalla
    WHERE a.nombre LIKE '$search'
    GROUP BY a.idarticulo, a.nombre, i.imagen, t.nombre, t.letra
    ORDER BY a.nombre ASC
    LIMIT $limit OFFSET $offset
";

try {
    $resultado_inventario = $conn->query($sql_inventario);

    if (!$resultado_inventario) {
        throw new Exception("Error en la consulta: " . $conn->error);
    }
} catch (Exception $e) {
    echo "<p>Se ha producido un error: " . htmlspecialchars($e->getMessage()) . "</p>";
    exit();
}

// Cerrar la conexión después de todo el código PHP
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventario de Artículos</title>
    <link rel="stylesheet" href="styles1.css"> <!-- CSS global -->
    <link rel="stylesheet" href="styles2.css"> <!-- CSS específico para inventario -->
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
    <h2>Inventario de Artículos</h2>
    
    <!-- Barra de búsqueda -->
    <div class="search-bar">
        <form method="GET" action="inventario.php">
            <input type="text" name="search" value="<?php echo htmlspecialchars($_GET['search'] ?? ''); ?>" placeholder="Buscar artículos...">
            <button type="submit">Buscar</button>
        </form>
    </div>

    <table class="table-inventario">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Imagen</th>
                <th>Talla</th>
                <th>Existencias</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($resultado_inventario->num_rows > 0) : ?>
                <?php while ($fila = $resultado_inventario->fetch_assoc()) : ?>
                    <tr>
                        <td data-label="Nombre"><?php echo htmlspecialchars($fila['nombre']); ?></td>
                        <td data-label="Imagen">
                            <?php if ($fila['imagen']): ?>
                                <img src="data:image/jpeg;base64,<?php echo base64_encode($fila['imagen']); ?>" alt="Imagen del Artículo">
                            <?php else: ?>
                                No disponible
                            <?php endif; ?>
                        </td>
                        <td data-label="Talla"><?php echo htmlspecialchars($fila['talla']) . " (" . htmlspecialchars($fila['letra']) . ")"; ?></td>
                        <td data-label="Existencias"><?php echo intval($fila['existencia']); ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else : ?>
                <tr>
                    <td colspan="4">No hay artículos disponibles en el inventario.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- Paginación -->
    <div class="pagination">
        <?php if ($page > 1): ?>
            <a href="?search=<?php echo urlencode($_GET['search'] ?? ''); ?>&page=<?php echo $page - 1; ?>">&laquo; Anterior</a>
        <?php endif; ?>
        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
            <span>
                <?php if ($i == $page): ?>
                    <?php echo $i; ?>
                <?php else: ?>
                    <a href="?search=<?php echo urlencode($_GET['search'] ?? ''); ?>&page=<?php echo $i; ?>"><?php echo $i; ?></a>
                <?php endif; ?>
            </span>
        <?php endfor; ?>
        <?php if ($page < $total_pages): ?>
            <a href="?search=<?php echo urlencode($_GET['search'] ?? ''); ?>&page=<?php echo $page + 1; ?>">Siguiente &raquo;</a>
        <?php endif; ?>
    </div><br><br>
</div>


</body><br><br><br><br><br>
<footer>
    <p>&copy; 2024 Sabina Textil y Arte</p>
</footer>

</html>
