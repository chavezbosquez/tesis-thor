<?php
  session_start();
  if ($_SESSION['login'] == '' || $_SESSION['admin'] != 1) {
    header("location: index.php");
  } else {
    require_once 'php/utils.php';
    $tituloPagina = "Administración de THOR";
    
    include_once "php/header.php";
    
    require_once 'php/usuario.php';
    $listaUsuarios = Usuario::getUsuarios();
?>

<!-- Encabezado de página -->
<?php include_once "php/header2.php"; ?>

<!--<div class="clearfix m-1">-->
    <h4 class="float-left">Usuarios</h4>
    <!--<button class="btn btn-info float-right disabled">Nuevo usuario</button>
  </div>-->
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
          $activar = false;
          echo "<tr>";
          echo "<td class='align-middle'>{$correo}</td>";
          echo "<td class='align-middle text-white'>{$contra}</td>";
          echo "<td class='align-middle'>{$nombreCompleto}</td>";
          $fecha = date("d-m-Y",strtotime($fecha));
          echo "<td class='align-middle text-center'>{$fecha}</td>";
          if ( strcasecmp($estatus,Utils::$ACTIVO) == 0 ) {
            echo "<td class='align-middle text-center'>Sí</td>";
            $activar = false;
            echo "<td class='align-middle text-center'><a href='php/activar-usuario.php?usuario={$correo}&activar={$activar}' class='btn btn-sm btn-danger'>Dar de baja</a></td>";
          } else {
            echo "<td class='align-middle text-center'>No</td>";
            $activar = true;
            echo "<td class='align-middle text-center'>—</td>";
          }
          //echo "<td>{$administrador}</td>";
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
  <!--<button class="btn btn-info disabled mr-2">Nuevo usuario</button>-->
  <button class="btn btn-dark mr-2" id="actualizar">Actualizar THOR</button>
  <a href="filemanager/index.php" class="btn btn-dark">Administrador de archivos</a>
</fieldset>
</main>

<script src="js/dialogos.js"></script>
<!-- Actualizar THOR desde GitHub vía AJAX -->
<script>
    $(document).ready(function() {
      $("#actualizar").click(function() {
        $.ajax({
          url: "php/actualizar.php",
          success: function(result) {
            bootbox.alert("<h3>Sistema THOR actualizado</h3>" + 
                          "<textarea cols='47' rows='10' readonly>" +
                          result +
                          "</textarea>");
            $("#actualizar").attr("disabled", true);
        }});
      });
    });
  </script>

<!-- Pie de página -->
<?php
    include_once "php/footer.php";
  }
?>
