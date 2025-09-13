<?php

include('db.php');

$USUARIO=$_POST['usuario'];
$PASSWORD=$_POST['password'];

$consulta = "SELECT * FROM sesion_almacen where usuario = '$USUARIO' and password = '$PASSWORD' " ;
$resultado = mysqli_query($conexion , $consulta);

$filas=mysqli_num_rows($resultado);

if($filas){
    header("location:indexa.php");

}else{
    include("inicio_sesion_almacen.html");
    ?>
    <h1>ERROR DE AUTENTIFICACION</h1>
    
    <?php
}

mysqli_free_result($resultado);
mysqli_close($conexion);

?>

