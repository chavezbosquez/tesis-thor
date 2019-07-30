<?php
  session_start();
  if ($_SESSION['login'] == '') {
    header("location: index.php");
  } else {
    if ( !isset($_GET['folio']) ) {
      header("location: inicio.php");
    }
    $usuario = $_SESSION['login'];
    $folio  = $_GET['folio'];
    if ( isset($_GET['sender']) ) {
      $sender = $_GET['sender'] . '.php';
      $label  = $_GET['label'];
    }
    $tituloPagina = "F7 - Liberación del jurado";

    include_once "php/header.php";
    
    /* Lista de Profesores */
    require 'php/profesor.php';
    $listaProfesores = Profesor::getprofesores();

    require_once 'php/tesis.php';

    $laTesis = Tesis::getDatosF3($folio);

    /* Una validación muy simple por si un usuario malintencionado escribe una URL con un folio inexistente */
    if ( !isset($laTesis['nombre']) ) {
      header("location: inicio.php");
    }
    
?>
<!-- Encabezado de página -->

<?php include_once "php/header2.php"; ?>

<form name="f7" method="post" action="f7-action.php" enctype="multipart/form-data">
  <input type="hidden" id="folio" name="folio" value ="<?php echo $folio;?>">
  <div class="row">
    <div class="col-sm-8">
    <div class="alert alert-info font-weight-bold" role="alert">
      Datos de la tesis
    </div>
    <div class="form-group row">
      <div class="col-sm-3 text-right">
        <i class="fas fa-info-circle"></i>
      </div>
      <div class="col-sm-9">
        <?php echo "<a href='#' onclick='mostrarDetalles(\"{$folio}\")'>Ver detalles de la tesis</a>" ?>
      </div>
    </div>
    <div class="form-group row">
      <label for="nombre" class="font-weight-bold col-sm-3 col-form-label">Nombre</label>
      <div class="col-sm-9">
        <textarea class="form-control" id="nombre" name="nombre" readonly><?php echo $laTesis['nombre']; ?></textarea>
      </div>
    </div>
    <div class="form-group row">
      <label for="fecha" class="font-weight-bold col-sm-3 col-form-label">Fecha</label>
      <div class="col-sm-4">
        <input type="date" class="form-control" id="fecha" name="fecha" required>
      </div>
    </div>
    <div class="form-group row">
      <label for="archivo" class="font-weight-bold col-sm-3 col-form-label">Solicitud de jurado</label>
      <div class="col-sm-9">
        <input type="file" class="form-control-file" id="archivo" name="archivo" accept="application/pdf" required>
      </div>
    </div>
    <div class="alert alert-info font-weight-bold mt-5" role="alert">
      Integrantes del Jurado
    </div>
    <div class="form-group row">
      <label for="jurado1" class="col-sm-3 col-form-label">Jurado 1</label>
      <div class="col-sm-9">
        <select class="form-control" id="jurado1" name="jurado1" required>
          <?php
            foreach ($listaProfesores as $profesor) {
              extract($profesor);
              if ($clave == $laTesis['nombre']) {
                echo "<option value='{$clave}' selected>{$nombreCompleto}</option>";
              } else {
                echo "<option value='{$clave}'>{$nombreCompleto}</option>";
              }
            }
          ?>
        </select>
      </div>
    </div>
    <div class="form-group row">
      <label for="jurado2" class="col-sm-3 col-form-label">Jurado 2</label>
      <div class="col-sm-9">
        <select class="form-control" id="jurado2" name="jurado2" required>
          <?php
            foreach ($listaProfesores as $profesor) {
              extract($profesor);
              if ($clave == $laTesis['nombre']) {
                echo "<option value='{$clave}' selected>{$nombreCompleto}</option>";
              } else {
                echo "<option value='{$clave}'>{$nombreCompleto}</option>";
              }
            }
          ?>
        </select>
      </div>
    </div>
    <div class="form-group row">
      <label for="jurado3" class="col-sm-3 col-form-label">Jurado 3</label>
      <div class="col-sm-9">
        <select class="form-control" id="jurado3" name="jurado3" required>
          <?php
            foreach ($listaProfesores as $profesor) {
              extract($profesor);
              if ($clave == $laTesis['nombre']) {
                echo "<option value='{$clave}' selected>{$nombreCompleto}</option>";
              } else {
                echo "<option value='{$clave}'>{$nombreCompleto}</option>";
              }
            }
          ?>
        </select>
      </div>
    </div>
    <div class="form-group row">
      <label for="jurado4" class="col-sm-3 col-form-label">Jurado 4</label>
      <div class="col-sm-9">
        <select class="form-control" id="jurado4" name="jurado4" required>
          <?php
            foreach ($listaProfesores as $profesor) {
              extract($profesor);
              echo "<option value='{$clave}'>{$nombreCompleto}</option>";
            }
          ?>
        </select>
      </div>
    </div>
    <div class="form-group row">
      <label for="jurado5" class="col-sm-3 col-form-label">Jurado 5</label>
      <div class="col-sm-9">
        <select class="form-control" id="jurado5" name="jurado5" required>
          <?php
            foreach ($listaProfesores as $profesor) {
              extract($profesor);
              echo "<option value='{$clave}'>{$nombreCompleto}</option>";
            }
          ?>
        </select>
      </div>
    </div>
    </div>
      
    <div class="col-sm-4">
      <div class=" row">
        <div class="col-sm-3"></div>
        <div class="col-sm-8">
        <button type="submit" class="btn btn-primary btn-lg btn-block" name="guardar">
          <i class="fas fa-save">&nbsp;</i>
          Guardar
        </button>
        <a href="<?php echo $sender; ?>" class="btn btn-secondary btn-lg btn-block">
          <i class="fas fa-times">&nbsp;</i>
          Cancelar
        </a>
      </div>
    </div>
  </div>
</form>
</main>
  
<script>
  /* Mostrar la fecha de hoy */
  document.getElementById('fecha').valueAsDate = new Date();
</script>

<script src="js/dialogos.js"></script>

<!-- Pie de página -->
<?php
    include_once "php/footer.php";
  }
?>
