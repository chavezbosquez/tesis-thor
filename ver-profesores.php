<!-- Encabezado de página -->
<?php
  $tituloPagina = "Directorio de profesores";
  include_once "php/header.php";
?>
<!-- Encabezado de página -->

  <main role="main" class="card container container-fluid body-content rounded p-4">
    <div class="clearfix">
      <h2 class="float-left">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb" style="background-color: white; padding: 0; margin:0">
            <li class="breadcrumb-item">
              <a href="index.php"><i class="fas fa-hammer"></i></a>
            </li>
            <li class="breadcrumb-item" aria-current="page">Directorio de profesores</li>
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
            $sql = "SELECT * FROM profesor ORDER BY nombre";
            foreach ($pdo->query($sql,PDO::FETCH_ASSOC) as $registro) {
              extract($registro);
              echo "<tr>";
              echo "<td class='align-middle'>{$grado}</td>";
              $nombreCompleto = $nombre   . " " . $apellidos;
              echo "<td class='text-dark font-weight-bold align-middle table-fit'>";
              echo //"<a href='#' data-toggle='modal' data-target='#fotoModal' data-clave='{$clave}' data-nombre='{$nombreCompleto}'>
                      "{$nombreCompleto}";
                    //</a>";
              echo "</td>";
              echo "<td class='align-middle'>{$cubiculo}</td>";
              echo "<td class='text-monospace align-middle' style='font-size:15px'>{$correo}</td>";
              $cons = $pdo->query("SELECT nombre FROM cuerpo_academico WHERE clave='{$cuerpo_academico}' LIMIT 1",PDO::FETCH_ASSOC);
              $ca = $cons->fetchColumn();
              if ($ca == "Ninguno") {
                echo "<td class='text-center align-middle'>—</td>";
              } else {
                echo "<td class='align-middle'>{$ca}</td>";
              }
              echo "<td class='text-center align-middle'>{$estatus}</td>";
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