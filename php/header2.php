<main role="main" class="card container container-fluid body-content rounded p-4">
  <div class="clearfix">
    <h2 class="float-left">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb" style="background-color: white; padding: 0; margin:0">
          <li class="breadcrumb-item"><a href="inicio.php"><i class="fas fa-hammer"></i></a></li>
          <?php if ( isset($label) ) {
            echo "<li class='breadcrumb-item'><a href='{$sender}'>{$label}</a></li>";
          } ?> 
          <li class="breadcrumb-item" aria-current="page">
            <?php echo($tituloPagina); ?>
          </li>
        </ol>
      </nav>
    </h2>
    <p class="float-right mr-2">
      Usuario: <span class="text-danger"><?php echo $usuario; ?></span>
      <a class="btn-danger btn-sm" href="php/salir.php" title="Cerrar sesión">
        <i class="fas fa-sign-out-alt"></i>
      </a>
    </p>
  </div>
  <hr>