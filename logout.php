<?php
// Iniciar sesión si no está ya iniciada
session_start();

// Destruir todas las variables de sesión
$_SESSION = array();

// Si se desea destruir la sesión de la cookie, se debe configurar el parámetro de la cookie
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time() - 42000, '/');
}

// Finalmente, destruir la sesión
session_destroy();

// Redirigir al usuario a la página de inicio o de login
header("Location: login.php"); // Cambia 'login.php' a la página de inicio de sesión que estés usando
exit();
?>
