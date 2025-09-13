<?php
$conexion = new mysqli("localhost", "root", "", "almacen");

if (isset($_GET['id']) && isset($_GET['tipo'])) {
    $id = intval($_GET['id']);
    $tipo = $_GET['tipo']; 

    if ($tipo === 'marca') {
        $campo = 'imagenmarca';
    } elseif ($tipo === 'articulo') {
        $campo = 'imagenarticulo';
    } else {
        exit('Tipo de imagen inválido');
    }

    $stmt = $conexion->prepare("SELECT $campo FROM registroalmacen WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($imagen);
        $stmt->fetch();

        header("Content-Type: image/jpeg"); // En caso de utilizar otro formato cambiar
        echo $imagen;
    }

    $stmt->close();
}
$conexion->close();
?>
