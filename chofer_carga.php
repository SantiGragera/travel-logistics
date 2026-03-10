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

if (!empty($_POST['BotonRegistrar'])) {
    if (empty($_POST['Apellido'])) {
        $Mensaje = "El Apellido es obligatorio.";
        $Estilo = "danger";
    } else if (empty($_POST['Nombre'])) {
        $Mensaje = "El Nombre es obligatorio.";
        $Estilo = "danger";
    } else if (empty($_POST['DNI'])) {
        $Mensaje = "El DNI es obligatorio.";
        $Estilo = "danger";
    } else {
        if (InsertarChofer($MiConexion)) {
            $Mensaje = "Chofer registrado exitosamente.";
            $Estilo = "success";
            $_POST = array(); 
        } else {
            $Mensaje = "Error al registrar el chofer. (Posible DNI duplicado)";
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
    <title>Registrar Chofer - Travel Logistics</title>
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
                <h1>Registrar Chofer</h1>
                <p>Ingresa los datos personales y de acceso del nuevo conductor para sumarlo al equipo.</p>
            </div>

            <?php if (!empty($Mensaje)) { ?>
                <div class="alerta alerta<?php echo ucfirst($Estilo); ?>">
                    <?php echo $Mensaje; ?>
                </div>
            <?php } ?>

            <div class="formCard">
                <form method="POST" action="chofer_carga.php" class="formEstilo">
                    
                    <div class="formRow">
                        <div class="formGrupo">
                            <label for="Nombre">Nombre (*)</label>
                            <input type="text" id="Nombre" name="Nombre" placeholder="Ej: Juan" value="<?php echo $_POST['Nombre'] ?? ''; ?>">
                        </div>
                        <div class="formGrupo">
                            <label for="Apellido">Apellido (*)</label>
                            <input type="text" id="Apellido" name="Apellido" placeholder="Ej: Pérez" value="<?php echo $_POST['Apellido'] ?? ''; ?>">
                        </div>
                    </div>

                    <div class="formRow">
                        <div class="formGrupo">
                            <label for="DNI">DNI (*)</label>
                            <input type="number" id="DNI" name="DNI" placeholder="Sin puntos ni espacios" value="<?php echo $_POST['DNI'] ?? ''; ?>">
                        </div>
                        <div class="formGrupo">
                            <label for="Usuario">Usuario</label>
                            <input type="text" id="Usuario" name="Usuario" placeholder="Usuario para el sistema" value="<?php echo $_POST['Usuario'] ?? ''; ?>">
                        </div>
                    </div>

                    <div class="formRow">
                        <div class="formGrupo">
                            <label for="Clave">Clave</label>
                            <input type="password" id="Clave" name="Clave" placeholder="Contraseña de acceso">
                        </div>
                        <div></div> 
                    </div>

                    <div style="margin-top: 35px;"></div>
                    
                    <div class="formAcciones">
                        <a href="index.php" class="btnCancelar">Volver</a>
                        <button type="submit" name="BotonRegistrar" value="Registrar" class="btnGuardar">Guardar</button>
                    </div>
                    
                </form>
            </div>

            <div class="formInfoBox">
                <i class="bi bi-person-badge-fill"></i>
                <p>Una vez registrado, el chofer podrá ser asignado a nuevos viajes. Si le creaste un usuario y clave, podrá iniciar sesión para ver sus rutas y recorridos.</p>
            </div>

        </div>
    </main>

    <?php include 'sections/footer.php'; ?>

</body>
</html>