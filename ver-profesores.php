<?php
  session_start();
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="author" content="Verano de Código 2019">
  <title>Sistema THOR 2019</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css"
    integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css"
    integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
  <link rel="stylesheet" href="css/estylo.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</head>

<body role="document">
  <header>
    <div class="jumbotron display-4 text-white rounded-0">
      <div class="container pull-left">
        <img class="img-fluid" src="img/banner.png">
      </div>
    </div>
  </header>
  <main role="main" class="card container container-fluid body-content rounded p-4">
    <div class="clearfix">
      <h2 class="float-left">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb" style="background-color: white; padding: 0; margin:0">
            <li class="breadcrumb-item">
              <a href="index.php"><i class="fas fa-hammer"></i></a>
            </li>
            <li class="breadcrumb-item" aria-current="page">Búsqueda de profesores</li>
          </ol>
        </nav>
      </h2>
    </div>
    <hr>
    <div class="row p-3">
      <p>
        Filtrar tabla: <input class="" id="filtro" type="text" placeholder="Buscar..">
      </p>
      <table class="table table-striped table-bordered table-hover table-condensed table-sm">
        <thead class="bg-warning ">
          <th class="text-center">Grado</th>
            <th class="text-center">Nombre completo</th>
            <th class="text-center">Cubículo</th>
            <th class="text-center">Correo electrónico</th>
            <th class="text-center">Cuerpo académico</th>
            <th class="text-center">Estatus</th>
          </tr>
        </thead>
        <tbody id="tabla">
          <?php
            require_once 'php/bd.php';
            $pdo = BaseDeDatos::conectar();
            $sql = "SELECT * FROM profesor";
            foreach ($pdo->query($sql,PDO::FETCH_ASSOC) as $registro) {
              extract($registro);
              echo "<tr>";
              echo "<td>{$grado}</td>";
              $nombreCompleto = $nombre   . " " . $apellidos;
              echo "<td>";
              echo "<a href='#' data-toggle='modal' data-target='#fotoModal' data-clave='{$clave}' data-nombre='{$nombreCompleto}'>
                      {$nombreCompleto}
                    </a>";
              echo "</td>";
              echo "<td>{$cubiculo}</td>";
              echo "<td class='text-monospace'>{$correo}</td>";
              $cons = $pdo->query("SELECT nombre FROM cuerpo_academico WHERE clave='{$cuerpo_academico}' LIMIT 1",PDO::FETCH_ASSOC);
              $ca = $cons->fetchColumn();
              echo "<td>{$ca}</td>";
              echo "<td class='text-center'>{$estatus}</td>";
              echo "</tr>";
            }
            BaseDeDatos::desconectar();
          ?>
        </tbody>
      </table>
    </div>
  </main>

  <div class="modal fade" id="fotoModal" tabindex="-1" role="dialog" aria-labelledby="fotoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h6 class="modal-title" id="fotoModalLabel"></h6>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
        <img class="img-fluid" id="foto">
        </div>
      </div>
    </div>
  </div>

  <footer class="footer bg-success fixed-bottom">
    <p class="container pull-left small text-white"> Versión 2019.01 &nbsp; | &nbsp; División Académica de Informática y Sistemas</p>
  </footer>

  <script>
    $(document).ready(function(){
      $("#filtro").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#tabla tr").filter(function() {
          $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
      });
    });

    $('#fotoModal').on('show.bs.modal', function (event) {
      var liga = $(event.relatedTarget) // Quien lanzó el cuadro de diálogo
      var clave  = liga.data('clave') // Extraer info del atributo data-*
      var nombre = liga.data('nombre') // Extract info del atributo data-*
      var modal = $(this)
      modal.find('.modal-title').text(nombre)
      modal.find('.modal-body img').attr('src', 'img/pic/' + clave + '.jpg')
    })
  </script>

</body>

</html>