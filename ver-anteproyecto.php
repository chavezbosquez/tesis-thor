<?php
  session_start();
  if ($_SESSION['login'] == '') {
    header("location: index.php");
  } else {
    $usuario = $_SESSION['login'];
    $tituloPagina = "Anteproyectos en proceso";
    include_once "php/header.php";
?>

<!-- Encabezado de página -->
<?php include_once "php/header2.php"; ?>

<div class="row">
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
        require_once 'php/cuerpo_academico.php';
        $pdo = BaseDeDatos::conectar();
        $sql = "SELECT folio,nombre,tesista1,tesista2,director,estatus FROM tesis WHERE estatus LIKE 'F1%' OR estatus LIKE 'F2%' OR estatus LIKE 'F3%'";
        foreach ($pdo->query($sql,PDO::FETCH_ASSOC) as $registro) {
          extract($registro);
          echo "<tr>";
          echo "<td>{$folio}</td>";
          echo "<td>{$nombre}</td>";
          echo "<td>{$tesista1}</td>";
          if ( isset($tesista2) ) {
            echo "<td>{$tesista2}</td>";
          } else {
            echo "<td class='text-center'>—</td>";
          }
          /*$cons = $pdo->query("SELECT nombre FROM cuerpo_academico WHERE clave=(
                                SELECT cuerpo_academico FROM profesor WHERE clave='{$director}' LIMIT 1)",PDO::FETCH_ASSOC);
          $ca = $cons->fetchColumn();*/
          $ca = CuerpoAcademico::getCuerpoAcademico($director);
          echo "<td>{$ca}</td>";
          echo "<td class='text-center font-weight-bold'>{$estatus}</td>";
          /*$mijson = json_encode($registro, JSON_PRETTY_PRINT);
          $mijson= str_replace('"', "*", $mijson);
          $mijson= str_replace('{', "+", $mijson);
            $mijson= str_replace('}', "+", $mijson);
          echo "<td>{$mijson}</td>";*/
          echo "<td class='text-center table-fit'>";
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

<script src="js/dialogos.js"></script>

<!-- Pie de página -->
<?php
    include_once "php/footer.php";
  }
?>
