<?php
  session_start();
  if ($_SESSION['login'] == '' || $_SESSION['admin'] != 1) {
    header("location: index.php");
  } else {
    $usuario = $_SESSION['login'];
    $admin   = $_SESSION['admin'];
    $tituloPagina = "Administración de THOR";
    include_once "php/header.php";
?>

<!-- Encabezado de página -->
<?php include_once "php/header2.php"; ?>

<div class="row m-1">
  <h3>Usuarios de THOR</h3>
  <table class="table table-striped table-bordered table-hover table-condensed table-sm">
    <thead>
      <tr>
        <th class="text-center">Usuario</th>
        <th class="text-center">Nombre</th>
        <th class="text-center">Contraseña</th>
        <th class="text-center">Fecha de alta</th>
        <th class="text-center">Activo</th>
        <th class="text-center">Admin</th>
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
          echo "<td class='text-center table-fit'>";
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
