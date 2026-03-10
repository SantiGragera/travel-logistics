<?php
  require_once "conexion.php";
  $MiConexion = conexionDB();
  session_start();

  $mensajeError = '';
  
  if (!empty($_POST['btningresar'])) {
      if (empty($_POST['usuario'])) {
          $mensajeError = "Debe ingresar su usuario.";
      } else if (empty($_POST['clave'])) {
          $mensajeError = "Debe ingresar su clave.";
      } else {
          $usuario = $_POST['usuario'];
          $clave = $_POST['clave'];
          
          $SQL = "SELECT id_usuario, nombre, apellido, id_nivel, imagen, activo 
                  FROM usuarios 
                  WHERE usuario = '$usuario' AND clave = '$clave'";
          $rs = mysqli_query($MiConexion, $SQL);
          
          if ($data = mysqli_fetch_array($rs)) {
              if ($data['activo'] == 1) {
                  $_SESSION['id_usuario'] = $data['id_usuario'];
                  $_SESSION['nombre'] = $data['nombre'];
                  $_SESSION['apellido'] = $data['apellido'];
                  $_SESSION['id_nivel'] = $data['id_nivel'];
                  $_SESSION['imagen'] = $data['imagen'];
                  header("Location: index.php");
                  exit;
              } else {
                  $mensajeError = "Usuario inactivo.";
              }
          } else {
              $mensajeError = "Usuario o clave incorrectos. Intenta nuevamente.";
          }
      }
  }
?>
<!DOCTYPE html>
<html lang="es">
  <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Login - Travel Logistics</title>
      <link rel="stylesheet" href="design/login.css?v=2">
      <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
  </head>
  <body>
  <main>
    <div class="contLogin">
      <div class="titulosLogin">
        <h1 class="titLogin">Bienvenido</h1>
        <h3 class="subLogin">Inicia sesión para gestionar tu flota y viajes.</h3>
      </div>
      <form class="formLogin" method="POST" action="login.php">
        <div class="formText">
          <label class="labelLogin" for="usuario">Usuario</label>
          <div class="input-container">
            <i class="fa-regular fa-user"></i>
            <input class="inputLogin" type="text" id="usuario" name="usuario" placeholder="Ingresa tu usuario" required>
          </div>
        </div>
        <div class="formText">
          <label class="labelLogin" for="clave">Contraseña</label>
          <div class="input-container">
            <i class="fa-solid fa-lock"></i>
            <input class="inputLogin" type="password" id="clave" name="clave" placeholder="••••••••" required>
          </div>
        </div>
        <div class="btnLogin">
            <button class="btnLogin" type="submit" name="btningresar" value="Ingresar">Ingresar</button>
        </div>
      </form>
      <?php if (!empty($mensajeError)): ?>
          <div class="error-mensaje" style="color: red; margin-top: 15px; text-align: center; font-size: 0.9rem;">
              <?php echo $mensajeError; ?>
          </div>
      <?php endif; ?>
    </div>
  </main>
</body>
</html>