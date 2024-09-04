<?php
// Incluir archivo de configuración de la base de datos
include 'config.php';

// Procesar el formulario de edición
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idarticulo = $_POST['idarticulo'];
    $idcategoria = $_POST['idcategoria'];
    $codigo = $_POST['codigo'];
    $nombre = $_POST['nombre'];
    $precio_venta = $_POST['precio_venta'];
    $descripcion = $_POST['descripcion'];
    $modelo = $_POST['modelo'];

    // Verificar si se ha cargado una nueva imagen
    $imagen_base64 = null; // Inicializar con valor nulo

    if (isset($_FILES['nueva_imagen']) && $_FILES['nueva_imagen']['error'] == UPLOAD_ERR_OK) {
        $imagen_dato = file_get_contents($_FILES['nueva_imagen']['tmp_name']);
        $imagen_base64 = base64_encode($imagen_dato);
    }

    // Preparar la consulta de actualización
    $sql = "UPDATE articulo SET idcategoria = ?, codigo = ?, nombre = ?, precio_venta = ?, descripcion = ?, modelo = ?";
    
    if ($imagen_base64) {
        $sql .= ", imagen = ?";
    }
    
    $sql .= " WHERE idarticulo = ?";

    if ($stmt = $conn->prepare($sql)) {
        if ($imagen_base64) {
            $stmt->bind_param("issdsssi", $idcategoria, $codigo, $nombre, $precio_venta, $descripcion, $modelo, $imagen_base64, $idarticulo);
        } else {
            $stmt->bind_param("issdssi", $idcategoria, $codigo, $nombre, $precio_venta, $descripcion, $modelo, $idarticulo);
        }

        if ($stmt->execute()) {
            header("Location: articulo.php"); // Redirige a la lista de artículos
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    }

    $conn->close();
}
?>
