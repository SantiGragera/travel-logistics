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
$ListaViajes = ListarViajes($MiConexion, $_SESSION);

date_default_timezone_set("America/Argentina/Cordoba"); 
$FechaActual = date("Y-m-d");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Viajes - Travel Logistics</title>
    <link rel="icon" type="image/png" href="assets/img/logo.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="design/header.css?v=3">
    <link rel="stylesheet" href="design/footer.css">
    <link rel="stylesheet" href="design/viajes_listado.css?v=5">
</head>
<body>

    <?php include 'sections/header.php'; ?>
  
    <main class="mainListado">
        <div class="listadoWrapper">

            <div class="listadoHeaderFlex">
                <div class="listadoEncabezado">
                    <h1>Gestión de Viajes</h1>
                    <p>Administra y monitorea todos los traslados de la flota en tiempo real.</p>
                </div>
                <?php if ($idNivelUsuario == 1 || $idNivelUsuario == 2) { ?>
                    <a href="viaje_carga.php" class="btnPrincipal"><i class="bi bi-plus-circle"></i> Planificar Nuevo Viaje</a>
                <?php } ?>
            </div>

            <div class="listadoCard">
                
                <div class="tableResponsive">
                    <table class="tablaEstilo">
                        <thead>
                            <tr>
                                <th>#</th> 
                                <th>CAMIÓN (PATENTE)</th>
                                <th>CHOFER</th>
                                <th>DESTINO</th>
                                <th>SALIDA</th>
                                <th>ESTADO</th>
                                <?php if ($idNivelUsuario != 3) { ?> <th>COSTO</th> <?php } ?>
                                <?php if ($idNivelUsuario != 2) { ?> <th>MONTO CHOFER</th> <?php } ?>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($ListaViajes as $viaje) {
                                $i++; 
                                
                                $claseEstado = '';
                                $textoEstado = '';
                                if ($viaje['fecha_viaje'] < $FechaActual) {
                                    $claseEstado = 'estadoCompletado';
                                    $textoEstado = 'Completado';
                                } else if ($viaje['fecha_viaje'] == $FechaActual) {
                                    $claseEstado = 'estadoProgreso';
                                    $textoEstado = 'En Progreso';
                                } else {
                                    $claseEstado = 'estadoPlaneado';
                                    $textoEstado = 'Planeado';
                                }
                                
                                $fechaFormateada = date('M d, Y', strtotime($viaje['fecha_viaje']));
                                $costoFormateado = '$' . number_format($viaje['costo'], 0, ',', '.');
                                $montoCalculado = $viaje['costo'] * ($viaje['porcentaje_chofer'] / 100);
                                $montoFormateado = '$' . number_format($montoCalculado, 0, ',', '.');

                                $nombreChoferCompleto = $viaje['nombre'] . ' ' . $viaje['apellido'];
                                $urlAvatar = "https://ui-avatars.com/api/?name=" . urlencode($nombreChoferCompleto) . "&background=random";
                            ?>
                            
                            <tr>
                                <td><span class="idViaje"><?php echo $i; ?></span></td>
                                
                                <td>
                                    <div class="tdCamion">
                                        <i class="bi bi-truck textIcon"></i>
                                        <div class="tdCamionTextos">
                                            <span class="patente"><?php echo $viaje['patente']; ?></span>
                                            <span class="modelo"><?php echo $viaje['marca'] . ' ' . $viaje['modelo']; ?></span>
                                        </div>
                                    </div>
                                </td>
                                
                                <td>
                                    <div class="tdChofer">
                                        <img src="<?php echo $urlAvatar; ?>" alt="Avatar" class="avatarTabla">
                                        <span class="nombreChofer"><?php echo $nombreChoferCompleto; ?></span>
                                    </div>
                                </td>
                                
                                <td>
                                    <div class="tdRuta">
                                        <span class="rutaPrincipal"><?php echo $viaje['destino']; ?></span>
                                        <span class="rutaSecundaria"><i class="bi bi-arrow-down-short"></i> Desde Base</span>
                                    </div>
                                </td>
                                
                                <td><span class="fechaSalida"><?php echo $fechaFormateada; ?></span></td>
                                
                                <td>
                                    <span class="badgeEstado <?php echo $claseEstado; ?>">
                                        <span class="dot"></span> <?php echo $textoEstado; ?>
                                    </span>
                                </td>
                                
                                <?php if ($idNivelUsuario != 3) { ?>
                                    <td><span class="badgeCosto"><?php echo $costoFormateado; ?></span></td>
                                <?php } ?>

                                <?php if ($idNivelUsuario != 2) { ?>
                                    <td>
                                        <span class="badgeMonto">
                                            <?php 
                                            if ($idNivelUsuario == 3) {
                                                echo $montoFormateado;
                                            } else {
                                                echo "$montoFormateado <small>({$viaje['porcentaje_chofer']}%)</small>";
                                            }
                                            ?>
                                        </span>
                                    </td>
                                <?php } ?>

                                <td class="tdAcciones"><i class="bi bi-three-dots-vertical"></i></td>
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