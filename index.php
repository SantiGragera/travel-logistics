<?php
session_start();
if (empty($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit;
}

require_once 'conexion.php';
require_once 'sections/funciones.php';
$MiConexion = conexionDB();

$nombreUsuario = $_SESSION['nombre'];

$resViajes = mysqli_query($MiConexion, "SELECT COUNT(*) as total FROM viajes");
$totalViajes = mysqli_fetch_assoc($resViajes)['total'];

$resChoferes = mysqli_query($MiConexion, "SELECT COUNT(*) as total FROM usuarios WHERE id_nivel = 3 AND activo = 1");
$totalChoferesActivos = mysqli_fetch_assoc($resChoferes)['total'];

$resCamiones = mysqli_query($MiConexion, "SELECT COUNT(*) as total FROM transportes WHERE disponible = 1");
$totalCamiones = mysqli_fetch_assoc($resCamiones)['total'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Control - Logística</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="design/header.css?v=3">
    <link rel="stylesheet" href="design/index.css?v=3">
    <link rel="stylesheet" href="design/footer.css">
</head>

<body>
    <?php include 'sections/header.php'; ?>
    <div class="indexMain">
        <main class="indexContainer">

            <div class="indexEncabezado">
                <h1>Resumen Operativo</h1>
                <p>Bienvenido de vuelta, <?php echo $nombreUsuario; ?>. Aquí está el estado actual de tu red.</p>
            </div>

            <div class="indexEstadisticas">
                <a href="viajes_listado.php" class="cardEstadistica">
                    <div class="cardHeader">
                        <h3>Total Viajes</h3>
                        <div class="icon-wrapper icon-blue"><i class="bi bi-signpost-split"></i></div>
                    </div>
                    <p class="numeroCard"><?php echo $totalViajes; ?></p>
                </a>

                <a href="chofer_listado.php" class="cardEstadistica">
                    <div class="cardHeader">
                        <h3>Choferes Activos</h3>
                        <div class="icon-wrapper icon-green"><i class="bi bi-person-fill"></i></div>
                    </div>
                    <p class="numeroCard"><?php echo $totalChoferesActivos; ?></p>
                </a>

                <a href="camion_listado.php" class="cardEstadistica">
                    <div class="cardHeader">
                        <h3>Camiones Disp.</h3>
                        <div class="icon-wrapper icon-purple"><i class="bi bi-truck"></i></div>
                    </div>
                    <p class="numeroCard"><?php echo $totalCamiones; ?></p>
                </a>
            </div>

            <section class="indexAcciones">
                <a href="camion_carga.php" class="card-link bg-truck">
                    <div class="card-overlay"></div>
                    <div class="card-content">
                        <div class="card-icon"><i class="bi bi-plus-lg"></i></div>
                        <h4>Registrar Camión</h4>
                        <p>Agrega un nuevo vehículo a tu flota.</p>
                    </div>
                </a>

                <a href="chofer_carga.php" class="card-link bg-driver">
                    <div class="card-overlay"></div>
                    <div class="card-content">
                        <div class="card-icon"><i class="bi bi-person-plus-fill"></i></div>
                        <h4>Registrar Chofer</h4>
                        <p>Suma un nuevo conductor al equipo.</p>
                    </div>
                </a>

                <a href="viaje_carga.php" class="card-link bg-trip">
                    <div class="card-overlay"></div>
                    <div class="card-content">
                        <div class="card-icon"><i class="bi bi-map"></i></div>
                        <h4>Nuevo Viaje</h4>
                        <p>Planifica y despacha una nueva ruta.</p>
                    </div>
                </a>
            </section>

        </main>
    </div>

    <?php include 'sections/footer.php'; ?>

</body>
</html>