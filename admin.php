<?php
  session_start();
  if ($_SESSION['login'] == '' || $_SESSION['admin'] != 1) {
    header("location: index.php");
  } else {
    $usuario = $_SESSION['login'];
    $admin   = $_SESSION['admin'];
    $tituloPagina = "Administración de THOR";
    include_once "php/header.php";

    require_once 'php/usuario.php';
    $listaUsuarios = Usuario::getUsuarios();
?>

<!-- Encabezado de página -->
<?php include_once "php/header2.php"; ?>

<div class="clearfix m-1">
    <h4 class="float-left">Usuarios</h4>
    <button class="btn btn-info float-right disabled">Nuevo usuario</button>
  </div>
<div class="row m-1">
  <table class="table table-striped table-bordered table-hover table-condensed table-sm">
    <thead>
      <tr>
        <th class="text-center">Usuario</th>
        <th class="text-center">Contraseña</th>
        <th class="text-center">Nombre</th>
        <th class="text-center">Fecha de alta</th>
        <th class="text-center">Activo</th>
        <!--<th class="text-center">Admin</th>-->
        <th class="text-center">Opciones</th>
      </tr>
    </thead>
    <tbody id="tabla">
      <?php
        foreach ($listaUsuarios as $usuario) {
          extract($usuario);
          echo "<tr>";
          echo "<td>{$correo}</td>";
          echo "<td class='text-white'>{$contra}</td>";
          echo "<td>{$nombreCompleto}</td>";
          $fecha = date("d-m-Y",strtotime($fecha));
          echo "<td class='text-center'>{$fecha}</td>";
          if ( strcasecmp($estatus,"Activo") == 0 ) {
            echo "<td class='text-center'>Sí</td>";
          } else {
            echo "<td class='text-center'>No</td>";
          }
          //echo "<td>{$administrador}</td>";
          echo "<td class='text-center'><button class='btn btn-sm btn-danger'>Dar de baja</button></td>";
          echo "</tr>";
        }
        BaseDeDatos::desconectar();
      ?>
    </tbody>
  </table>
</div>
<p></p>
<fieldset class="m-1 border p-2 pb-3">
  <legend class="w-auto">Operaciones avanzadas</legend>
  <button class="btn btn-success disabled">Sincronizar THOR</button>
</fieldset>
</main>

<script src="js/dialogos.js"></script>

<!-- Pie de página -->
<?php
    include_once "php/footer.php";
  }
?>
