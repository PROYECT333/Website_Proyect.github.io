<?php
// Conexion de la base de datos (usuario, contraseña, y base de datos)
$host = "localhost";
$user = "root";         
$password = "";         
$database = "almacen";  

// Crear conexión
$conn = new mysqli($host, $user, $password, $database);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Consulta del boton para contar los registros de la tabla registroalmacen
$sql = "SELECT COUNT(*) AS total FROM registroalmacen";
$result = $conn->query($sql);

if ($result) {
    $row = $result->fetch_assoc();
    echo json_encode($row);
} else {
    echo json_encode(["total" => 0]);
}

$conn->close();
?>