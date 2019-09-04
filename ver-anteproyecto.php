<?php
  session_start();
  if ($_SESSION['login'] == '') {
    header("location: index.php");
  } else {
    $usuario = $_SESSION['login'];
    $admin   = $_SESSION['admin'];
    $tituloPagina = "Anteproyectos en proceso";
    include_once "php/header.php";
?>

<!-- Encabezado de página -->
<?php include_once "php/header2.php"; ?>

<div class="form-row">
  <div class="col-5">
  <label class="sr-only" for="filtro">Filtro</label>
    <div class="input-group mb-2">
      <div class="input-group-prepend">
        <div class="input-group-text"><i class="fas fa-filter"></i>&nbsp;Filtrar</div>
      </div>
      <input type="text" class="form-control" id="filtro">
  </div>
</div>
<div class="row m-1">
  <table class="table table-striped table-bordered table-hover table-condensed table-sm">
    <thead class="bg-dark text-white">
      <tr>
        <th class="text-center">Folio</th>
        <th class="text-center">Nombre</th>
        <th class="text-center">Tesista 1</th>
        <th class="text-center">Tesista 2</th>
        <th class="text-center">Cuerpo académico</th>
        <th class="text-center">Estatus</th>
        <th class="text-center">Operaciones</th>
      </tr>
    </thead>
    <tbody id="tabla">
      <?php
        require_once 'php/bd.php';
        require_once 'php/tesista.php';
        require_once 'php/cuerpo_academico.php';
        $pdo = BaseDeDatos::conectar();
        $sql = "SELECT folio,nombre,tesista1,tesista2,director,estatus FROM tesis WHERE estatus LIKE 'F1%' OR estatus LIKE 'F2%' OR estatus LIKE 'F3%'";
        foreach ($pdo->query($sql,PDO::FETCH_ASSOC) as $registro) {
          extract($registro);
          echo "<tr>";
          echo "<td class='align-middle'>{$folio}</td>";
          echo "<td class='align-middle'>{$nombre}</td>";
          $elTesista1 = Tesista::getNombre($tesista1);
          echo "<td class='align-middle'>{$elTesista1['nombre']}</td>";
          if ( isset($tesista2) ) {
            $elTesista2 = Tesista::getNombre($tesista2);
            echo "<td class='align-middle'>{$elTesista2['nombre']}</td>";
          } else {
            echo "<td class='align-middle text-center'>—</td>";
          }
          /*$cons = $pdo->query("SELECT nombre FROM cuerpo_academico WHERE clave=(
                                SELECT cuerpo_academico FROM profesor WHERE clave='{$director}' LIMIT 1)",PDO::FETCH_ASSOC);
          $ca = $cons->fetchColumn();*/
          $ca = CuerpoAcademico::getCuerpoAcademico($director);
          echo "<td class='align-middle'>{$ca}</td>";
          echo "<td class='align-middle text-center font-weight-bold'>{$estatus}</td>";
          /*$mijson = json_encode($registro, JSON_PRETTY_PRINT);
          $mijson= str_replace('"', "*", $mijson);
          $mijson= str_replace('{', "+", $mijson);
            $mijson= str_replace('}', "+", $mijson);
          echo "<td>{$mijson}</td>";*/
          echo "<td class='align-middle text-center table-fit'>";
          echo "<button class='btn btn-info' alt='Ver detalles del anteproyecto' onclick='mostrarDetalles(\"{$folio}\")'>
                  <!--&nbsp;<i class='fas fa-info'></i>&nbsp;-->
                  <i class='fas fa-info-circle'></i>&nbsp;
                  Detalles
                </button>
                &nbsp;";
          $fSiguiente = "";
          switch ($estatus) {
            case "F1": $fSiguiente = "f2";
                      break;
            case "F2": $fSiguiente = "f3";
                      break;
            case "F3-A": $fSiguiente = "f3";
                      break;
            case "F3": $fSiguiente = "f4";
                      break;
          }
          echo "<a href='{$fSiguiente}.php?folio={$folio}&sender=ver-anteproyecto&label=Anteproyectos' class='btn btn-info'>
                  <i class='fas fa-edit'></i>&nbsp;
                  Capturar <strong>" . strtoupper($fSiguiente) . "</strong></a>";
          //echo "<a href='{$fSiguiente}.php?folio={$folio}&sender=ver-anteproyecto&label=Anteproyectos' class='btn btn-info'>
          //        <i class='fas fa-edit'></i>Bitácora</a>";
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
  $(document).ready(function(){
    $("#filtro").on("keyup", function() {
      var value = $(this).val().toLowerCase();
      $("#tabla tr").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
      });
    });
  });
</script>

<script src="js/dialogos.js"></script>

<!-- Pie de página -->
<?php
    include_once "php/footer.php";
  }
?>
