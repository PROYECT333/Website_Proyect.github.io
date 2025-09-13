<?php

include('dbbienes.php');

$USUARIO=$_POST['usuario'];
$PASSWORD=$_POST['password'];

$consulta = "SELECT * FROM sesion_bienes where usuario = '$USUARIO' and password = '$PASSWORD' " ;
$resultado = mysqli_query($conexion , $consulta);

$filas=mysqli_num_rows($resultado);

if($filas){
    header("location:index_bienes.php");

}else{
    include("inicio_sesion_bienes.html");
    ?>
    <h1>ERROR DE AUTENTIFICACION</h1>
    <?php
}

mysqli_free_result($resultado);
mysqli_close($conexion);

?>