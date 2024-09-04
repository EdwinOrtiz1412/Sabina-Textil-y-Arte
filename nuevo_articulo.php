<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Nuevo Artículo</title>
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
    <div class="form-container">
        <h2>Agregar Nuevo Artículo</h2>
        <form action="guardar_articulo.php" method="POST" enctype="multipart/form-data">
            <label for="idcategoria">Categoría:</label>
            <select name="idcategoria" id="idcategoria" required>
                <!-- Aquí se deben llenar las opciones con las categorías disponibles en la base de datos -->
                <option value="1">Categoría 1</option>
                <option value="2">Categoría 2</option>
                <!-- Más categorías... -->
            </select>

            <label for="codigo">Código:</label>
            <input type="text" name="codigo" id="codigo" maxlength="50" required>

            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" id="nombre" maxlength="100" required>

            <label for="precio_venta">Precio de Venta:</label>
            <input type="number" step="0.01" name="precio_venta" id="precio_venta" required>

            <label for="descripcion">Descripción:</label>
            <textarea name="descripcion" id="descripcion" maxlength="255" required></textarea>

            <label for="modelo">Modelo:</label>
            <input type="text" name="modelo" id="modelo" maxlength="50" required>

            <label for="id_imagen">Imagen:</label>
            <input type="file" name="id_imagen" id="id_imagen" required>

            <button type="submit">Guardar Artículo</button>
        </form>
    </div>

</body> <br><br><br>
<footer>
        <p>&copy; 2024 Sabina Textil y Arte</p>
    </footer>
</html>
