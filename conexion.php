<?php 
function conexionDB(){
    $Host="localhost";
    $User="root";
    $Password="";
    $BaseDeDatos="transportes"; 

    $linkConexion = mysqli_connect($Host, $User, $Password, $BaseDeDatos);
    if ($linkConexion) {
        mysqli_set_charset($linkConexion, "utf8mb4");
        return $linkConexion;
    } else {
        die ('No se pudo establecer la conexion');
    }
}
?>