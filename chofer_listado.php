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

$SQL = "SELECT u.id_usuario, u.nombre, u.apellido, u.dni, u.activo,
               (SELECT COUNT(*) FROM viajes v WHERE v.id_chofer = u.id_usuario AND v.fecha_viaje = CURDATE()) as en_viaje
        FROM usuarios u
        WHERE u.id_nivel = 3";
        
$rs = mysqli_query($MiConexion, $SQL);
$ListaChoferes = [];
while ($data = mysqli_fetch_array($rs)) {
    $ListaChoferes[] = $data;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Choferes - Travel Logistics</title>

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
                    <h1>Gestión de Choferes</h1>
                    <p>Administra el personal de conducción y supervisa sus estados actuales.</p>
                </div>
                <?php if ($idNivelUsuario == 1 || $idNivelUsuario == 2) { ?>
                    <a href="chofer_carga.php" class="btnPrincipal"><i class="bi bi-person-plus-fill"></i> Registrar Chofer</a>
                <?php } ?>
            </div>

            <div class="listadoCard">
                <div class="tableResponsive">
                    <table class="tablaEstilo">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>CHOFER</th>
                                <th>DNI</th>
                                <th>ESTADO</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($ListaChoferes as $chofer) {
                                $i++; 
                                if ($chofer['en_viaje'] > 0) {
                                    $claseEstado = 'estadoViajando';
                                    $textoEstado = 'En Viaje';
                                } else if ($chofer['activo'] == 1) {
                                    $claseEstado = 'estadoActivo';
                                    $textoEstado = 'Activo';
                                } else {
                                    $claseEstado = 'estadoInactivo';
                                    $textoEstado = 'Inactivo';
                                }
                                
                                $nombreCompleto = $chofer['nombre'] . ' ' . $chofer['apellido'];
                                $urlAvatar = "https://ui-avatars.com/api/?name=" . urlencode($nombreCompleto) . "&background=random";
                            ?>
                            
                            <tr>
                                <td><span class="idViaje"><?php echo $i; ?></span></td>
                                
                                <td>
                                    <div class="tdChofer">
                                        <img src="<?php echo $urlAvatar; ?>" alt="Avatar" class="avatarTabla">
                                        <div class="tdCamionTextos">
                                            <span class="nombreChofer"><?php echo $nombreCompleto; ?></span>
                                            <span class="modelo">Miembro del equipo</span>
                                        </div>
                                    </div>
                                </td>
                                
                                <td><span class="fechaSalida"><?php echo $chofer['dni']; ?></span></td>
                                
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