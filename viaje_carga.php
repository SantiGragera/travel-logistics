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
$Mensaje = "";
$Estilo = "warning"; 

$ListaChoferes = ListarChoferes($MiConexion);
$ListaTransportes = ListarTransportes($MiConexion);
$ListaDestinos = ListarDestinos($MiConexion);

if (!empty($_POST['BotonRegistrar'])) {
    if (empty($_POST['id_chofer'])) {
        $Mensaje = "Debe seleccionar un Chofer (*).";
        $Estilo = "danger";
    } else if (empty($_POST['id_transporte'])) {
        $Mensaje = "Debe seleccionar un Transporte (*).";
        $Estilo = "danger";
    } else if (empty($_POST['FechaProgramada'])) {
        $Mensaje = "Debe seleccionar una Fecha Programada (*).";
        $Estilo = "danger";
    } else if (empty($_POST['id_destino'])) {
        $Mensaje = "Debe seleccionar un Destino (*).";
        $Estilo = "danger";
    } else if (empty($_POST['Costo'])) {
        $Mensaje = "Debe ingresar un Costo (*).";
        $Estilo = "danger";
    } else if (empty($_POST['PorcentajeChofer'])) {
        $Mensaje = "Debe ingresar un Porcentaje (*).";
        $Estilo = "danger";
    } else {
        if (InsertarViaje($MiConexion)) {
            $Mensaje = "El viaje se ha registrado correctamente.";
            $Estilo = "success";
            $_POST = array();
        } else {
            $Mensaje = "Error al registrar el viaje.";
            $Estilo = "danger";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Viaje - Travel Logistics</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="assets/img/logo.png">
    <link rel="stylesheet" href="design/header.css?v=3">
    <link rel="stylesheet" href="design/footer.css">
    <link rel="stylesheet" href="design/formularios.css?v=5"> 
</head>
<body>

    <?php include 'sections/header.php'; ?>
  
    <main class="mainFormulario">
        <div class="formWrapper">
            
            <div class="formEncabezado">
                <h1>Planificar Nuevo Viaje</h1>
                <p>Asigna un chofer, un vehículo y un destino para programar una nueva ruta.</p>
            </div>

            <?php if (!empty($Mensaje)) { ?>
                <div class="alerta alerta<?php echo ucfirst($Estilo); ?>">
                    <?php echo $Mensaje; ?>
                </div>
            <?php } ?>

            <div class="formCard">
                <form method="POST" action="viaje_carga.php" class="formEstilo">
                    
                    <div class="formRow">
                        <div class="formGrupo">
                            <label for="id_chofer">Chofer Asignado (*)</label>
                            <select name="id_chofer" id="id_chofer">
                                <option value="">Selecciona un conductor</option>
                                <?php 
                                foreach ($ListaChoferes as $chofer) { 
                                    $textoOpcion = "{$chofer['apellido']}, {$chofer['nombre']} (DNI {$chofer['dni']})";
                                    $selected = (!empty($_POST['id_chofer']) && $_POST['id_chofer'] == $chofer['id_usuario']) ? 'selected' : '';
                                    echo "<option value=\"{$chofer['id_usuario']}\" $selected>{$textoOpcion}</option>";
                                } 
                                ?>
                            </select>
                        </div>
                        <div class="formGrupo">
                            <label for="id_transporte">Vehículo (*)</label>
                            <select name="id_transporte" id="id_transporte">
                                <option value="">Selecciona un camión</option>
                                <?php 
                                foreach ($ListaTransportes as $transporte) { 
                                    $textoOpcion = "{$transporte['marca']} - {$transporte['modelo']} - {$transporte['patente']}";
                                    $selected = (!empty($_POST['id_transporte']) && $_POST['id_transporte'] == $transporte['id_transporte']) ? 'selected' : '';
                                    echo "<option value=\"{$transporte['id_transporte']}\" $selected>{$textoOpcion}</option>";
                                } 
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="formRow">
                        <div class="formGrupo">
                            <label for="id_destino">Destino de la carga (*)</label>
                            <select name="id_destino" id="id_destino">
                                <option value="">Selecciona una ciudad/planta</option>
                                <?php 
                                foreach ($ListaDestinos as $destino) { 
                                    $textoOpcion = $destino['denominacion'];
                                    $selected = (!empty($_POST['id_destino']) && $_POST['id_destino'] == $destino['id_destino']) ? 'selected' : '';
                                    echo "<option value=\"{$destino['id_destino']}\" $selected>{$textoOpcion}</option>";
                                } 
                                ?>
                            </select>
                        </div>
                        <div class="formGrupo">
                            <label for="FechaProgramada">Fecha de Salida (*)</label>
                            <input type="date" id="FechaProgramada" name="FechaProgramada" value="<?php echo $_POST['FechaProgramada'] ?? ''; ?>">
                        </div>
                    </div>

                    <div class="formRow">
                        <div class="formGrupo">
                            <label for="Costo">Costo del Viaje ($) (*)</label>
                            <input type="text" id="Costo" name="Costo" placeholder="Ej: 300000.00" value="<?php echo $_POST['Costo'] ?? ''; ?>">
                        </div>
                        <div class="formGrupo">
                            <label for="PorcentajeChofer">Comisión Chofer (%) (*)</label>
                            <input type="text" id="PorcentajeChofer" name="PorcentajeChofer" placeholder="Ej: 10" value="<?php echo $_POST['PorcentajeChofer'] ?? ''; ?>">
                        </div>
                    </div>

                    <div style="margin-top: 35px;"></div>
                    
                    <div class="formAcciones">
                        <a href="index.php" class="btnCancelar">Volver</a>
                        <button type="submit" name="BotonRegistrar" value="Registrar" class="btnGuardar">Programar Viaje</button>
                    </div>
                    
                </form>
            </div>

            <div class="formInfoBox">
                <i class="bi bi-map-fill"></i>
                <p>Una vez guardado, el viaje pasará a estado "Programado" y aparecerá en el panel de viajes recientes del conductor asignado.</p>
            </div>

        </div>
    </main>

    <?php include 'sections/footer.php'; ?>

</body>
</html>