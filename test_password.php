<?php
// Configuración de la base de datos
include 'config.php'; // Incluye el archivo de configuración de la base de datos

// Datos de prueba
$nombreUsuario = 'Edwin'; // Cambia esto por un nombre de usuario real que tienes en la base de datos
$plain_password = 'administrador'; // La contraseña en texto plano que quieres probar

// Obtener el hash de la contraseña desde la base de datos
$sql = "SELECT password FROM usuario WHERE nombreUsuario = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $nombreUsuario);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // El usuario existe, obtener el hash de la contraseña
    $user = $result->fetch_assoc();
    $hashed_password = $user['password'];

    // Verificar la contraseña
    if (password_verify($plain_password, $hashed_password)) {
        echo 'La contraseña es válida.';
    } else {
        echo 'La contraseña es incorrecta.';
    }
} else {
    echo 'No existe una cuenta con ese nombre de usuario.';
}

$stmt->close();
$conn->close();
?>
