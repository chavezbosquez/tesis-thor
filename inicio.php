<?php
  session_start();
  if ($_SESSION['login'] == '') {
    header("location: index.php");
  } else {
    $usuario = $_SESSION['login'];
    $admin   = $_SESSION['admin'];
    $tituloPagina = "Inicio";
    include_once "php/header.php";
?>
<!-- Encabezado de página -->

  <main role="main" class="card container container-fluid body-content rounded p-4">
    <div class="clearfix">
      <h2 class="float-left">
        <i class="fas fa-hammer"></i>
        Inicio
      </h2>
      <p class="float-right mr-2">
        Usuario: <span class="text-danger"><?php echo $usuario; ?></span>
        <a class="btn-danger btn-sm" href="php/salir.php" title="Cerrar sesión">
        <i class="fas fa-sign-out-alt"></i>
        </a>
      </p>
    </div>
    <hr>
    <div class="row">
      <div class="col-sm-3">
        <div class="card bg-primary">
          <div class="card-header text-white">
            Temas de tesis
          </div>
          <ul class="list-group list-group-flush">
            <li class="list-group-item"><a href="f1.php">Nuevo anteproyecto</a></li>
            <li class="list-group-item"><a href="ver-anteproyecto.php">Listado de anteproyectos</a></li>
            <li class="list-group-item"><a>Estadísticas</a></li>
          </ul>
        </div>
      </div>
      <!-- -->
          <div class="col-sm-3">
          <div class="card bg-danger">
              <div class="card-header text-white">
                Seguimiento de tesis
              </div>
              <ul class="list-group list-group-flush">
                <li class="list-group-item"><a>Buscar por matrícula</a></li>
                <li class="list-group-item"><a href="ver-tesis.php">Tesis en proceso</a></li>
                <li class="list-group-item"><a>Estadísticas</a></li>
              </ul>
          </div>
          </div>
          <div class="col-sm-3">
          <div class="card bg-secondary">
              <div class="card-header text-white">
                Miscelánea 
              </div>
              <ul class="list-group list-group-flush">
                <li class="list-group-item"><a href="formatos.php">Ver formatos</a></li>
                <li class="list-group-item"><a href="ver-profesores.php?sender=inicio">Listado de profesores</a></li>
              </ul>
          </div>
        </div>
        <?php if ($admin) { ?>
        <div class="col-sm-3">
          <div class="card bg-warning">
              <div class="card-header">
                Administración del sistema
              </div>
              <ul class="list-group list-group-flush">
                <li class="list-group-item"><a>Listado de usuarios</a></li>
                <li class="list-group-item"><a>Modificar tesis</a></li>
              </ul>
          </div>
        </div>
        <?php } ?>
      <div>
</div>
        
        <div class="col-sm-12">
        <p></p>
            <span class="lead">Tesis en proceso</span>
            <table class="table table-striped table-bordered table-hover table-condensed table-sm">
                <thead class="bg-dark text-white">
                  <th class="text-center">Nombre</th>
                  <th class="text-center">Tesista 1</th>
                  <th class="text-center">Tesista 2</th>
                  <th class="text-center">Cuerpo académico</th>
                  <th class="text-center">Estatus</th>
                  <th class="text-center">Opciones</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>Selección de atributos ...</td>
                    <td>Adán Escobar</td>
                    <td>Elideth Olán</td>
                    <td class="text-center">Inteligencia Artificial</td>
                    <td class="text-center"><a href="#">F7</a></td>
                    <td>
                      <i class="fas fa-database"></i>
                      <i class="fas fa-edit"></i>
                      <i class="fas fa-pen"></i>
                    </td>
                  </tr>
                  <tr>
                    <td>Google Cloud Messaging ...</td>
                    <td>Eduardo Osorio</td>
                    <td class="text-center">—</td>
                    <td class="text-center">Sistemas Distribuidos</td>
                    <td class="text-center"><a href="#">F6</a></td>
                  </tr>
                  <tr>
                    <td>Combinación de clasificadores ...</td>
                    <td>Fred Alvarez</td>
                    <td class="text-center">—</td>
                    <td class="text-center">Inteligencia Artificial</td>
                    <td class="text-center"><a href="#">F4</a></td>
                  </tr>
                   <tr>
                    <td>Mapa 3D del Parque-Museo ...</td>
                    <td>José Alberto Díaz</td>
                    <td class="text-center">—</td>
                    <td class="text-center">Desarrollo de Software</td>
                    <td class="text-center"><a href="#">F8</a></td>
                  </tr>
                  <tr>
                    <td>Interfaz MBFOA ...</td>
                    <td>José Adrián García</td>
                    <td class="text-center">—</td>
                    <td class="text-center">Inteligencia Artificial</td>
                    <td class="text-center"><a href="#">F8</a></td>
                  </tr>
                   <tr>
                    <td>Sistema didáctico libre ...</td>
                    <td>Heidy Judith Pérez</td>
                    <td class="text-center">—</td>
                    <td class="text-center">Informática Educativa</td>
                    <td class="text-center"><a href="#">F8</a></td>
                  </tr>
                   <tr>
                    <td>Diseño de mapas interactivos...</td>
                    <td>Gabriela Rodríguez</td>
                    <td>Gerardo Alí</td>
                    <td class="text-center">Inteligencia Artificial</td>
                    <td class="text-center"><a href="#">F3</a></td>
                  </tr>
                </tbody>
            </table>
        </div>
    </div>
  </main>

<!-- Pie de página -->
<?php
  include_once "php/footer.php";
  }
?>