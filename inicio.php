<?php
  session_start();
  if ($_SESSION['login'] == '') {
    header("location: index.php");
  } else {
    $usuario = $_SESSION['login'];
    $admin   = $_SESSION['admin'];
    $tituloPagina = "Inicio";
    include_once "php/header.php";
    include_once "php/header2.php";
?>
<!-- Encabezado de página -->

<!--<p class="float-right mr-2">
      <a class=" btn-success btn-sm" id="start-help" href="#" title="Ayuda">
        <i class="fas fa-question-circle"></i>
      </a>
    </p>
    -->
  <div class="row">
    <div class="col-sm-3">
      <div class="card bg-primary">
        <div id="div-tema" class="card-header text-white">
          Temas de tesis
        </div>
        <ul class="list-group list-group-flush">
          <li id="li-nuevo-anteproyecto" class="list-group-item"><a href="f1.php">Nuevo anteproyecto</a></li>
          <li id="li-ver-anteproyecto" class="list-group-item"><a href="ver-anteproyecto.php">Listado de anteproyectos</a></li>
          <li id="li-estadisticas" class="list-group-item"><a href="#" class="btn-link disabled">Estadísticas</a></li>
        </ul>
      </div>
    </div>
    <!-- -->
    <div class="col-sm-3">
      <div class="card bg-danger">
        <div id="div-seguimiento" class="card-header text-white">
          Seguimiento de tesis
        </div>
        <ul class="list-group list-group-flush">
          <li class="list-group-item"><a href="ver-tesis.php">Tesis en proceso</a></li>
          <li class="list-group-item"><a href="#" class="btn-link disabled">Estadísticas</a></li>
        </ul>
      </div>
    </div>
    <div class="col-sm-3">
      <div class="card bg-warning">
        <div class="card-header">
          Consultas 
        </div>
        <ul class="list-group list-group-flush">
          <li id="li-buscar" class="list-group-item"><a href="#" id="show-mati">Buscar por matrícula</a></li>
          <li id="li-tesis-proceso" class="list-group-item"><a href="#" id="show-foli">Buscar por folio</a></li>
        </ul>
      </div>
    </div>
    <div class="col-sm-3">
      <div class="card bg-secondary">
        <div id="div-miscelanea" class="card-header text-white">
          Miscelánea 
        </div>
        <ul class="list-group list-group-flush">
          <li id="li-formatos" class="list-group-item"><a href="formatos.php">Ver formatos</a></li>
          <li class="list-group-item"><a href="ver-profesores.php">Directorio de profesores</a></li>
          <li id="li-profesores" class="list-group-item"><a href="ayuda.php">Ayuda del Sistema THOR</a></li>
        </ul>
      </div>
    </div>
    <?php if ($admin) { ?>
      <!--<div class="col-sm-3">
        <div class="card bg-warning">
          <div id="div-admin" class="card-header">
            Administración del sistema
          </div>
          <ul class="list-group list-group-flush">
            <li id="li-usuarios" class="list-group-item"><a>Listado de usuarios</a></li>
            <li id="li-modificar-tesis" class="list-group-item"><a>Modificar tesis</a></li>
          </ul>
        </div>
      </div>-->
    <?php } ?>
  </div><!-- row -->
  <p>
    <br>
  </p>
  <div class="col-sm-12">
    <span class="lead"><strong>Tesis concluídas</strong></span>
    <table id="table-tesis-concluidas" class="table table-striped table-bordered table-hover table-condensed table-sm">
      <thead class="bg-dark text-white">
        <tr>
          <th class="text-center">Nombre</th>
          <th class="text-center">Tesista 1</th>
          <th class="text-center">Tesista 2</th>
          <th class="text-center">Cuerpo académico</th>
        </tr>
      </thead>
      <tbody id="tabla">
        <?php
          require_once 'php/bd.php';
          require_once 'php/tesista.php';
          require_once 'php/cuerpo_academico.php';
          $pdo = BaseDeDatos::conectar();
          $sql = "SELECT folio,nombre,tesista1,tesista2,director,estatus 
                  FROM tesis 
                  WHERE estatus LIKE 'FF'";
          foreach ($pdo->query($sql,PDO::FETCH_ASSOC) as $registro) {
            extract($registro);
            echo "<tr>";
            echo "<td>
                    <a href='#' onclick='mostrarDetalles(\"{$folio}\",\"Tesis\")' title='Ver detalle de la tesis'>
                      <i class='fas fa-info-circle'></i> {$nombre}
                    </a>
                  </td>";
            $elTesista1 = Tesista::getNombre($tesista1);
            echo "<td>{$elTesista1['nombre']}</td>";
            if ( isset($tesista2) ) {
              $elTesista2 = Tesista::getNombre($tesista2);
              echo "<td>{$elTesista2['nombre']}</td>";
            } else {
              echo "<td class='text-center'>—</td>";
            }
            $cuerpoAcademico = CuerpoAcademico::getCuerpoAcademico($director);
            echo "<td class='text-center'>{$cuerpoAcademico}</td>";
            echo "</td>";
            echo "</tr>";
          }
          BaseDeDatos::desconectar();
        ?>
      </tbody>
    </table>
  </div>
</main>

<script>
  $(document).on("click", "#show-mati", function(e) {
    bootbox.prompt({
      size: "small",
      title: "Matrícula del tesista",
      buttons: {
        confirm: {
            label: 'Buscar',
            className: 'btn-info'
        },
        cancel: {
            label: 'Cancelar'
        }
      },
      callback: function(result) {
        if (result != null) {
          location.href = "php/tesista-adrian.php?matricula=" + result;
        }
      }
    });
  });
</script>

<script>
  $(document).on("click", "#show-foli", function(e) {
    bootbox.prompt({
      size: "medium",
      title: "Folio del anteproyecto o tesis",
      buttons: {
        confirm: {
            label: 'Buscar',
            className: 'btn-info'
        },
        cancel: {
            label: 'Cancelar'
        }
      },
      callback: function(result) {
        if (result != null) {
          location.href = "php/tesista-adrian.php?folio=" + result;
        }
      }
    });
  });
</script>

<script src="js/dialogos.js"></script>

<!--Bootstrap tour
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tour/0.11.0/css/bootstrap-tour-standalone.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tour/0.11.0/js/bootstrap-tour-standalone.min.js"></script>
<script src="js/help-tour-inicio.js"></script>
-->

<!-- Pie de página -->
<?php
    include_once "php/footer.php";
    /* Error al consultar una matrícula */
    if ( isset($_GET['error']) ) {
      $error = $_GET['error'];
      if ($error == "1") {  /* No existe matrícula */
        $matricula = $_GET['matricula'];
        echo "<script> 
                  bootbox.alert('¡No existe tesis asociada a la matrícula <strong>{$matricula}</strong>!'); 
              </script>";
      } else if ($error == "2") { /* Tesis concluída */
        $tesis = $_GET['tesis'];
        echo "<script> 
                  bootbox.alert('La tesis <strong>{$tesis}</strong> ha concluido. Revise los detalles de la tesis en la tabla de Tesis concluídas.');
              </script>";
      } else if ($error == "3") { /* No existe el folio */
        $folio = $_GET['folio'];
        echo "<script> 
                  bootbox.alert('¡No existe tesis con folio <strong>{$folio}</strong>!');
              </script>";
      }
    }
  }
?>
