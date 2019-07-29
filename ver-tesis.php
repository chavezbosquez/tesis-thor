<?php
  session_start();
  if ($_SESSION['login'] == '') {
    header("location: index.php");
  } else {
    $usuario = $_SESSION['login'];
    $tituloPagina = "Tesis en proceso";
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
        $sql = "SELECT folio,nombre,tesista1,tesista2,director,estatus 
                  FROM tesis 
                  WHERE estatus LIKE 'F4%' OR estatus LIKE 'F5%' OR estatus LIKE 'F6%' 
                     OR estatus LIKE 'F7%' OR estatus LIKE 'F8%'";
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
          $ca = CuerpoAcademico::getCuerpoAcademico($director);
          echo "<td>{$ca}</td>";
          echo "<td class='text-center font-weight-bold'>{$estatus}</td>";
          echo "<td class='text-center'>";
          echo "<button class='btn btn-primary' alt='Ver detalles del anteproyecto' onclick='mostrarDetalles(\"{$folio}\",\"Tesis\")'>
                  <!--&nbsp;<i class='fas fa-info'></i>&nbsp;-->
                  <i class='fas fa-info-circle'></i>&nbsp;
                  Detalles
                </button>
                &nbsp;";
          $fSiguiente = "";
          switch ($estatus) {
            case "F4": $fSiguiente = "f5";
                      break;
            case "F5": $fSiguiente = "f6";
                      break;
            case "F6": $fSiguiente = "f7";
                      break;
            case "F7": $fSiguiente = "f8";
                      break;
            case "F8-A": $fSiguiente = "f8";
                      break;
            case "F8": $fSiguiente = "ff";
                      break;
          }
          echo "<a href='{$fSiguiente}.php?folio={$folio}&sender=ver-tesis&label=Tesis' class='btn btn-primary'>
                  <i class='fas fa-edit'></i>&nbsp;
                  Capturar <strong>" . strtoupper($fSiguiente) . "</strong></a>";
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
