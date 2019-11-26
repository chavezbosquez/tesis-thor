<?php
  session_start();
  if ($_SESSION['login'] == '') {
    header("location: index.php");
  } else {
    if ( !isset($_GET['folio']) ) {
      header("location: inicio.php");
    }
    require_once 'php/utils.php';

    $folio   = $_GET['folio'];
    if ( isset($_GET['sender']) ) {
      $sender = $_GET['sender'] . '.php';
      $label  = $_GET['label'];
    }
    $tituloPagina = "F4 - Solicitud de director";
    
    include_once "php/header.php";

    require_once 'php/profesor.php';
    require_once 'php/tesis.php';
    
    $laTesis = Tesis::getDatosF4($folio);

    /* Una validación muy simple por si un usuario malintencionado escribe una URL con un folio inexistente */
    if ( !isset($laTesis['nombre']) ) {
      header("location: inicio.php");
    }
    
    $elDirector = Profesor::getDatosProfesor($laTesis['director']);
    $hayCodirector = isset($laTesis['codirector']);
    if ($hayCodirector) {
      $elCodirector = Profesor::getDatosProfesor($laTesis['codirector']);
    }
?>
<!-- Encabezado de página -->

<?php include_once "php/header2.php"; ?>

<form name="f4" method="post" action="f4-action.php" enctype="multipart/form-data">
  <input type="hidden" id="folio"         name="folio"         value ="<?php echo $folio; ?>">
  <input type="hidden" id="hayCodirector" name="hayCodirector" value ="<?php echo $hayCodirector; ?>">
  <div class="row">
    <div class="col-sm-8">
      <div class="alert alert-dark font-weight-bold" role="alert">
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
      <div class="alert alert-info font-weight-bold mt-4" role="alert">
        Oficios de solicitud y asignación de director
      </div>
      <div class="form-group row">
        <label for="archivo1" class="font-weight-bold col-sm-5 col-form-label">
          Oficio de solicitud
        </label>
        <div class="col-sm-7">
          <input type="file" class="form-control-file" id="archivo1" name="archivo1" accept="application/pdf" required>
        </div>
      </div>
      <div class="form-group row">
        <label for="archivo2" class="col-sm-5 col-form-label">
          <strong><?php echo $elDirector['nombre']; ?></strong>
          <br>
          Director de tesis
        </label>
        <div class="col-sm-7">
          <input type="file" class="form-control-file" id="archivo2" name="archivo2" accept="application/pdf" required>
        </div>
      </div>
      <?php if ($hayCodirector) { ?>
      <div class="form-group row">
        <label for="archivo3" class="col-sm-5 col-form-label">
          <strong><?php echo $elCodirector['nombre']; ?></strong>
          <br>
          Codirector
        </label>
        <div class="col-sm-7">
          <input type="file" class="form-control-file" id="archivo3" name="archivo3" accept="application/pdf" required>
        </div>
      </div>
      <?php } ?>
      <div class="form-group row">
        <label for="fecha" class="font-weight-bold col-sm-5 col-form-label">Fecha</label>
        <div class="col-sm-4">
          <input type="date" class="form-control" id="fecha" name="fecha" required>
        </div>
      </div>
      <div class="form-group row">
        <div class="col-sm-5"></div>
        <div class="col-sm-7 alert alert-danger" role="alert">
          <strong>Importante</strong>:
          <br>
          A partir de esta fecha resta un año para titularse.
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
