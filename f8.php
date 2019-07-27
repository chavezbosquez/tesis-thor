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
    $sender = $_GET['sender'] . '.php';
    $label  = $_GET['label'];
    $tituloPagina = "F8 - Respuesta del jurado";
    
    include_once "php/header.php";

    require_once 'php/profesor.php';
    require_once 'php/tesis.php';

    $laTesis = Tesis::getDatosF8($folio);

    /* Una validación muy simple por si un usuario malintencionado escribe una URL con un folio inexistente */
    if ( !isset($laTesis['nombre']) ) {
      header("location: inicio.php");
    }
    
    $elJurado1 = Profesor::getDatosProfesor($laTesis['jurado1']);
    $elJurado2 = Profesor::getDatosProfesor($laTesis['jurado2']);
    $elJurado3 = Profesor::getDatosProfesor($laTesis['jurado3']);
    $elJurado4 = Profesor::getDatosProfesor($laTesis['jurado4']);
    $elJurado5 = Profesor::getDatosProfesor($laTesis['jurado5']);
?>
<!-- Encabezado de página -->

<?php include_once "php/header2.php"; ?>

<div class="row">
  <div class="col-sm-8">
    <div class="alert alert-info font-weight-bold" role="alert">
      Datos del anteproyecto
    </div>
    <div class="form-group row">
      <div class="col-sm-2 text-right">
        <i class="fas fa-info-circle"></i>
      </div>
      <div class="col-sm-10">
        <?php echo "<a href='#' onclick='mostrarDetalles(\"{$folio}\")'>Ver detalles de la tesis</a>" ?>
      </div>
    </div>
    <div class="form-group row">
      <label for="nombre" class="font-weight-bold col-sm-2 col-form-label">Nombre</label>
      <div class="col-sm-10">
        <textarea class="form-control" id="nombre" name="nombre" readonly><?php echo $laTesis['nombre']; ?></textarea>
      </div>
    </div>
  </div>
</div>

<!-- Ocultar dependiendo si ya se han capturado los oficios del Jurado -->
<form name="f8a" method="post" action="f8-action.php" enctype="multipart/form-data" <?php if ($laTesis['estatus'] == "F8-A") echo "style='display: none;'"; ?>>
  <input type="hidden" id="folio" name="folio" value ="<?php echo $folio; ?>">
  <input type="hidden" id="estatus" name="estatus" value ="<?php echo $laTesis['estatus']; ?>">
  <div class="row">
    <div class="col-sm-8">
      <div class="alert alert-info font-weight-bold" role="alert">
        1. Oficios del Jurado
      </div>
      <div class="form-group row">
        <label for="archivo1" class="font-weight-bold col-sm-4 col-form-label">
          <?php echo $elJurado1['nombre']; ?>
        </label>
        <div class="col-sm-8">
          <input type="file" class="form-control-file" id="archivo1" name="archivo1" required>
        </div>
      </div>
      <div class="form-group row">
        <label for="archivo2" class="font-weight-bold col-sm-4 col-form-label">
            <?php echo $elJurado2['nombre']; ?>
        </label>
        <div class="col-sm-8">
          <input type="file" class="form-control-file" id="archivo2" name="archivo2" required>
        </div>
      </div>
      <div class="form-group row">
        <label for="archivo3" class="font-weight-bold col-sm-4 col-form-label">
            <?php echo $elJurado3['nombre']; ?>
        </label>
        <div class="col-sm-8">
          <input type="file" class="form-control-file" id="archivo3" name="archivo3" required>
        </div>
      </div>
      <div class="form-group row">
        <label for="archivo4" class="font-weight-bold col-sm-4 col-form-label">
            <?php echo $elJurado4['nombre']; ?>
        </label>
        <div class="col-sm-8">
          <input type="file" class="form-control-file" id="archivo4" name="archivo4" required>
        </div>
      </div>
      <div class="form-group row">
        <label for="archivo5" class="font-weight-bold col-sm-4 col-form-label">
            <?php echo $elJurado5['nombre']; ?>
        </label>
        <div class="col-sm-8">
          <input type="file" class="form-control-file" id="archivo5" name="archivo5" required>
        </div>
      </div>
    </div>
    <div class="col-sm-4">
      <div class=" row">
        <div class="col-sm-3"></div>
        <div class="col-sm-8">
          <button type="submit" class="btn btn-primary btn-block" name="guardar">
            <i class="fas fa-save">&nbsp;</i>
            Guardar
          </button>
          <a href="<?php echo $sender; ?>" class="btn btn-secondary btn-block">
            <i class="fas fa-times">&nbsp;</i>
            Cancelar
          </a>
        </div>
      </div>
    </div><!-- class="col-sm-4" -->
  </div><!-- class="row" -->
  <hr>
 </form>

<form name="f8" method="post" action="f8-action.php" enctype="multipart/form-data" onsubmit="return validarF8();">
  <input type="hidden" id="folio" name="folio" value ="<?php echo $folio; ?>">
  <input type="hidden" id="estatus" name="estatus" value ="<?php echo $laTesis['estatus']; ?>">
  <div class="row mt-2">
    <div class="col-sm-8">
    <?php if ($laTesis['estatus'] == "F7") { ?>
      <div class="alert alert-danger" role="alert">
        <strong>2. Respuesta del Jurado</strong>
        <br>
        Primero debes guardar los oficios de asignación del Jurado
      </div>
    <?php } else { ?>
      <div class="alert alert-info font-weight-bold" role="alert">
        Respuesta del Jurado
      </div>
    <?php } ?>
      <div class="form-group row">
        <label for="archivo6" class="font-weight-bold col-sm-4 col-form-label">Formato F8</label>
        <div class="col-sm-8">
          <input type="file" class="form-control-file" id="archivo6" name="archivo6" required>
        </div>
      </div>
      <div class="form-group row">
      <label for="fecha" class="font-weight-bold col-sm-4  col-form-label">Fecha</label>
      <div class="col-sm-4">
        <input type="date" class="form-control" id="fecha" name="fecha" required>
      </div>
    </div>
    </div>
    <div class="col-sm-4">
      <div class=" row">
        <div class="col-sm-3"></div>
        <div class="col-sm-8">
        <button type="submit" class="btn btn-primary btn-block" name="guardar">
          <i class="fas fa-save">&nbsp;</i>
          Guardar
        </button>
        <a href="<?php echo $sender; ?>" class="btn btn-secondary btn-block">
          <i class="fas fa-times">&nbsp;</i>
          Cancelar
        </a>
      </div>
    </div>
    </div>
  </div>
 </form>
</main>
  
<script>
  /* Mostrar la fecha de hoy */
  document.getElementById('fecha').valueAsDate = new Date();

  /* Antes de enviar el F3 verificar que existan los oficios de Comisión Revisora */
  function validarF8() {
    <?php
      if ($laTesis['estatus'] == "F7") {
        echo "bootbox.alert('<h3>Error</h3>Primero debes capturar los oficios de asignación del Jurado respectivamente firmados.');";
        echo "return false;";
      }
    ?>
  }
</script>

<script src="js/dialogos.js"></script>

<!-- Pie de página -->
<?php
    include_once "php/footer.php";
  }
?>
