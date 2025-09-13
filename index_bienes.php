<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Consulta de Inventario</title>
  <style>
    body {
      margin: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif, Arial;
      background-color: #f2f2f2;
      color: #212529;
    }

    nav {
      background-color: #9B111E;
      box-shadow: 0 2px 6px rgba(0,0,0,0.2);
    }

    nav ul {
      list-style: none;
      margin: 0;
      padding: 0;
      display: flex;
    }

    nav ul li {
      flex: 1;
    }

    nav ul li a {
      display: block;
      text-align: center;
      padding: 33px;
      color: #ffffff;
      text-decoration: none;
      font-weight: bold;
      transition: background 0.3s ease;
      font-size: 20px;
      
    }

    nav ul li a:hover {
      background-color: #800000;
    }

    .contenido {
      padding: 40px 30px;
      max-width: 1300px;
      margin: auto;
    }

    h2, h3 {
      text-align: center;
      color: #9B111E;
    }

    form {
      background-color: #ffffff;
      padding: 25px;
      margin: 20px 0;
      border-radius: 10px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
      text-align: center;
    }

    form input[type="text"],
    form input[type="submit"] {
      padding: 12px 15px;
      margin: 10px;
      font-size: 16px;
      border: 1px solid #ccc;
      border-radius: 6px;
      outline: none;
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
      background: white;
      margin-top: 20px;
      border-radius: 8px;
      overflow: hidden;
      box-shadow: 0 4px 8px rgba(0,0,0,0.05);
    }

    table th, table td {
      padding: 12px;
      text-align: center;
      border: 1px solid #ddd;
    }

    table th {
      background-color: #9B111E;
      color: white;
    }

    img {
      border-radius: 10px;
      width: 120px;
      height: auto;
    }

    .mensaje {
      text-align: center;
      font-weight: bold;
      padding: 15px;
      font-size: 18px;
      margin-top: 20px;
    }

    .contenedor, .izquierda, .izquierda2 {
      max-width: 600px;
      margin: 30px auto;
      text-align: center;
    }
    h1, h2, h3 {
    text-align: center;
    color: #333;
    font-family: Arial, sans-serif;
    font-weight: bold;
  }


    @media (max-width: 768px) {
      table {
        display: block;
        overflow-x: auto;
      }

      form input[type="text"], form input[type="submit"] {
        width: 90%;
        margin: 8px 0;
      }
    }
  </style>
