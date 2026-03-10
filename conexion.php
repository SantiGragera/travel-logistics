<?php 
function conexionDB(){
    $Host="sql100.infinityfree.com";
    $User="if0_41358532";
    $Password="mmBO3A1pwPI";
    $BaseDeDatos="if0_41358532_transportes"; 

    $linkConexion = mysqli_connect($Host, $User, $Password, $BaseDeDatos);
    if ($linkConexion) {
        mysqli_set_charset($linkConexion, "utf8mb4");
        return $linkConexion;
    } else {
        die ('No se pudo establecer la conexion');
    }
}
?>