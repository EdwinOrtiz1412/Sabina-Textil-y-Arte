<?php
// Incluir archivo de configuración de la base de datos
include 'config.php';

// Obtener el ID del artículo desde la URL
$idarticulo = $_GET['id'];

// Consultar para asegurar que el artículo existe
$sql = "SELECT idarticulo FROM articulo WHERE idarticulo = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $idarticulo);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("Artículo no encontrado.");
}

// Eliminar el artículo
$sql = "DELETE FROM articulo WHERE idarticulo = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $idarticulo);

if ($stmt->execute()) {
    header("Location: articulo.php"); // Redirige a la lista de artículos
    exit();
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
