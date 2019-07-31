<?php
  session_start();
  if ($_SESSION['login'] == '') {
    header("location: index.php");
  } else {
    if ( !isset($_GET['folio']) ) {
      header("location: inicio.php");
    }
    $usuario = $_SESSION['login'];
    $admin   = $_SESSION['admin'];
    $folio  = $_GET['folio'];
    if ( isset($_GET['sender']) ) {
      $sender = $_GET['sender'] . '.php';
      $label  = $_GET['label'];
    }
    $tituloPagina = "F2 - Comisión revisora";
    
    include_once "php/header.php";
    
    /* Lista de Profesores */
    require 'php/profesor.php';
    $listaProfesores = Profesor::getprofesores();
    
    /*require_once 'php/bd.php';*/
    require_once 'php/tesis.php';
    require_once 'php/tesista.php';
    
    /*$pdo = BaseDeDatos::conectar();
    $sql = "SELECT tesis.nombre,tesista1,tesista2,
            CONCAT(tesista.nombre, ' ', tesista.apellidos) AS nombreTesista
              FROM tesis,tesista
                WHERE folio='{$folio}' AND tesista1=tesista.matricula LIMIT 1";
    $cons = $pdo->query($sql, PDO::FETCH_ASSOC);
    $registro = $cons->fetch();*/

    $laTesis = Tesis::getDatos($folio);

    /* Una validación muy simple por si un usuario malintencionado escribe una URL con un folio inexistente */
    if ( !isset($laTesis['nombre']) ) {
      header("location: inicio.php");
    }

    $hayTesista2 = isset($laTesis['tesista2']);
    if ( $hayTesista2 ) {
      $elTesista = Tesista::getDatos($laTesis['tesista2']);
    }
?>
<!-- Encabezado de página -->

<?php include_once "php/header2.php"; ?>

<form name="f2" method="post" action="f2-action.php" enctype="multipart/form-data" onsubmit="return validarFormulario();">
  <input type="hidden" id="folio"       name="folio"       value ="<?php echo $folio;?>">
  <input type="hidden" id="tesista1"    name="tesista1"    value ="<?php echo $laTesis['tesista1'];?>">
  <input type="hidden" id="tesista2"    name="tesista2"    value ="<?php echo $laTesis['tesista2'];?>">
  <input type="hidden" id="hayTesista2" name="hayTesista2" value ="<?php echo $laTesis['hayTesista2'];?>">
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
    <div class="form-group row">
      <label for="fecha" class="font-weight-bold col-sm-2 col-form-label">Fecha</label>
      <div class="col-sm-4">
        <input type="date" class="form-control" id="fecha" name="fecha" required>
      </div>
    </div>
    <div class="form-group row">
      <label for="archivo" class="font-weight-bold col-sm-2 col-form-label">Archivo PDF</label>
      <div class="col-sm-10">
        <input type="file" class="form-control-file" id="archivo" name="archivo" accept="application/pdf" required>
      </div>
    </div>
    <div class="alert alert-info font-weight-bold mt-5" role="alert">
      Integrantes de la Comisión Revisora
    </div>
    <div class="form-group row">
      <label for="revisor1" class="col-sm-3 col-form-label">Revisor 1</label>
      <div class="col-sm-9">
        <select class="form-control" id="revisor1" name="revisor1" required>
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
      <label for="revisor2" class="col-sm-3 col-form-label">Revisor 2</label>
      <div class="col-sm-9">
        <select class="form-control" id="revisor2" name="revisor2" required>
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
      <label for="revisor3" class="col-sm-3 col-form-label">Revisor 3</label>
      <div class="col-sm-9">
        <select class="form-control" id="revisor3" name="revisor3" required>
          <?php
            foreach ($listaProfesores as $profesor) {
              extract($profesor);
              echo "<option value='{$clave}'>{$nombreCompleto}</option>";
            }
          ?>
        </select>
      </div>
    </div>
    <!------------------------- TESISTAS ------------------------------------->
    <div class="alert alert-info font-weight-bold mt-5" role="alert">
      Datos de los tesistas
    </div>
    <ul class="nav nav-tabs">
      <li class="nav-item" id="linkTesista1">
        <a class="nav-link active font-weight-bold" data-toggle="tab" href="#areaTesista1">Tesista 1</a>
      </li>
      <li class="nav-item" id="linkTesista2" <?php if (!$hayTesista2) echo "style='display: none;'"; ?>>
        <a class="nav-link font-weight-bold" data-toggle="tab" href="#areaTesista2">Tesista 2</a>
      </li>
    </ul>
    <!-- Primer tesista -->
    <div class="tab-content border-left border-right border-bottom pl-4 pr-4 pt-4 mb-4">
      <div class="tab-pane fade show active" id="areaTesista1" role="tabpanel" aria-labelledby="tesista1-tab">
        <div class="form-group row">
          <label for="nombre1" class="col-sm-3 col-form-label">Nombre</label>
          <div class="col-sm-9">
            <input type="text" class="form-control" id="nombre1" name="nombre1" value ="<?php echo $laTesis['nombreTesista']; ?>" readonly>
          </div>
        </div>
        <div class="form-group row">
          <label for="correo1" class="col-sm-3 col-form-label">E-mail</label>
          <div class="col-sm-9">
            <input type="email" class="form-control" id="correo1" name="correo1" required>
          </div>
        </div>
        <div class="form-group row">
          <label for="telefono1a" class="col-sm-3 col-form-label">Teléfono de casa</label>
          <div class="col-sm-5">
            <input type="text" class="form-control" id="telefono1a" name="telefono1a">
          </div>
        </div>
        <div class="form-group row">
          <label for="telefono1b" class="col-sm-3 col-form-label">Teléfono personal</label>
          <div class="col-sm-5">
            <input type="text" class="form-control" id="telefono1b" name="telefono1b">
          </div>
        </div>
        <div class="form-group row">
          <label for="domicilio1" class="col-sm-3 col-form-label">Domiclio</label>
          <div class="col-sm-9">
            <input type="text" class="form-control" id="domicilio1" name="domicilio1">
          </div>
        </div>
        <div class="form-group row">
          <label for="localidad1" class="col-sm-3 col-form-label">Localidad</label>
          <div class="col-sm-9">
            <input type="text" class="form-control" id="localidad1" name="localidad1">
          </div>
        </div>
      </div>
      <!-- Segundo tesista -->
      <div class="tab-pane fade" id="areaTesista2" role="tabpanel" aria-labelledby="tesista2-tab">
        <div class="form-group row">
          <label for="nombre2" class="col-sm-3 col-form-label">Nombre</label>
          <div class="col-sm-9">
            <input type="text" class="form-control" id="nombre2" name="nombre2" value ="<?php echo $elTesista['nombre']; ?>" readonly>
          </div>
        </div>
        <div class="form-group row">
          <label for="correo2" class="col-sm-3 col-form-label">E-mail</label>
          <div class="col-sm-9">
            <input type="email" class="form-control" id="correo2" name="correo2" <?php if ($hayTesista2) echo "required"; ?>>
          </div>
        </div>
        <div class="form-group row">
          <label for="telefono2a" class="col-sm-3 col-form-label">Teléfono de casa</label>
          <div class="col-sm-5">
            <input type="text" class="form-control" id="telefono2a" name="telefono2a">
          </div>
        </div>
        <div class="form-group row">
          <label for="telefono2b" class="col-sm-3 col-form-label">Teléfono personal</label>
          <div class="col-sm-5">
            <input type="text" class="form-control" id="telefono2b" name="telefono2b">
          </div>
        </div>
        <div class="form-group row">
          <label for="domicilio2" class="col-sm-3 col-form-label">Domiclio</label>
          <div class="col-sm-9">
            <input type="text" class="form-control" id="domicilio2" name="domicilio2">
          </div>
        </div>
        <div class="form-group row">
          <label for="localidad2" class="col-sm-3 col-form-label">Localidad</label>
          <div class="col-sm-9">
            <input type="text" class="form-control" id="localidad2" name="localidad2">
          </div>
        </div>
      </div>
      </div>
      <!---------------------------------------------------------------------->
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
  
  /* Validar campos del formulario */
  function validarFormulario() {
    var email2 = document.getElementById("correo2").value;
    /*if (email2 == "") {
      bootbox.alert("<h3>Error</h3>No olvides capturar los datos del segundo tesista.");
    } else {
      document.getElementById("f2").submit();
    }*/
  }
    /*var director = document.getElementById("director");
    var seleccionado = director.selectedIndex;
    if (seleccionado < 0) {
      alert("Seleccione el director de la tesis");
      return false;
    }
    var hayExterno = document.getElementById("hayExterno");
    if (hayExterno.checked) {
      var externo = document.getElementById("externo").value;
      var institucion = document.getElementById("institucion").value;
      if (externo == "") {
        alert("Falta nombre del director externo");
        return false;
      }
      if (institucion == "") {
        alert("Falta institución del director externo");
        return false;
      }
    }
    alert("Todo bien: enviando formulario al servidor.");
    return true;
  }*/
</script>

<script src="js/dialogos.js"></script>

<!-- Pie de página -->
<?php
    include_once "php/footer.php";
  }
?>
