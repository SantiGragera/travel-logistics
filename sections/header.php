<?php
$nombreUsuario = $_SESSION['nombre']; 
$idNivelUsuario = $_SESSION['id_nivel'];
$imagenUsuario = $_SESSION['imagen'];
?>

<header class="mainHeader">
    <div class="containerHeader">
      <a class="anchorHeader" href="./index.php">
        <div class="logo-area">
            <i class="bi bi-truck"></i>
            <span class="brand-name">Travel Logistics</span>
        </div>
      </a>


        <nav class="navHeader">
          <ul>
            <li><a href="index.php">Panel</a></li>
            
            <?php if ($idNivelUsuario == 1 || $idNivelUsuario == 2) { ?>
              <li><a href="./camion_listado.php">Camiones</a></li>
              <li><a href="./chofer_listado.php">Choferes</a></li>
            <?php } ?>
            
            <li><a href="./viajes_listado.php">Viajes</a></li>
          </ul>
        </nav>
        <div class="user-profile-mini">
          <img src="https://ui-avatars.com/api/?name=<?php echo $nombreUsuario; ?>&background=random" alt="Profile" class="avatar-header">
          <div class="profile-dropdown">
              <a href="sections/cerrarSesion.php">Cerrar Sesión</a>
          </div>
        </div>
        </div>
    </div>
</header>