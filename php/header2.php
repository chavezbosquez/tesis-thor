<!-- Menú de navegación global -->
<main role="main" class="card container container-fluid body-content rounded p-4">
  <div class="clearfix">
    <h2 class="float-left">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb" style="background-color: white; padding: 0; margin:0">
        <!-- La página inicio.php no tiene link hacia atrás -->
        <?php if ( $tituloPagina == "Inicio" ) { ?>
          <li class="breadcrumb-item"><i class="fas fa-hammer"></i>&nbsp;Inicio</li>
        <?php } else { ?>
          <li class="breadcrumb-item"><a href="inicio.php"><i class="fas fa-hammer"></i></a></li>
          <!-- Cuando hay una página entre inicio.php y la página actual -->
          <?php if ( isset($label) ) {
            echo "<li class='breadcrumb-item'><a href='{$sender}'>{$label}</a></li>";
          } ?> 
          <li class="breadcrumb-item" aria-current="page">
            <?php echo($tituloPagina); ?>
          </li>
        <?php } ?>
        </ol>
      </nav>
    </h2>
   <!-- Usuario actual -->
    <div class="dropdown show float-right mr-2">
      <button class="btn dropdown-toggle text-danger" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Usuario: <?php echo Utils::getUsuario(); ?>
      </button>
      <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
        <?php if (Utils::isAdmin()) { ?>
          <a class="dropdown-item" href="admin.php">
            <i class="fas fa-cogs"></i>
            Administración de THOR
          </a>
          <div class="dropdown-divider"></div>
        <?php } ?>
        <a class="dropdown-item" href="php/salir.php">
        <i class="fas fa-sign-out-alt"></i>
          Cerrar sesión
        </a>
      </div>
    </div>

  </div>
  <hr>