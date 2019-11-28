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
    $tituloPagina = "FF - Formatos Finales";
    
    include_once "php/header.php";

    require_once 'php/tesis.php';
    
    $laTesis = Tesis::getDatosF4($folio);

    /* Una validación muy simple por si un usuario malintencionado escribe una URL con un folio inexistente */
    if ( !isset($laTesis['nombre']) ) {
      header("location: inicio.php");
    }
?>
<!-- Encabezado de página -->

<?php include_once "php/header2.php"; ?>

<form name="ff" method="post" action="ff-action.php" enctype="multipart/form-data">
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
      <div class="alert alert-info font-weight-bold" role="alert">
        Oficios de autorización
      </div>
      <div class="form-group row">
        <label for="archivo1" class="font-weight-bold col-sm-4 col-form-label">
          Liberación del Jurado
        </label>
        <div class="col-sm-8">
          <input type="file" class="form-control-file" id="archivo1" name="archivo1" accept="application/pdf" required>
        </div>
      </div>
      <div class="form-group row">
        <label for="archivo2" class="font-weight-bold col-sm-4 col-form-label">
          Autorización de impresión
        </label>
        <div class="col-sm-8">
          <input type="file" class="form-control-file" id="archivo2" name="archivo2" accept="application/pdf" required>
        </div>
      </div>
      <div class="form-group row">
        <label for="fecha" class="font-weight-bold col-sm-4 col-form-label">Fecha</label>
        <div class="col-sm-4">
          <input type="date" class="form-control" id="fecha" name="fecha" required>
        </div>
      </div>
        <div class="form-group row">
          <div class="col-sm-4"></div>
          <div class="col-sm-8 alert alert-danger" role="alert">
            <strong>Importante</strong>:<br> A partir de esta fecha restan 6 meses para titularse.
          </div>
        </div>
    </div>
    <div class="col-sm-4">
      <div class=" row">
        <div class="col-sm-3"></div>
        <div class="col-sm-8">
          <button type="submit" class="btn btn-primary btn-block" name="guardar"
                  <? if (Utils::isSoloLectura()) echo "disabled title='Usuario de solo lectura'"; ?>>
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
