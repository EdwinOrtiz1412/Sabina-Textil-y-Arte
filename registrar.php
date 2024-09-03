<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario</title>
    <link rel="stylesheet" href="styles1.css"> 
</head>
<body>
    <header>
        <h1>Registro de Usuario</h1>
    </header>
    <main>
        <form action="procesar_registro.php" method="post">
            <label for="nombreUsuario">Nombre de Usuario:</label>
            <input type="text" id="nombreUsuario" name="nombreUsuario" required>

            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password" required>

            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" required>

            <label for="apellidoMat">Primer Apellido :</label>
            <input type="text" id="apellidoMat" name="apellidoMat" required>

            <label for="apellidoPat">Segundo Apellido :</label>
            <input type="text" id="apellidoPat" name="apellidoPat" required>

            <label for="telefono">Teléfono:</label>
            <input type="text" id="telefono" name="telefono" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <input type="submit" value="Registrarse">
        </form>
    </main>
    <footer>
        <p>&copy; 2024 Sabina Textil y Arte</p>
    </footer>
</body>
</html>
