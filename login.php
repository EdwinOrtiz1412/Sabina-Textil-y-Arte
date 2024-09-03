<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Iniciar Sesión</h1>
        <form action="procesar_login.php" method="POST">
            <div class="input-group">
                <label for="username">Nombre de Usuario</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="input-group">
                <label for="password">Contraseña</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" class="button">Entrar</button>
        </form>
        <p>¿No tienes una cuenta? <br>   <a href="registrar.php">Regístrate aquí</a></p>
    </div>
</body>
</html>

