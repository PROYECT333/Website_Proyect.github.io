<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Registro de Almacén</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    :root {
      --color-principal: #800000;
      --color-fondo: #f5f5f5;
      --color-texto: #333;
      --color-secundario: #ffffff;
    }

    * {
      box-sizing: border-box;
      font-family: 'Segoe UI', sans-serif;
    }

    body {
      margin: 0;
      background-color: var(--color-fondo);
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
   
      
    }

    .contenedor {
      background-color: var(--color-secundario);
      padding: 40px;
      border-radius: 12px;
      box-shadow: 0 10px 30px rgba(0,0,0,0.1);
      width: 400px;
      max-width: 95%;
    }

    .contenedor h2 {
      color: var(--color-principal);
      text-align: center;
      margin-bottom: 30px;
      font-size: 34px;
      
    }

    label {
      display: block;
      margin-bottom: 6px;
      font-weight: 600;
      color: var(--color-texto);
    }

    input[type="text"],
    input[type="file"] {
      width: 100%;
      padding: 12px;
      border: 1px solid #ccc;
      border-radius: 6px;
      margin-bottom: 20px;
      font-size: 15px;
      background-color: #fdfdfd;
    }

    input[type="submit"] {
      width: 100%;
      padding: 12px;
      background-color: var(--color-principal);
      color: #fff;
      border: none;
      border-radius: 6px;
      font-weight: bold;
      font-size: 16px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    input[type="submit"]:hover {
      background-color: #a00000;
    }

    .volver {
      display: block;
      margin-top: 20px;
      text-align: center;
      text-decoration: none;
      color: var(--color-principal);
      font-weight: bold;
      font-size: 14px;
    }

    .volver:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>

  <div class="contenedor">
    <h2>Registro de Artículo</h2>
    <form method="post" enctype="multipart/form-data">
        <label for="ninventario">Numero de Inventario:</label>
          <input type="text" name="ninventario" placeholder="ninventario">
          <br>
        <div>
          <label for="marca">Marca</label>
          <input type="text" name="marca" placeholder="marca">
         <br>
        <div>
          <label for="narticulo">Nombre del Articulo</label>
          <input type="text" name="narticulo" placeholder="narticulo">
          <br>
          <label for="nprovedor">Nombre del Articulo</label>
          <input type="text" name="nprovedor" placeholder="nprovedor">
          <br>

            <label for="imagenmarca">Imagen de la Marca</label>
            <input type="file" name="imagenmarca" required="" action="imagen_guardar.php">
            <br>
            <label for="imagenarticulo">Imagen del Articulo</label>
            <input type="file" name="imagenarticulo" required="" action="imagen_guardar.php">
            <br>
            <br>

          <input type="submit" name="registro">
    </form>

    <a href="index.php" class="volver">← Volver al Inicio</a>
  </div>

</body>
</html>


<?php
 $servidor ='localhost';
    $usuario ='root';
    $clave ='';
    $baseDeDatos ='almacen';
 $enlace = mysqli_connect ($servidor, $usuario, $clave, $baseDeDatos);

if (!$enlace) {
    die("Error de conexión: " . mysqli_connect_error());
}

if (isset($_POST['registro'])) {
    $ninventario = mysqli_real_escape_string($enlace, $_POST['ninventario']);
    $marca = mysqli_real_escape_string($enlace, $_POST['marca']);
    $narticulo = mysqli_real_escape_string($enlace, $_POST['narticulo']);
    $nprovedor = mysqli_real_escape_string($enlace, $_POST['nprovedor']);
    
    $imagenmarca = mysqli_real_escape_string($enlace, file_get_contents($_FILES['imagenmarca']['tmp_name']));
    $imagenarticulo = mysqli_real_escape_string($enlace, file_get_contents($_FILES['imagenarticulo']['tmp_name']));
    
    $insertarDatos = "INSERT INTO registroalmacen 
        (ninventario, marca, narticulo, nprovedor, imagenmarca, imagenarticulo)
        VALUES ('$ninventario', '$marca', '$narticulo', '$nprovedor', '$imagenmarca', '$imagenarticulo')";
    
    $ejecutarInsertar = mysqli_query($enlace, $insertarDatos);

    if (!$ejecutarInsertar) {
    echo "Error al ejecutar query: " . mysqli_error($enlace);
}
}
?>
 