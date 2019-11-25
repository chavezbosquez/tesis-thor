<?php
  session_start();
  if ($_SESSION['login'] == '') {
    header("location: index.php");
  } else {
    require_once 'php/utils.php';
    $tituloPagina = "F1 - Nuevo anteproyecto";
    
    include_once "php/header.php";

    /* Lista de Cuerpos académicos */
    require_once 'php/cuerpo_academico.php';
    $listaCA = CuerpoAcademico::getCuerposAcademicos();
    
    /* Lista de Profesores */
    require_once 'php/profesor.php';
    $listaProfesores = Profesor::getProfesores();
?>
<!-- Encabezado de página -->

<?php include_once "php/header2.php"; ?>

<form name="f1" method="post" action="f1-action.php" enctype="multipart/form-data" onsubmit="return validarFormulario();">
  <div class="row">
    <div class="col-sm-8">
    <div class="alert alert-info font-weight-bold" role="alert">
      Datos del tema
    </div>
    <div class="form-group row">
      <label for="fecha" class="font-weight-bold col-sm-2 col-form-label">Fecha</label>
      <div class="col-sm-4">
        <input type="date" class="form-control" id="fecha" name="fecha" required>
      </div>
    </div>
    <div class="form-group row">
      <label for="folio" class="font-weight-bold col-sm-2 col-form-label">Folio</label>
      <div class="col-sm-4">
        <input type="text" class="form-control" id="folio" name="folio" required>
      </div>
    </div>
    <div class="form-group row">
      <label for="nombre" class="font-weight-bold col-sm-2 col-form-label">Nombre</label>
      <div class="col-sm-10">
        <textarea class="form-control" id="nombre" name="nombre"
          placeholder="Asegúrate de remover saltos de línea y caracteres extraños por favor" required></textarea>
      </div>
    </div>
    <div class="form-group row">
      <label for="archivo" class="font-weight-bold col-sm-2 col-form-label">Archivo PDF</label>
      <div class="col-sm-10">
        <input type="file" class="form-control-file" id="archivo" name="archivo" accept="application/pdf" required>
      </div>
    </div>
    <div class="alert alert-info font-weight-bold mt-4" role="alert">
      Directores de la tesis
    </div>
    <fieldset class="border pt-4 pl-4 pr-4 mb-3">
      <legend class="w-auto mb-0"><span class="font-weight-bold" style="font-size:16px">Director</span></legend>
      <div class="form-group row">
        <label for="cuerpo-academico1" class="col-sm-3 col-form-label">Cuerpo Académico</label>
        <div class="col-sm-9">
          <select class="form-control" id="cuerpo-academico1">
            <?php
              foreach ($listaCA as $ca) {
                extract($ca);
                echo "<option value='{$clave}'>{$nombre}</option>";
              }
            ?>
          </select>
        </div>
      </div>
      <div class="form-group row">
        <label for="director" class="col-sm-3 col-form-label">Director</label>
        <div class="col-sm-9">
          <select class="form-control" id="director" name="director" required>
            <?php
              foreach ($listaProfesores as $profesor) {
                extract($profesor);
                echo "<option value='{$clave}' aria-cuerpo-academico='{$cuerpoAcademico}'>{$nombreCompleto}</option>";
              }
            ?>
          </select>
        </div>
      </div>
    </fieldset>
    <fieldset class="border pl-4 pr-4 mb-3">
      <legend class="w-auto">
        <input id="hayCodirector" name="hayCodirector" type="checkbox" onchange="javascript:showContent()">
        <label class="font-weight-bold" style="font-size:16px" for="hayCodirector">&nbsp;Codirector</label>
      </legend>
      <div id="areaCodirector" style="display: none;">
        <div class="form-group row">
          <label for="cuerpo-academico2" class="col-sm-3 col-form-label">Cuerpo Académico</label>
          <div class="col-sm-9">
            <select class="form-control" id="cuerpo-academico2">
              <?php
                foreach ($listaCA as $ca) {
                  extract($ca);
                  echo "<option value='{$clave}'>{$nombre}</option>";
                }
              ?>
            </select>
          </div>
        </div>
        <div class="form-group row">
          <label for="codirector" class="col-sm-3 col-form-label">Codirector</label>
          <div class="col-sm-9">
            <select class="form-control" id="codirector" name="codirector">
              <?php
                foreach ($listaProfesores as $profesor) {
                  extract($profesor);
                  echo "<option value='{$clave}' aria-cuerpo-academico='{$cuerpoAcademico}'>{$nombreCompleto}</option>";
                }
              ?>
            </select>
          </div>
        </div>
      </div>
    </fieldset>

    <fieldset class="border pl-4 pr-4 mb-4">
      <legend class="w-auto">
        <input id="hayExterno" name="hayExterno" type="checkbox" onchange="javascript:showContent()">
        <label class="font-weight-bold" style="font-size:16px" for="hayExterno">&nbsp;Codirector externo</label>
      </legend>
      <div id="areaExterno" style="display: none;">
        <div class="form-group row">
          <label for="externo" class="col-sm-3 col-form-label">Nombre</label>
          <div class="col-sm-9">
            <input type="text" class="form-control" id="externo" name="externo">
          </div>
        </div>
        <div class="form-group row">
          <label for="institucion" class="col-sm-3 col-form-label">Institución</label>
          <div class="col-sm-9">
            <input type="text" class="form-control" id="institucion" name="institucion">
          </div>
        </div>
      </div>
    </fieldset>

    <div class="alert alert-info font-weight-bold mt-4" role="alert">
      Tesistas
    </div>
    <fieldset class="border pt-4 pl-4 pr-4 mb-3">
      <legend class="w-auto mb-0"><span class="font-weight-bold" style="font-size:16px">Tesista 1</span></legend>
      <div class="form-group row">
          <label for="matricula1" class="col-sm-3 col-form-label">Matrícula</label>
          <div class="col-sm-5">
            <input type="text" class="form-control" id="matricula1" name="matricula1" required>
          </div>
        </div>
        <div class="form-group row">
          <label for="nombre1" class="col-sm-3 col-form-label">Nombre/s</label>
          <div class="col-sm-9">
            <input type="text" class="form-control" id="nombre1" name="nombre1" required>
          </div>
        </div>
        <div class="form-group row">
          <label for="apellidos1" class="col-sm-3 col-form-label">Apellidos</label>
          <div class="col-sm-9">
            <input type="text" class="form-control" id="apellidos1" name="apellidos1" required>
          </div>
        </div>
        <div class="form-group row">
          <label for="carrera1" class="col-sm-3 col-form-label">Carrera</label>
          <div class="col-sm-9">
            <select class="form-control" id="carrera1" name="carrera1">
              <option>Ingeniería en Informática Administrativa</option>
              <option>Ingeniería en Sistemas Computacionales</option>
              <option>Licenciatura en Informática Administrativa</option>
              <option>Licenciatura en Sistemas Computacionales</option>
              <option>Licenciatura en Tecnologias de la Información</option>
              <option>Licenciatura en Telemática</option>
            </select>
          </div>
        </div>
    </fieldset>
    <fieldset class="border pl-4 pr-4 mb-3">
      <legend class="w-auto">
        <input id="hayTesista2" name="hayTesista2" type="checkbox" onchange="javascript:showContent()">
        <label class="font-weight-bold" style="font-size:16px" for="hayTesista2">&nbsp;Tesista 2</label>
      </legend>
      <div id="areaTesista2" style="display: none;">
      <div class="form-group row">
          <label for="matricula2" class="col-sm-3 col-form-label">Matrícula</label>
          <div class="col-sm-5">
            <input type="text" class="form-control" id="matricula2" name="matricula2">
          </div>
        </div>
        <div class="form-group row">
          <label for="nombre2" class="col-sm-3 col-form-label">Nombre/s</label>
          <div class="col-sm-9">
            <input type="text" class="form-control" id="nombre2" name="nombre2">
          </div>
        </div>
        <div class="form-group row">
          <label for="apellidos2" class="col-sm-3 col-form-label">Apellidos</label>
          <div class="col-sm-9">
            <input type="text" class="form-control" id="apellidos2" name="apellidos2">
          </div>
        </div>
        <div class="form-group row">
          <label for="carrera2" class="col-sm-3 col-form-label">Carrera</label>
          <div class="col-sm-9">
            <select class="form-control" id="carrera2" name="carrera2">
              <option>Ingeniería en Informática Administrativa</option>
                <option>Ingeniería en Sistemas Computacionales</option>
                <option>Licenciatura en Informática Administrativa</option>
                <option>Licenciatura en Sistemas Computacionales</option>
                <option>Licenciatura en Tecnologias de la Información</option>
                <option>Licenciatura en Telemática</option>
              </select>
            </div>
        </div>
      </div>
    </fieldset>
    <!-- ------------------------ TESISTAS ------------------------------------
    <div class="form-group row">
      <label class="col-sm-3 col-form-label font-weight-bold">Número de Tesistas</label>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" id="radio1" name="numTesistas" value="1" checked onchange="mostrar(this.value);">
        <label class="form-check-label" for="radio1">Uno</label>
      </div>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" id="radio2" name="numTesistas" value="2" onchange="mostrar(this.value);">
        <label class="form-check-label" for="radio2">Dos</label>
      </div>
    </div>

    <ul class="nav nav-tabs">
      <li class="nav-item" id="areaTesista1">
        <a class="nav-link active font-weight-bold" data-toggle="tab" href="#tesista1">Tesista 1</a>
      </li>
      <li class="nav-item" id="areaTesista2" style="display: none;">
        <a class="nav-link font-weight-bold" data-toggle="tab" href="#tesista2">Tesista 2</a>
      </li>
    </ul>
    <!-- Primer tesista 
    <div class="tab-content border-left border-right border-bottom pl-4 pr-4 pt-4 mb-4">
      <div class="tab-pane fade show active" id="tesista1" role="tabpanel" aria-labelledby="tesista1-tab">
        DATOS DEL TESISTA
      </div>
      <!-- Segundo tesista
      <div class="tab-pane fade" id="tesista2" role="tabpanel" aria-labelledby="tesista2-tab">
        DATOS DEL TESISTA 2
      </div>
      --------------------------------------------------------------------- -->
    </div>
      
    <div class="col-sm-4">
      <div class=" row">
        <div class="col-sm-3"></div>
        <div class="col-sm-8">
        <button type="submit" class="btn btn-primary btn-lg btn-block" name="guardar" <?= ((Utils::isSoloLectura()) ? "disabled" : "") ?>>
          <i class="fas fa-save">&nbsp;</i>
          Guardar
        </button>
        <a href="inicio.php" class="btn btn-secondary btn-lg btn-block">
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

  /* Mostrar/ocultar los datos del codirector, del asesor externo y del tesista 2 */
  function showContent() {
    hayCodirector = document.getElementById("hayCodirector");
    hayExterno    = document.getElementById("hayExterno");
    hayTesista2   = document.getElementById("hayTesista2");
    areaCodirector = document.getElementById("areaCodirector");
    areaExterno    = document.getElementById("areaExterno");
    areaTesista2   = document.getElementById("areaTesista2");
    if (hayCodirector.checked) {
      areaCodirector.style.display = "block";
      document.getElementById("cuerpo-academico2").required = true;
      document.getElementById("codirector").required  = true;
    } else {
      areaCodirector.style.display = "none";
      document.getElementById("cuerpo-academico2").required = false;
      document.getElementById("codirector").required  = false;
    }
    if (hayExterno.checked) {
      areaExterno.style.display = "block";
      document.getElementById("externo").required     = true;
      document.getElementById("institucion").required = true;
    } else {
      areaExterno.style.display = "none";
      document.getElementById("externo").required     = false;
      document.getElementById("institucion").required = false;
    }
    if (hayTesista2.checked) {
      areaTesista2.style.display = "block";
      document.getElementById("matricula2").required = true;
      document.getElementById("nombre2").required    = true;
      document.getElementById("apellidos2").required = true;
      document.getElementById("carrera2").required   = true;
    } else {
      areaTesista2.style.display = "none";
      document.getElementById("matricula2").required = false;
      document.getElementById("nombre2").required    = false;
      document.getElementById("apellidos2").required = false;
      document.getElementById("carrera2").required   = false;
    }
  }

  /* Validar campos del formulario */
  function validarFormulario() {
    /*alert("Validando data...");
    
    var director = document.getElementById("director");
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
    return true;*/
  }
</script>

<script>
  $(function() {
    var filtrarProfesor = function(cuerpoAcademico) {
      $('#director option').hide();
      $('#director').find('option').filter(function() {
        //var ca = $(this).val();
        var ca = $(this).attr('aria-cuerpo-academico');
        return ca == cuerpoAcademico;
      }).show();
      // Valor default
      var elDirector = $('#director option:visible:first').text();
      $('#director').val(elDirector);
    };
    // Cuerpo académico default
    var cuerpoAcademico = $('#cuerpo-academico1').val();
    filtrarProfesor(cuerpoAcademico);
    // Evento
    $('#cuerpo-academico1').change(function() {
      filtrarProfesor($(this).val());
    });
  });
</script>

<script>
  $(function() {
    var filtrarProfesor2 = function(cuerpoAcademico2) {
      $('#codirector option').hide();
      $('#codirector').find('option').filter(function() {
        var ca = $(this).attr('aria-cuerpo-academico');
        return ca == cuerpoAcademico2;
      }).show();
      // Valor default
      var elCodirector = $('#codirector option:visible:first').text();
      $('#codirector').val(elCodirector);
    };
    // Cuerpo académico default
    var cuerpoAcademico2 = $('#cuerpo-academico2').val();
    filtrarProfesor2(cuerpoAcademico2);
    // Evento
    $('#cuerpo-academico2').change(function() {
      filtrarProfesor2($(this).val());
    });
  });
</script>

<!-- Pie de página -->
<?php
    include_once "php/footer.php";
  }
?>
