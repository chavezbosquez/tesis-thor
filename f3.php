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
    $tituloPagina = "F3 - Aprobación de anteproyecto";
    
    include_once "php/header.php";

    require_once 'php/profesor.php';
    require_once 'php/tesis.php';
    // "SELECT nombre,revisor1,revisor2,revisor3,estatus FROM tesis WHERE folio='{$folio}' LIMIT 1";
    $laTesis = Tesis::getDatosF3($folio);

    /* Una validación muy simple por si un usuario malintencionado escribe una URL con un folio inexistente */
    if ( !isset($laTesis['nombre']) ) {
      header("location: inicio.php");
    }
    
    $elRevisor1 = Profesor::getDatosProfesor($laTesis['revisor1']);
    $elRevisor2 = Profesor::getDatosProfesor($laTesis['revisor2']);
    $elRevisor3 = Profesor::getDatosProfesor($laTesis['revisor3']);
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
        <?php echo "<a href='#' onclick='mostrarDetalles(\"{$folio}\")'>Ver detalles del anteproyecto</a>" ?>
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

<!-- Ocultar dependiendo si ya se han capturado los oficios de la Comisión Revisora -->
<form name="f3a" method="post" action="f3-action.php" enctype="multipart/form-data" <?php if ($laTesis['estatus'] == "F3-A") echo "style='display: none;'"; ?>>
  <input type="hidden" id="folio" name="folio" value ="<?php echo $folio; ?>">
  <input type="hidden" id="estatus" name="estatus" value ="<?php echo $laTesis['estatus']; ?>">
  <div class="row">
    <div class="col-sm-8">
      <div class="alert alert-info font-weight-bold" role="alert">
        1. Oficios de la Comisión Revisora
      </div>
      <div class="form-group row">
        <label for="archivo1" class="font-weight-bold col-sm-4 col-form-label">
          <?php echo $elRevisor1['nombre']; ?>
        </label>
        <div class="col-sm-8">
          <input type="file" class="form-control-file" id="archivo1" name="archivo1" required>
        </div>
      </div>
      <div class="form-group row">
        <label for="archivo2" class="font-weight-bold col-sm-4 col-form-label">
            <?php echo $elRevisor2['nombre']; ?>
        </label>
        <div class="col-sm-8">
          <input type="file" class="form-control-file" id="archivo2" name="archivo2" required>
        </div>
      </div>
      <div class="form-group row">
        <label for="archivo3" class="font-weight-bold col-sm-4 col-form-label">
            <?php echo $elRevisor3['nombre']; ?>
        </label>
        <div class="col-sm-8">
          <input type="file" class="form-control-file" id="archivo3" name="archivo3" required>
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

<form name="f3" method="post" action="f3-action.php" enctype="multipart/form-data" onsubmit="return validarF3();">
  <input type="hidden" id="folio" name="folio" value ="<?php echo $folio; ?>">
  <input type="hidden" id="estatus" name="estatus" value ="<?php echo $laTesis['estatus']; ?>">
  <div class="row mt-2">
    <div class="col-sm-8">
    <?php if ($laTesis['estatus'] == "F2") { ?>
      <div class="alert alert-danger" role="alert">
        <strong>2. Respuesta de la Comisión Revisora</strong>
        <br>
        Primero debes guardar los oficios de asignación de la Comisión Revisora
      </div>
    <?php } else { ?>
      <div class="alert alert-info font-weight-bold" role="alert">
        Respuesta de la Comisión Revisora
      </div>
    <?php } ?>
      <div class="form-group row">
        <label for="archivo4" class="font-weight-bold col-sm-4 col-form-label">Formato F3</label>
        <div class="col-sm-8">
          <input type="file" class="form-control-file" id="archivo4" name="archivo4" required>
        </div>
      </div>
      <div class="form-group row">
      <label for="fecha" class="font-weight-bold col-sm-4  col-form-label">Fecha</label>
      <div class="col-sm-4">
        <input type="date" class="form-control" id="fecha" name="fecha" required>
      </div>
    </div>
    </div>
    <div class="col-sm-4" <?php if ($laTesis['estatus'] == "F2") echo "style='display: none;'"; ?>>
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
  function validarF3() {
    <?php
      if ($laTesis['estatus'] == "F2") {
        echo "bootbox.alert('<h3>Error</h3>Primero debes capturar los oficios de asignación de la Comisión Revisora respectivamente firmados.');";
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
