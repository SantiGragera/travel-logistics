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

$ListadoMarcas = [];
$SQL_Marcas = "SELECT id_marca, denominacion FROM marcas";
$rs_marcas = mysqli_query($MiConexion, $SQL_Marcas);
while ($data = mysqli_fetch_array($rs_marcas)) {
    $ListadoMarcas[] = $data;
}

if (!empty($_POST['BotonRegistrar'])) {
    if (empty($_POST['Patente']) || strlen($_POST['Patente']) < 6 || strlen($_POST['Patente']) > 7) {
        $Mensaje = "La Patente (*) debe tener 6 o 7 caracteres.";
        $Estilo = "danger";
    } else if (empty($_POST['id_marca'])) {
        $Mensaje = "Debe seleccionar una Marca (*).";
        $Estilo = "danger";
    } else if (empty($_POST['Anio']) || !is_numeric($_POST['Anio']) || $_POST['Anio'] > (date('Y') + 1)) {
        $Mensaje = "Debe ingresar un Año válido (ej: 2024)."; 
        $Estilo = "danger";
    } else if (empty($_POST['Modelo'])) {
        $Mensaje = "Debe ingresar un Modelo (*).";
        $Estilo = "danger";
    } else {
        if (InsertarCamion($MiConexion)) {
            $Mensaje = "El transporte se ha registrado correctamente.";
            $Estilo = "success";
            $_POST = array();
        } else {
            $Mensaje = "Error al registrar el transporte.";
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
    <title>Registrar Camión - Travel Logistics</title>
    <link rel="icon" type="image/png" href="assets/img/logo.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="design/header.css?v=3">
    <link rel="stylesheet" href="design/footer.css">
    <link rel="stylesheet" href="design/formularios.css?v=5"> 
</head>
<body>

    <?php include 'sections/header.php'; ?>
  
    <main class="mainFormulario">
        <div class="formWrapper">
            
            <div class="formEncabezado">
                <h1>Registrar Camión</h1>
                <p>Completa la información técnica del nuevo vehículo para agregarlo a la flota activa.</p>
            </div>

            <?php if (!empty($Mensaje)) { ?>
                <div class="alerta alerta<?php echo ucfirst($Estilo); ?>">
                    <?php echo $Mensaje; ?>
                </div>
            <?php } ?>

            <div class="formCard">
                <form method="POST" action="camion_carga.php" class="formEstilo">
                    
                    <div class="formRow">
                        <div class="formGrupo">
                            <label for="Patente">Patente</label>
                            <input type="text" id="Patente" name="Patente" placeholder="AA123AA" value="<?php echo $_POST['Patente'] ?? ''; ?>">
                        </div>
                        <div class="formGrupo">
                            <label for="id_marca">Marca</label>
                            <select name="id_marca" id="id_marca">
                                <option value="">Seleccionar marca</option>
                                <?php 
                                foreach ($ListadoMarcas as $marca) { 
                                    $selected = (!empty($_POST['id_marca']) && $_POST['id_marca'] == $marca['id_marca']) ? 'selected' : '';
                                    echo "<option value=\"{$marca['id_marca']}\" $selected>{$marca['denominacion']}</option>";
                                } 
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="formRow">
                        <div class="formGrupo">
                            <label for="Anio">Año</label>
                            <input type="number" id="Anio" name="Anio" placeholder="2024" value="<?php echo $_POST['Anio'] ?? ''; ?>">
                        </div>
                        <div class="formGrupo">
                            <label for="Modelo">Modelo</label>
                            <input type="text" id="Modelo" name="Modelo" placeholder="Ej: Scania R450" value="<?php echo $_POST['Modelo'] ?? ''; ?>">
                        </div>
                    </div>

                    <div class="formGrupoCheckbox">
                        <input type="checkbox" id="Disponibilidad" name="Disponibilidad" value="1" <?php echo (!empty($_POST['Disponibilidad'])) ? 'checked' : ''; ?> >
                        <label for="Disponibilidad">Habilitado para viajar</label>
                    </div>
                    
                    <div class="formAcciones">
                        <a href="index.php" class="btnCancelar">Volver</a>
                        <button type="submit" name="BotonRegistrar" value="Registrar" class="btnGuardar">Guardar</button>
                    </div>
                    
                </form>
            </div>

            <div class="formInfoBox">
                <i class="bi bi-info-circle-fill"></i>
                <p>Una vez registrado el camión, este aparecerá automáticamente en la lista de vehículos disponibles para asignar nuevos viajes y conductores.</p>
            </div>

        </div>
    </main>

    <?php include 'sections/footer.php'; ?>

</body>
</html>