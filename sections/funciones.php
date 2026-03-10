<?php 
function InsertarChofer($vConexion) {
    
    $Apellido = $_POST['Apellido'];
    $Nombre = $_POST['Nombre'];
    $DNI = $_POST['DNI'];

    $SQL_Insert = "INSERT INTO usuarios (apellido, nombre, dni, usuario, clave, activo, id_nivel, fecha_creacion)
                   VALUES ('$Apellido', '$Nombre', '$DNI', '$Usuario', '$Clave', 1, 3, NOW())";

    if (!mysqli_query($vConexion, $SQL_Insert)) {
        die("Error al registrar el chofer: " . mysqli_error($vConexion));
    }
    
    return true;
}

function InsertarCamion($vConexion) {
    $id_marca = $_POST['id_marca'];
    $Modelo = $_POST['Modelo'];
    $Anio = $_POST['Anio'];
    $Patente = $_POST['Patente'];
    
    $Disponible = !empty($_POST['Disponibilidad']) ? 1 : 0;

    $SQL_Insert = "INSERT INTO transportes (id_marca, modelo, anio, patente, disponible, fecha_carga)
                   VALUES ($id_marca, '$Modelo', $Anio, '$Patente', $Disponible, NOW())";
    
    if (!mysqli_query($vConexion, $SQL_Insert)) {
        die("Error al registrar el camión: " . mysqli_error($vConexion));
    }

    return true;
}

function ListarChoferes($vConexion) {
    $Listado = [];
    $SQL = "SELECT id_usuario, apellido, nombre, dni 
            FROM usuarios 
            WHERE id_nivel = 3 AND activo = 1 
            ORDER BY apellido, nombre";
    $rs = mysqli_query($vConexion, $SQL);
    while ($data = mysqli_fetch_array($rs)) {
        $Listado[] = $data;
    }
    return $Listado;
}


function ListarTransportes($vConexion) {
    $Listado = [];
    $SQL = "SELECT T.id_transporte, M.denominacion AS marca, T.modelo, T.patente
            FROM transportes T
            JOIN marcas M ON T.id_marca = M.id_marca
            WHERE T.disponible = 1
            ORDER BY M.denominacion, T.modelo";
    $rs = mysqli_query($vConexion, $SQL);
    while ($data = mysqli_fetch_array($rs)) {
        $Listado[] = $data;
    }
    return $Listado;
}

function ListarDestinos($vConexion) {
    $Listado = [];
    $SQL = "SELECT id_destino, denominacion FROM destinos ORDER BY denominacion";
    $rs = mysqli_query($vConexion, $SQL);
    while ($data = mysqli_fetch_array($rs)) {
        $Listado[] = $data;
    }
    return $Listado;
}

function InsertarViaje($vConexion) {

    $id_chofer = $_POST['id_chofer'];
    $id_transporte = $_POST['id_transporte'];
    $FechaProgramada = $_POST['FechaProgramada'];
    $id_destino = $_POST['id_destino'];
    $Costo = $_POST['Costo'];
    $PorcentajeChofer = $_POST['PorcentajeChofer'];
    $id_usuario_registro = $_SESSION['id_usuario'];

    $SQL_Insert = "INSERT INTO viajes (id_chofer, id_transporte, fecha_viaje, id_destino, costo, porcentaje_chofer, fecha_creacion_viaje, id_usuario_registro)
                   VALUES ($id_chofer, $id_transporte, '$FechaProgramada', $id_destino, $Costo, $PorcentajeChofer, NOW(), $id_usuario_registro)";
    
    if (!mysqli_query($vConexion, $SQL_Insert)) {
        die("Error al registrar el viaje: " . mysqli_error($vConexion));
    }
    
    return true;
}

function ListarViajes($vConexion, $vSession) {
    $Listado = [];
    
    $idNivel = $vSession['id_nivel'];
    $idUsuario = $vSession['id_usuario'];

    $SQL = "SELECT 
                V.fecha_viaje, V.costo, V.porcentaje_chofer,
                D.denominacion AS destino,
                M.denominacion AS marca, T.modelo, T.patente,
                C.apellido, C.nombre
            FROM viajes V
            JOIN usuarios C ON V.id_chofer = C.id_usuario
            JOIN transportes T ON V.id_transporte = T.id_transporte
            JOIN marcas M ON T.id_marca = M.id_marca
            JOIN destinos D ON V.id_destino = D.id_destino
            ";
    if ($idNivel == 3) {
        $SQL .= " WHERE V.id_chofer = $idUsuario";
    }

    $SQL .= " ORDER BY V.fecha_viaje ASC, D.denominacion ASC";

    $rs = mysqli_query($vConexion, $SQL);
    while ($data = mysqli_fetch_array($rs)) {
        $Listado[] = $data;
    }
    return $Listado;
}

?>