</head>
<body>

  <nav>
    <ul>
      <li><a href="articulosbienes.php">NUEVO REGISTRO DE BIENES MUEBLES E INMUEBLES</a></li>
      <li><a href="equipos.php">NUEVO REGISTRO DE EQUIPOS DE CÓMPUTO</a></li>
      <li><a href="index.html">Cerrar Sesión</a></li>
    </ul>
  </nav>

  <div class="contenido">
    <h2>Buscar información por número de inventario</h2>

    <form method="POST">
      <input type="text" name="busqueda" placeholder="Buscar por inventario o artículo">
      <input type="submit" name="buscar" value="Buscar">
      <input type="submit" name="bienes" value="Ver Bienes Inmuebles">
      <input type="submit" name="equipos" value="Ver Equipos de Cómputo">
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
      
      // Buscar en registrobienes
      $sql1 = "SELECT * FROM registrobienes WHERE ninventario LIKE ? OR narticulo LIKE ?";
      $stmt1 = $conexion->prepare($sql1);
      $stmt1->bind_param("ss", $like, $like);
      $stmt1->execute();
      $resultado1 = $stmt1->get_result();

      echo "<h3>Resultados de registros de bienes inmuebles</h3>";
      if ($resultado1->num_rows > 0) {
        echo "<table border='1'>
                <tr>
                    <th>ID</th>
                    <th>Inventario</th>
                    <th>Artículo</th>
                    <th>Marca</th>
                    <th>Área</th>
                    <th>Imagen Marca</th>
                    <th>Imagen Artículo</th>
                </tr>";
        while ($fila = $resultado1->fetch_assoc()) {
            echo "<tr>
                    <td>{$fila['id']}</td>
                    <td>{$fila['ninventario']}</td>
                    <td>{$fila['narticulo']}</td>
                    <td>{$fila['marca']}</td>
                    <td>{$fila['area']}</td>
                    <td><img src='imagen_guardar.php?id=" . $fila['id'] . "&tipo=marca' style='width:120px; height:auto; border-radius:10px;'>
                    <td><img src='imagen_guardar.php?id=" . $fila['id'] . "&tipo=articulo' style='width:120px; height:auto; border-radius:10px;'>
                  </tr>";
        }
        echo "</table>";
      } else {
        echo "<p>No se encontraron resultados de registros de bienes inmuebles.</p>";
        }
      $stmt1->close();

    // Buscar en equiposcomputo
   
      $sql1 = "SELECT * FROM registroequipos WHERE ninventario LIKE ? OR narticulo LIKE ?";
      $stmt1 = $conexion->prepare($sql1);
      $stmt1->bind_param("ss", $like, $like);
      $stmt1->execute();
      $resultado2 = $stmt1->get_result();

      echo "<h3>Resultados de registros de equipos de cómputo</h3>";
      if ($resultado2->num_rows > 0) {
        echo "<table border='1'>
                <tr>
                    <th>ID</th>
                    <th>Inventario</th>
                    <th>Artículo</th>
                    <th>Marca</th>
                    <th>Área</th>
                    <th>Imagen Marca</th>
                    <th>Imagen Artículo</th>
                </tr>";
        while ($fila = $resultado2->fetch_assoc()) {
            echo "<tr>
                    <td>{$fila['id']}</td>
                    <td>{$fila['ninventario']}</td>
                    <td>{$fila['narticulo']}</td>
                    <td>{$fila['marca']}</td>
                    <td>{$fila['area']}</td>
                    <td><img src='imagen_guardar2.php?id=" . $fila['id'] . "&tipo=marca' style='width:120px; height:auto; border-radius:10px;'>
                    <td><img src='imagen_guardar2.php?id=" . $fila['id'] . "&tipo=articulo' style='width:120px; height:auto; border-radius:10px;'>
                  </tr>";
        }
        echo "</table>";
      } else {
        echo "<p>No se encontraron resultados de registros de bienes inmuebles.</p>";
        }
      $stmt1->close();
      $conexion->close();
      }
?>

<?php
  // Conexión a la base de datos
  $conexion = new mysqli("localhost", "root", "", "almacen");
    if ($conexion->connect_error) {
      die("Conexión fallida: " . $conexion->connect_error);
    }
// BOTÓN MOSTRAR TODO

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['bienes'])) {
    $sql = "SELECT * FROM registrobienes";
    $resultado = $conexion->query($sql);

    echo "<h3>Todos los registros en registrobienes</h3>";
    mostrarTabla($resultado);
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['equipos'])) {
    $sql = "SELECT * FROM registroequipos";
    $resultado = $conexion->query($sql);

    echo "<h3>Todos los registros en registroequipos</h3>";
    mostrarTabla2($resultado);
}

$conexion->close();

// FUNCIÓN PARA MOSTRAR TABLA

