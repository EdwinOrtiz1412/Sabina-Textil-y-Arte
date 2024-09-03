<?php
session_start();
include 'config.php'; // Incluir el archivo de conexión a la base de datos

// Obtener los datos del formulario
$nombreUsuario = $_POST['username'];
$password = $_POST['password'];

// Prepara la consulta SQL
$sql = "SELECT * FROM usuario WHERE nombreUsuario = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $nombreUsuario);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // El usuario existe, ahora verificamos la contraseña
    $user = $result->fetch_assoc();
    
    // Verificar si la contraseña es correcta
    if (password_verify($password, $user['password'])) {
        // La contraseña es correcta, iniciar sesión
        $_SESSION['nombreUsuario'] = $user['nombreUsuario'];
        $_SESSION['idrol'] = $user['idrol'];
        
        // Redirigir según el rol del usuario
        if ($user['idrol'] == 2) {
            // Redirigir a la página de administrador
            header("Location: admin_dashboard.php");
        } elseif ($user['idrol'] == 1) {
            // Redirigir a la página de usuario estándar
            header("Location: user_dashboard.php");
        } else {
            // Manejar otros roles si es necesario
            echo "Rol no reconocido.";
        }
        exit();
    } else {
        // Contraseña incorrecta
        echo "Contraseña incorrecta.";
    }
} else {
    // El usuario no existe
    echo "No existe una cuenta con ese nombre de usuario.";
}

$stmt->close();
$conn->close();
?>
