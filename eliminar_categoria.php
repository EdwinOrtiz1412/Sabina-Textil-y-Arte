<?php
// Incluir archivo de configuración de la base de datos
include 'config.php';

// Verificar si se ha recibido el ID de la categoría
if (isset($_GET['id'])) {
    $idcategoria = $_GET['id'];

    // Preparar la consulta para eliminar la categoría
    $stmt = $conn->prepare("DELETE FROM categoria WHERE idcategoria = ?");
    $stmt->bind_param("i", $idcategoria);

    if ($stmt->execute()) {
        // Redirigir a la página de categorías después de eliminar
        header("Location: categoria.php");
        exit();
    } else {
        echo "Error al eliminar la categoría: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "No se ha especificado una categoría para eliminar.";
}

// Cerrar la conexión
$conn->close();
?>
