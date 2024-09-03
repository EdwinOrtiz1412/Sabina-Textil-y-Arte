<?php
$password = 'administrador'; // Reemplaza esto con la contraseña que quieres hashear
$hashed_password = password_hash($password, PASSWORD_DEFAULT);
echo $hashed_password;
?>
