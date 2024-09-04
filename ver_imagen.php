<?php
// Incluir archivo de configuración de la base de datos
include 'config.php';

// Obtener el ID de la imagen desde la URL
$id_imagen = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id_imagen) {
    // Consulta para obtener la imagen
    $sql = "SELECT imagen FROM img WHERE Id_imagen = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $id_imagen);
        $stmt->execute();
        $stmt->bind_result($imagen);
        if ($stmt->fetch()) {
            // Enviar la imagen al navegador
            header("Content-Type: image/jpeg"); // Ajusta el tipo MIME si es necesario
            echo $imagen;
        } else {
            echo "Imagen no encontrada.";
        }
        $stmt->close();
    }
}

$conn->close();
?>