function mostrarTabla($resultado) {
    if ($resultado && $resultado->num_rows > 0) {
        echo "<table border='1'>
                <tr>
                    <th>ID</th>
                    <th>Inventario</th>
                    <th>Artículo</th>
                    <th>Marca</th>
                    <th>Área</th>
                    <th>Imagen Marca</th>
                    <th>Imagen Articulo</th>
                </tr>";
        while ($fila = $resultado->fetch_assoc()) {
            echo "<tr>
                    <td>{$fila['id']}</td>
                    <td>{$fila['ninventario']}</td>
                    <td>{$fila['narticulo']}</td>
                    <td>{$fila['marca']}</td>
                    <td>{$fila['area']}</td>
                    <td><img src='imagen_guardar.php?id=" . $fila['id'] . "&tipo=marca' style='width:120px; height:auto; border-radius:10px;'><
                    <td><img src='imagen_guardar.php?id=" . $fila['id'] . "&tipo=articulo' style='width:120px; height:auto; border-radius:10px;'><
                  </tr>";
        }
        echo "</table>";
      } else {
        echo "<p>No se encontraron resultados.</p>";
      }
    }

  function mostrarTabla2($resultado) {
    if ($resultado && $resultado->num_rows > 0) {
        echo "<table border='1'>
                <tr>
                    <th>ID</th>
                    <th>Inventario</th>
                    <th>Artículo</th>
                    <th>Marca</th>
                    <th>Área</th>
                    <th>Imagen Marca</th>
                    <th>Imagen Articulo</th>
                </tr>";
        while ($fila = $resultado->fetch_assoc()) {
            echo "<tr>
                    <td>{$fila['id']}</td>
                    <td>{$fila['ninventario']}</td>
                    <td>{$fila['narticulo']}</td>
                    <td>{$fila['marca']}</td>
                    <td>{$fila['area']}</td>
                    <td><img src='imagen_guardar2.php?id=" . $fila['id'] . "&tipo=marca' style='width:120px; height:auto; border-radius:10px;'>
                    <td><img src='imagen_guardar2.php?id=" . $fila['id'] . "&tipo=articulo' style='width:120px; height:auto; border-radius:10px;'>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No se encontraron resultados.</p>";
    }
  }
?>

  </div>

  <div class="contenedor">
    <form action="pdf.php">
      <input type="submit" value="Guardar Archivo Bienes Inmuebles"> 
    </form>
  </div>

  <div class="izquierda">
    <form action="pdfequipos.php">
      <input type="submit" value="Guardar Archivo Equipos de Cómputo">
    </form>
  </div>

  <div class="izquierda2">

    <form method="POST">
      <input type="text" name="nombre" placeholder="Nombre del artículo" required>
      <input type="submit" name="eliminar" value="Eliminar Artículo">
    </form>
  </div>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['eliminar'])) {
    $nombre = trim($_POST['nombre']);

    $conexion = new mysqli("localhost", "root", "", "almacen");
    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }

    // --- ELIMINAR EN registroequipos ---
    $verificarEquipos = $conexion->prepare("SELECT * FROM registroequipos WHERE narticulo = ?");
    $verificarEquipos->bind_param("s", $nombre);
    $verificarEquipos->execute();
    $resultadoEquipos = $verificarEquipos->get_result();

    if ($resultadoEquipos->num_rows > 0) {
        $eliminarEquipos = $conexion->prepare("DELETE FROM registroequipos WHERE narticulo = ?");
        $eliminarEquipos->bind_param("s", $nombre);
        if ($eliminarEquipos->execute()) {
            echo "<p class='mensaje' style='color:green;'>✅ Registro '$nombre' eliminado de **equipos**.</p>";
        } else {
            echo "<p class='mensaje' style='color:red;'>❌ Error al eliminar en equipos.</p>";
        }
        $eliminarEquipos->close();
    }

    $verificarEquipos->close();

    // --- ELIMINAR EN registrobienes ---
    $verificarBienes = $conexion->prepare("SELECT * FROM registrobienes WHERE narticulo = ?");
    $verificarBienes->bind_param("s", $nombre);
    $verificarBienes->execute();
    $resultadoBienes = $verificarBienes->get_result();

    if ($resultadoBienes->num_rows > 0) {
        $eliminarBienes = $conexion->prepare("DELETE FROM registrobienes WHERE narticulo = ?");
        $eliminarBienes->bind_param("s", $nombre);
        if ($eliminarBienes->execute()) {
            echo "<p class='mensaje' style='color:green;'>✅ Registro '$nombre' eliminado de **bienes**.</p>";
        } else {
            echo "<p class='mensaje' style='color:red;'>❌ Error al eliminar en bienes.</p>";
        }
        $eliminarBienes->close();
    }

    $verificarBienes->close();

    // Mensaje si no se encontró en ninguno
    if ($resultadoEquipos->num_rows == 0 && $resultadoBienes->num_rows == 0) {
        echo "<p class='mensaje' style='color:orange;'>⚠️ No se encontró ningún registro con el nombre '$nombre' en equipos ni en bienes.</p>";
    }

    $conexion->close();
}
?>
</body>
</html>
