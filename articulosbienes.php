<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Sistema Login</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <style>
    :root {
      --guinda: #9B111E;
      --blanco: #f5f5f5;
    }
body {
  margin: 0;
  font-family: 'Segoe UI', sans-serif;
  background-color: var(--blanco);
  
  /* Propiedades de la imagen de fi¿ondo */
  background-image: url('escudo.png');  
  background-size: 315px auto;         
  background-repeat: no-repeat;     
  background-position: left 10px top 300px;    
  background-attachment: fixed;       
  display: flex;
  justify-content: center;
  align-items: flex-start;
  height: 100vh;
  padding-top: 0px;
}

    /* Banner superior ginda */
    .banner-superior {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      background-color: var(--guinda);
      color: var(--blanco);
      padding: 26px 0;
      text-align: center;
      font-size: 24px;
      font-weight: bold;
      box-shadow: 0 4px 8px rgba(0,0,0,0.2);
      z-index: 10;
    }

    form {
      background-color: #ffffff;
      padding: 40px 30px;
      border-radius: 12px;
      box-shadow: 0 8px 24px rgba(0,0,0,0.1);
      width: 350px;
      max-width: 90%;
      text-align: center;
      margin-top: 120px;
      display: flex;
      flex-direction: column;
      align-items: center;
    }

    /* Rectángulo sistema login ajustado */
    .titulo {
      background-color: var(--guinda);
      color: #f9f9f9;
      padding: 15px;
      border-radius: 8px;
      margin-bottom: 25px;
      font-size: 22px;
      font-weight: bold;
      width: 100%;
      max-width: 290px;
      box-sizing: border-box;
      text-align: center;
    }

    form p {
      align-self: flex-start;
      font-weight: bold;
      margin-bottom: 8px;
      color: #333;
      max-width: 290px;
      width: 100%;
    }

    form input[type="text"],
    form input[type="password"] {
      width: 290px;
      padding: 12px;
      margin-bottom: 18px;
      border: 2px solid var(--guinda);
      border-radius: 8px;
      font-size: 16px;
      outline: none;
      box-sizing: border-box;
    }

    form input[type="submit"] {
      margin-top: 35px;
      padding: 12px 25px;
      background-color: var(--blanco);
      color: var(--guinda);
      border: 2px solid var(--guinda);
      border-radius: 8px;
      font-size: 16px;
      font-weight: bold;
      cursor: pointer;
      transition: all 0.3s ease;
      box-shadow: 2px 2px 8px rgba(0,0,0,0.15);
      width: 290px;
      max-width: 100%;
    }

    form input[type="submit"]:hover {
      background-color:#f9f9f9
    }

    @media (max-width: 400px) {
      form, .titulo, form input[type="text"], form input[type="password"], form input[type="submit"] {
        width: 90%;
        max-width: none;
      }
      form p {
        max-width: 90%;
      }
    }
    form select,
    form input[type="file"] {
      padding: 12px;
    margin: 10px;
    font-size: 16px;
    border: 1px solid #ccc;
    border-radius: 6px;
    background-color: #fff;
    transition: border 0.3s ease;
  }

    form select:focus,
    form input[type="file"]:focus {
    border-color: #9B111E;
    outline: none;
  }

  .custom-file-label {
  display: inline-block;
  background-color: #9B111E;
  color: white;
  padding: 12px 18px;
  border-radius: 6px;
  cursor: pointer;
  transition: background 0.3s ease;
  font-size: 15px;
  }

  .custom-file-label:hover {
  background-color: #7b1f1f;
  }

  input[type="file"] {
  display: none;
  }

  .file-wrapper {
  margin: 10px 0;
  }
  </style>
</head>
<body>

  <div class="banner-superior">NUEVO REGISTRO DE ARTÍCULOS BIENES MUEBLES E INMUEBLES</div>

 <form method="post" enctype="multipart/form-data">
  
      <label for="ninventario">N.º de Inventario</label>
      <input type="text" name="ninventario" required>

      <label for="marca">Marca</label>
      <input type="text" name="marca" required>

      <label for="narticulo">Nombre del Artículo</label>
      <input type="text" name="narticulo" required>

      <label for="area">Elige una Área:</label>

          <select id="area" name="area">
          <option value="Subdirección de Sistemas">Subdirección Sistemas</option>
          <option value="Subdirección Recursos Humanos">Subdirección Recursos Humanos</option>
          <option value="Subdirección Recursos Materiales">Subdirección Recursos Materiales</option>
          <option value="Subdirección Control Vehicular">Subdirección Control Vehicular</option>
          <option value="Subdirección Servicios Generales">Subdirección Servicios Generales</option>
          <option value="Subdirección Administracióna">Subdirección Administración</option>
          </select>
        
      <div class="file-wrapper">
        <label for="imagenmarca" class="custom-file-label">Subir Imagen de Marca</label>
        <input type="file" id="imagenmarca" name="imagenmarca" accept="image/*" required>
      </div>
      </div>

      <div class="file-wrapper">
        <label for="imagenarticulo" class="custom-file-label">Subir Imagen del Artículo</label>
        <input type="file" id="imagenarticulo" name="imagenarticulo" accept="image/*" required>
      </div>
      
      <input type="submit" name="registro" value="Registrar">
      <a href="index_bienes.php" class="volver">← Volver al Inicio</a>
    </form>
    
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
    $area = mysqli_real_escape_string($enlace, $_POST['area']);
    
    $imagenmarca = mysqli_real_escape_string($enlace, file_get_contents($_FILES['imagenmarca']['tmp_name']));
    $imagenarticulo = mysqli_real_escape_string($enlace, file_get_contents($_FILES['imagenarticulo']['tmp_name']));
    
    $insertarDatos = "INSERT INTO registrobienes 
        (ninventario, marca, narticulo, area, imagenmarca, imagenarticulo)
        VALUES ('$ninventario', '$marca', '$narticulo', '$area', '$imagenmarca', '$imagenarticulo')";
    
    $ejecutarInsertar = mysqli_query($enlace, $insertarDatos);

    if (!$ejecutarInsertar) {
    echo "Error al ejecutar query: " . mysqli_error($enlace);
}
}
?>
