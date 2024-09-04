<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="carousel">
        <div class="carousel-images">
            <img src="Img/imagen1.jpeg" alt="Imagen 1">
            <img src="Img/imagen2.jpeg" alt="Imagen 2">
            <img src="Img/imagen3.jpeg" alt="Imagen 3">
        </div>
    </div>
    <div class="container">
        <h1>Iniciar Sesión</h1>
        <form action="procesar_login.php" method="POST">
            <div class="input-group">
                <label for="username">Usuario  </label>
                <input type="text" id="username" name="username" required> 
            </div><br>
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

