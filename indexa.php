<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Buscar Inventario</title>
      
   
   <style>
  body {
    margin: 0;
    font-family: Arial, sans-serif;
    background-color:  #f2f2f2;
    
  }

  nav {
    background-color: #9B111E;
  }

  nav ul {
    display: flex;
    margin: 0;
    padding: 0;
    list-style: none;
  }

  nav ul li {
    flex: 1;
  }

  nav ul li a {
    display: block;
    padding: 25px;
    text-align: center;
    color: white;
    text-decoration: none;
    font-size: 25px;
    font-weight: bold;
    
    
  }

  nav ul li a:hover {
    background-color: #800000;
  }

  .contenido {
    padding: 40px 20px;
    max-width: 900px;
    margin: auto;
  }

  h1, h2, h3 {
    text-align: center;
    color: #333;
    font-family: Arial, sans-serif;
    font-weight: bold;
  }

  h1 {
    font-size: 28px;
  }

  h2 {
    font-size: 24px;
    margin-top: 30px;
  }

  h3 {
    font-size: 20px;
    margin-top: 25px;
  }

  form {
    background: white;
    padding: 30px;
    margin-bottom: 35px;
    border-radius: 10px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    font-size: 17px;
    max-width: 1280px;
    margin-left: 5px;
              
  }

  form input[type="text"],
  form input[type="submit"] {
    padding: 14px 18px;
    margin: 12px 5px 12px 0;
    border: 1px solid #ccc;
    border-radius: 6px;
    font-size: 16px;
    font-family: Arial, sans-serif;
  }

  form input[type="submit"] {
    background-color: #9B111E;
    color: white;
    border: none;
    cursor: pointer;
    transition: background 0.3s ease;
  }

  form input[type="submit"]:hover {
    background-color: #9B111E;
  }

  table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
    background: white;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    font-size: 16px;
  }

  table th, table td {
    padding: 12px;
    border: 1px solid #ddd;
    text-align: center;
  }

  table th {
    background-color: #9B111E;
    color: white;
    font-size: 17px;
  }

  .mensaje {
    text-align: center;
    padding: 12px;
    font-size: 18px;
    margin-top: 20px;
    font-weight: bold;
  }

  @media (max-width: 768px) {
    table {
      display: block;
      overflow-x: auto;
    }
  }
</style>

  </style>
</head>
<body>
      <nav>
    <ul>
     
      <li><a href="almacen.php">Nuevo Registro de Almacén</a></li>
      <li><a href="index.html">Cerrar Sesión</a></li>
      
    
    
    </ul>
  </nav>  
   
    <h2>Buscar información por número de inventario</h2>
     <form  method="POST" > 
     <input type="text" name="busqueda" placeholder="Buscar por inventario o artículo">
     <input type="submit" name="buscar" value="Buscar">      
      <input type="submit" name="verificar" value="Verificar existencias">
     
    </form>
     
   <?php
// Conexión a la base de datos
$conexion = new mysqli("localhost", "root", "", "almacen");

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['buscar'])) {
    $busqueda = $_POST['busqueda'];
    $like = "%$busqueda%";

    // Conexión
    $conexion = new mysqli("localhost", "root", "", "almacen");
    if ($conexion->connect_error) {
        die("Conexión fallida: " . $conexion->connect_error);
    } 
    

    // =======================
// 1. Buscar en registrobienes
// =======================
$sql1 = "SELECT * FROM registroalmacen WHERE ninventario LIKE ? OR narticulo LIKE ?";
$stmt1 = $conexion->prepare($sql1);
$stmt1->bind_param("ss", $like, $like);
$stmt1->execute();
$resultado1 = $stmt1->get_result();

echo "<h3>Resultados de registros del almacén</h3>";
if ($resultado1->num_rows > 0) {
    echo "<table border='1'>
            <tr>
                <th>ID</th>
                <th>Inventario</th>
                <th>Marca</th>
                <th>Artículo</th>
                <th>Proveedor</th>
                <th>Imagen Marca</th>
                <th>Imagen Artículo</th>
            </tr>";
    while ($fila = $resultado1->fetch_assoc()) {
        echo "<tr>
                <td>{$fila['id']}</td>
                <td>{$fila['ninventario']}</td>
                <td>{$fila['marca']}</td>
                <td>{$fila['narticulo']}</td>
                <td>{$fila['nprovedor']}</td>
                <td><img src='mostrar_imagenes.php?id=" . $fila['id'] . "&tipo=marca' style='width:120px; height:auto; border-radius:10px;'>
                <td><img src='mostrar_imagenes.php?id=" . $fila['id'] . "&tipo=articulo' style='width:120px; height:auto; border-radius:10px;'>
              </tr>";
    }
    echo "</table>";
    } else {
        echo "<p>No se encontraron resultados de registros de almacen.</p>";
    }
    
    $stmt1->close();


    

    $conexion->close();
    
}
?>
<br>
<form action="pdfalmacen.php">

  <input type="submit" value="Guardar Archivo Almacén">

 </form>


<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['verificar'])) {
    // Conectar a la base de datos
    $conexion = new mysqli("localhost", "root", "", "almacen");
    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }

    // Contar registros
    $sql = "SELECT COUNT(*) AS total FROM registroalmacen";
    $resultado = $conexion->query($sql);

    if ($resultado && $fila = $resultado->fetch_assoc()) {
        $total = $fila['total'];
        echo "<div class='mensaje'>";
        echo "<p>Total de registros: <strong>$total</strong></p>";

        if ($total < 3) {
            echo "<p style='color:red;'>❌ Existencias insuficientes.</p>";
        } elseif ($total <= 5) {
            echo "<p style='color:orange;'>⚠️ Existencias bajas.</p>";
        } else {
            echo "<p style='color:green;'>✅ Existencias completas.</p>";
        }
        echo "</div>";
    } else {
        echo "<p>Error al contar registros.</p>";
    }

    $conexion->close();
}
?>
<br>

<form method="POST">
    <input type="text" name="nombre" placeholder="Nombre del artículo" required>
    <input type="submit" name="eliminar" value="Eliminar Artículo">
</form>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['eliminar'])) {
    $nombre = trim($_POST['nombre']);

    $conexion = new mysqli("localhost", "root", "", "almacen");
    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }

    // Verifica si existe ese nombre
    $verificar = $conexion->prepare("SELECT * FROM registroalmacen WHERE narticulo = ?");
    $verificar->bind_param("s", $nombre);
    $verificar->execute();
    $resultado = $verificar->get_result();

    if ($resultado->num_rows > 0) {
        // Proceder a eliminar
        $eliminar = $conexion->prepare("DELETE FROM registroalmacen WHERE narticulo = ?");
        $eliminar->bind_param("s", $nombre);
        if ($eliminar->execute()) {
            echo "<p class='mensaje' style='color:green;'>✅ Registro con nombre '$nombre' eliminado correctamente.</p>";
        } else {
            echo "<p class='mensaje' style='color:red;'>❌ Error al eliminar el registro.</p>";
        }
        $eliminar->close();
    } else {
        echo "<p class='mensaje' style='color:orange;'>⚠️ No se encontró ningún registro con el nombre '$nombre'.</p>";
    }

    $verificar->close();
    $conexion->close();
}
?>

</body>
</html>