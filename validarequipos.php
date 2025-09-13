<?php

include('dbequipos.php');

$USUARIO=$_POST['usuario'];
$PASSWORD=$_POST['password'];

$consulta = "SELECT * FROM equipos where usuario = '$USUARIO' and password = '$PASSWORD' " ;
$resultado = mysqli_query($conexion , $consulta);

$filas=mysqli_num_rows($resultado);

if($filas){
    header("location:indexequipos.php");

}else{
    include("inicio_sesion_equipos.html");
    ?>
    <h1>ERROR DE AUTENTIFICACION</h1>
    <?php
}

mysqli_free_result($resultado);
mysqli_close($conexion);

?>