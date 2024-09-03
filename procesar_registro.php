<?php
// Incluir archivo de configuración de la base de datos
include 'config.php';

// Verificar que se haya enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener y limpiar datos del formulario
    $nombreUsuario = trim($_POST['nombreUsuario']);
    $password = trim($_POST['password']);
    $nombre = trim($_POST['nombre']);
    $apellidoMat = trim($_POST['apellidoMat']);
    $apellidoPat = trim($_POST['apellidoPat']);
    $telefono = trim($_POST['telefono']);
    $email = trim($_POST['email']);

    // Validar campos (esto es básico; puedes agregar validaciones más estrictas según tus necesidades)
    if (empty($nombreUsuario) || empty($password) || empty($nombre) || empty($apellidoMat) || empty($apellidoPat) || empty($telefono) || empty($email)) {
        die('Por favor, complete todos los campos.');
    }

    // Hashear la contraseña
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Preparar la consulta SQL para insertar el nuevo usuario
    $sql = "INSERT INTO usuario (idrol, nombreUsuario, password, nombre, apellidoMat, apellidoPat, telefono, email, iddireccion, id_imagen) 
            VALUES (1, ?, ?, ?, ?, ?, ?, ?, 1, 1)"; // Rol de cliente (1) y valores de ID de dirección e ID de imagen predeterminados

    // Preparar y ejecutar la consulta
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("sssssss", $nombreUsuario, $hashed_password, $nombre, $apellidoMat, $apellidoPat, $telefono, $email);

        if ($stmt->execute()) {
            echo 'Registro exitoso. <a href="login.php">Inicia sesión</a>.';
        } else {
            echo 'Error al registrar el usuario: ' . $stmt->error;
        }

        $stmt->close();
    } else {
        echo 'Error en la preparación de la consulta: ' . $conn->error;
    }

    // Cerrar la conexión
    $conn->close();
} else {
    // Si el formulario no se ha enviado, redirigir al formulario de registro
    header("Location: registrar.php");
    exit();
}
