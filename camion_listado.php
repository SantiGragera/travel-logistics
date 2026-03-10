<?php
session_start();
if (empty($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit;
}

require_once 'conexion.php'; 
require_once 'sections/funciones.php'; 
$MiConexion = conexionDB(); 

$idNivelUsuario = $_SESSION['id_nivel']; 
$i = 0; 
$SQL = "SELECT t.id_transporte, m.denominacion as marca, t.modelo, t.patente, t.disponible,
               (SELECT COUNT(*) FROM viajes v WHERE v.id_transporte = t.id_transporte AND v.fecha_viaje = CURDATE()) as en_viaje
        FROM transportes t
        INNER JOIN marcas m ON t.id_marca = m.id_marca";
        
$rs = mysqli_query($MiConexion, $SQL);
$ListaCamiones = [];
while ($data = mysqli_fetch_array($rs)) {
    $ListaCamiones[] = $data;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Camiones - Travel Logistics</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="design/header.css?v=3">
    <link rel="stylesheet" href="design/footer.css">
    <link rel="stylesheet" href="design/listados.css?v=6">
    <link rel="stylesheet" href="design/viajes_listado.css?v=5">
</head>
<body>

    <?php include 'sections/header.php'; ?>
  
    <main class="mainListado">
        <div class="listadoWrapper">

            <div class="listadoHeaderFlex">
                <div class="listadoEncabezado">
                    <h1>Gestión de Flota</h1>
                    <p>Monitorea los vehículos disponibles y su estado operativo.</p>
                </div>
                <?php if ($idNivelUsuario == 1 || $idNivelUsuario == 2) { ?>
                    <a href="camion_carga.php" class="btnPrincipal"><i class="bi bi-truck"></i> Registrar Camión</a>
                <?php } ?>
            </div>

            <div class="listadoCard">
                <div class="tableResponsive">
                    <table class="tablaEstilo">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>VEHÍCULO</th>
                                <th>PATENTE</th>
                                <th>ESTADO</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($ListaCamiones as $camion) {
                                $i++; 
                                if ($camion['en_viaje'] > 0) {
                                    $claseEstado = 'estadoViajando';
                                    $textoEstado = 'En Ruta';
                                } else if ($camion['disponible'] == 1) {
                                    $claseEstado = 'estadoActivo';
                                    $textoEstado = 'Disponible';
                                } else {
                                    $claseEstado = 'estadoInactivo';
                                    $textoEstado = 'Taller / Inactivo';
                                }
                            ?>
                            
                            <tr>
                                <td><span class="idViaje"><?php echo $i; ?></span></td>
                                
                                <td>
                                    <div class="tdCamion">
                                        <div class="icon-wrapper icon-purple" style="width: 40px; height: 40px;"><i class="bi bi-truck"></i></div>
                                        <div class="tdCamionTextos">
                                            <span class="nombreChofer"><?php echo $camion['marca']; ?></span>
                                            <span class="modelo">Mod. <?php echo $camion['modelo']; ?></span>
                                        </div>
                                    </div>
                                </td>
                                
                                <td><span class="patente"><?php echo $camion['patente']; ?></span></td>
                                
                                <td>
                                    <span class="badgeEstado <?php echo $claseEstado; ?>">
                                        <span class="dot"></span> <?php echo $textoEstado; ?>
                                    </span>
                                </td>
                            </tr>
                            
                            <?php } ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    <?php include 'sections/footer.php'; ?>

</body>
</html>