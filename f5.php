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
    $tituloPagina = "F5 - Asignación de calificaciones";
    
    include_once "php/header.php";

    require_once 'php/tesis.php';
    
    $laTesis = Tesis::getDatosF4($folio);

    /* Una validación muy simple por si un usuario malintencionado escribe una URL con un folio inexistente */
    if ( !isset($laTesis['nombre']) ) {
      header("location: inicio.php");
    }
    $fechaFatal = Tesis::getFechaFatal($folio);
?>
<!-- Encabezado de página -->

<?php include_once "php/header2.php"; ?>

<form name="f5" method="post" action="f5-action.php" enctype="multipart/form-data">
  <input type="hidden" id="folio" name="folio" value ="<?php echo $folio; ?>">
  <div class="row">
    <div class="col-sm-8">
      <div class="alert alert-dark font-weight-bold" role="alert">
        Datos de la tesis
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
      <div class="form-group row">
        <label for="limite" class="font-weight-bold col-sm-2 col-form-label">Fecha límite</label>
        <div class="col-sm-3">
          <input type="text" class="form-control" id="limite" name="limite" value="<?php echo $fechaFatal; ?>" readonly>
        </div>
        <label class="col-form-label text-danger font-weight-bold">Para entregar el F8</label>
      </div>
      <div class="alert alert-info font-weight-bold mt-5" role="alert">
        Oficio de asignación de calificaciones 
      </div>
      <div class="form-group row">
        <label for="archivo" class="font-weight-bold col-sm-5 col-form-label">
          Oficio del director(es) de tesis
        </label>
        <div class="col-sm-7">
          <input type="file" class="form-control-file" id="archivo" name="archivo" accept="application/pdf" required>
        </div>
      </div>
      <div class="form-group row">
        <label for="fecha" class="font-weight-bold col-sm-5 col-form-label">Fecha</label>
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
