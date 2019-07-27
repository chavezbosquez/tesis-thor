<?php
  session_start();
  if ($_SESSION['login'] == '') {
    header("location: index.php");
  } else {
    if ( !isset($_GET['folio']) ) {
      header("location: inicio.php");
    }
?>
<head>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css"
    integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css"
    integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
</head>
<?php
    $folio = $_GET['folio'];
    $usuario = $_SESSION['login'];
    $tituloPagina = "Anteproyecto {$folio}";

    require_once 'php/bd.php';
    require_once 'php/tesis.php';
    require_once 'php/profesor.php';
    require_once 'php/tesista.php';

    /* Consultar TODOS los datos de la tesis */
    /*$pdo = BaseDeDatos::conectar();
    $sql = "SELECT folio,fecha,tesis.nombre,tesista1,tesista2,director,codirector,codirector_externo,institucion_externa,tesis.estatus,
            cuerpo_academico.nombre as nombreCA,
            CONCAT(profesor.nombre, ' ', profesor.apellidos) AS nombreDirector,
            CONCAT(tesista.nombre, ' ', tesista.apellidos) AS nombreTesista,tesista.carrera,
              tesista.correo,tesista.telefono,tesista.movil,tesista.domicilio,tesista.localidad
                FROM tesis,cuerpo_academico,profesor,tesista
                WHERE folio='{$folio}'
                    AND director=profesor.clave
                    AND tesista1=tesista.matricula
                    AND profesor.cuerpo_academico=cuerpo_academico.clave
                    AND (tesis.estatus LIKE 'F1' OR tesis.estatus LIKE 'F2' OR tesis.estatus LIKE 'F3')
                    LIMIT 1";
    $cons = $pdo->query($sql, PDO::FETCH_ASSOC);
    $registro = $cons->fetch();
    extract($registro);*/
    $laTesis = Tesis::getTodosLosDatos($folio);
    extract($laTesis);
    
    /* ¿Hay tesista 2  */
    $hayTesista2 = isset($tesista2);
    if ( $hayTesista2 ) {
      /*$sql = "SELECT CONCAT(nombre, ' ', apellidos) AS nombreTesista2, carrera AS carreraTesista2
                FROM tesista WHERE matricula LIKE '{$tesista2}'";
      $cons = $pdo->query($sql, PDO::FETCH_ASSOC);
      $registro2 = $cons->fetch();
      extract($registro2);*/
      $elTesista = Tesista::getDatos($tesista2);
    }

    /* Hay codirector */
    $hayCodirector = isset($codirector);
    if ($hayCodirector) {
      /*$sql = "SELECT CONCAT(profesor.nombre, ' ', apellidos) AS nombreCodirector, cuerpo_academico.nombre as nombreCA2
                  FROM profesor,cuerpo_academico
                  WHERE profesor.clave LIKE '{$codirector}' 
                      AND profesor.cuerpo_academico=cuerpo_academico.clave
                      LIMIT 1";
      $cons = $pdo->query($sql, PDO::FETCH_ASSOC);
      $registro3 = $cons->fetch();
      extract($registro3);*/
      $elCodirector = Profesor::getDatosProfesor($codirector);
    }

    /* Hay codirector externo */
    $hayExterno = isset($codirector_externo);
    if ($hayExterno) {
      $hayExterno = true;
      $nombreExterno = $codirector_externo;
      $institucionExterna = $institucion_externa;
    }

    /* Archivos asociados */
    $pdo = BaseDeDatos::conectar();
    $listaArchivos = array();
    $sql = "SELECT nombre_archivo AS nombreArchivo,tipo_documento AS tipoDocumento
              FROM documento WHERE tesis LIKE '{$folio}'";
    foreach ($pdo->query($sql,PDO::FETCH_ASSOC) as $registro4) {
      array_push($listaArchivos, $registro4);
    }

    /* Extraer la Comisión revisora: Todos los Fs excepto el F1 deben tener Comisión revisora asignada */
    //$listaComision = array();
    $hayComision = false;
    if ($estatus != "F1") { /* if ( isset($comision_revisora1) ) */
      $hayComision = true;
      $sql = "SELECT revisor1,revisor2,revisor3 FROM tesis WHERE folio LIKE '{$folio}' LIMIT 1";
      $cons = $pdo->query($sql, PDO::FETCH_ASSOC);
      $registro5 = $cons->fetch();
      $elRevisor1 = Profesor::getDatosProfesor($registro5['revisor1']);
      $elRevisor2 = Profesor::getDatosProfesor($registro5['revisor2']);
      $elRevisor3 = Profesor::getDatosProfesor($registro5['revisor3']);
    }

    $hayJurado = false;
    if ($estatus == "F7" || $estatus == "F8" || $estatus == "F8-A" || $estatus == "FF") {
      $hayJurado = true;
      $sql = "SELECT jurado1,jurado2,jurado3,jurado4,jurado5 FROM tesis WHERE folio LIKE '{$folio}' LIMIT 1";
      $cons = $pdo->query($sql, PDO::FETCH_ASSOC);
      $registro6 = $cons->fetch();
      $elJurado1 = Profesor::getDatosProfesor($registro6['jurado1']);
      $elJurado2 = Profesor::getDatosProfesor($registro6['jurado2']);
      $elJurado3 = Profesor::getDatosProfesor($registro6['jurado3']);
      $elJurado4 = Profesor::getDatosProfesor($registro6['jurado4']);
      $elJurado5 = Profesor::getDatosProfesor($registro6['jurado5']);
    }

    BaseDeDatos::desconectar();
    
?>
<body>
  <main role="main">
    <table class="table table-striped table-bordered table-hover table-condensed">
      <tbody>
        <tr>
          <td class="text-right">Fecha</td>
          <td class="font-weight-bold"><?php echo date("d/m/y",strtotime($fecha)); ?></td>
        </tr>
        <tr>
          <td class="text-right">Folio</td>
          <td class="font-weight-bold"><?php echo $folio; ?></td>
        </tr>
        <tr>
          <td class="text-right">Nombre</td>
          <td class="font-weight-bold"><?php echo $nombre; ?></td>
        </tr>
        <tr>
          <td class="text-right">Director</td>
          <td>
            <strong><?php echo $nombreDirector; ?></strong>
            <br>
            <?php echo $nombreCA; ?>
          </td>
          </tr>
          <?php if ($hayCodirector) { ?>
            <tr>
              <td class="text-right">Codirector</td>
              <td>
                <strong><?php echo $elCodirector['nombre']; ?></strong>
                <br>
                <?php echo $elCodirector['cuerpoAcademico']; ?>
              </td>
            </tr>
          <?php } ?>
          <?php if ($hayExterno) { ?>
            <tr>
              <td class="text-right">Codirector Externo</td>
              <td class="font-weight-bold">
                <?php echo $nombreExterno; ?>
                <br>
                <?php echo $institucionExterna; ?>
              </td>
            </tr>
          <?php } ?>
          <tr>
            <td class="text-right">Tesista 1</td>
            <td>
              <strong><?php echo "{$tesista1} — {$nombreTesista}"; ?></strong>
              <br>
              <?php echo $carrera; ?>
              <!-- Datos adicionales del tesista -->
              <?php if (isset($correo)   && $correo != "")      echo "<br>{$correo}"; ?>
              <?php if (isset($telefono) && $telefono != "")    echo "<br>{$telefono}"; ?>
              <?php if (isset($movil) && $movil != "")          echo "<br>{$movil}"; ?>
              <?php if (isset($domicilio) && $domicilio != "")  echo "<br>{$domicilio}"; ?>
              <?php if (isset($localidad)  && $localidad != "") echo "<br>{$localidad}"; ?>
            </td>
          </tr>
          <?php if ($hayTesista2) { ?>
            <tr>
              <td class="text-right">Tesista 2</td>
              <td>
                <strong><?php echo $tesista2; ?></strong>—<strong><?php echo $elTesista['nombre']; ?></strong>
                <br>
                <?php echo $elTesista['carrera']; ?>
                <!-- Datos adicionales del tesista -->
                <?php if (isset($elTesista['correo']) && $elTesista['correo'] != "")       echo "<br>{$elTesista['correo']}"; ?>
                <?php if (isset($elTesista['telefono']) && $elTesista['telefono'] != "")   echo "<br>{$elTesista['telefono']}"; ?>
                <?php if (isset($elTesista['movil']) && $elTesista['movil'] != "")         echo "<br>{$elTesista['movil']}"; ?>
                <?php if (isset($elTesista['domicilio']) && $elTesista['domicilio'] != "") echo "<br>{$elTesista['domicilio']}"; ?>
                <?php if (isset($elTesista['localidad']) && $elTesista['localidad'] != "") echo "<br>{$elTesista['localidad']}"; ?>
              </td>
            </tr>
          <?php } ?>
          <tr>
            <td class="text-right">Archivos</td>
            <td class="font-weight-bold">
                <?php
                  foreach ($listaArchivos as $archivo) {
                    extract($archivo);
                      if ( substr($tipoDocumento, 0, 1) == "F" ) {
                        echo "<a href='docs/{$nombreArchivo}'>
                                <i class='far fa-file-pdf'></i>&nbsp;Formato {$tipoDocumento}
                              </a>";
                      } else if ( substr($tipoDocumento, 0, 3) == "REV" ) {
                        echo "&nbsp;&nbsp;&nbsp;&nbsp;<a href='docs/{$nombreArchivo}'>
                                <i class='fas fa-male'></i>&nbsp;Oficio {$tipoDocumento}
                              </a>";
                      } else if ( substr($tipoDocumento, 0, 3) == "JUR" ) {
                        echo "&nbsp;&nbsp;&nbsp;&nbsp;<a href='docs/{$nombreArchivo}'>
                                <i class='fas fa-address-book'></i>&nbsp;Oficio {$tipoDocumento}
                              </a>";
                      } else if ( substr($tipoDocumento, 0, 2) == "OF" ) {
                        echo "&nbsp;&nbsp;<a href='docs/{$nombreArchivo}'>
                                <i class='fas fa-pdf'></i>&nbsp;Oficio {$tipoDocumento}
                              </a>";
                      } else if ( substr($tipoDocumento, 0, 3) == "DIR" ) {
                        echo "&nbsp;&nbsp;&nbsp;&nbsp;<a href='docs/{$nombreArchivo}'>
                                <i class='fas fa-user-circle'></i>&nbsp;Oficio {$tipoDocumento}
                              </a>";
                      }
                      echo "<br>";
                  }
                ?>
            </td>
          <tr>
        </tbody>
      </table>
      <!-- COMISIÓN REVISORA -->
      <?php if ($hayComision) { ?>
        <h5 class="text-center">Comisión revisora</h5>
        <table class="table table-striped table-bordered table-hover table-condensed">
          <tbody>
            <tr>
              <td>
                <strong><?php echo $elRevisor1['nombre']; ?></strong>
                <br>
                <?php echo $elRevisor1['cuerpoAcademico']; ?>
              </td>
              <td>
                <strong><?php echo $elRevisor2['nombre']; ?></strong>
                <br>
                <?php echo $elRevisor2['cuerpoAcademico']; ?>
              </td>
              <td>
                <strong><?php echo $elRevisor3['nombre']; ?></strong>
                <br>
                <?php echo $elRevisor3['cuerpoAcademico']; ?>
              </td>
            </tr>
          </tbody>
        </table>
      <?php } ?>
      <!-- JURADO -->
      <?php if ($hayJurado) { ?>
        <h5 class="text-center">Jurado</h5>
        <table class="table table-striped table-bordered table-hover table-condensed">
          <tbody>
            <tr>
              <td>
                <strong><?php echo $elJurado1['nombre']; ?></strong>
                <br>
                <?php echo $elJurado1['cuerpoAcademico']; ?>
              </td>
              <td>
                <strong><?php echo $elJurado2['nombre']; ?></strong>
                <br>
                <?php echo $elJurado2['cuerpoAcademico']; ?>
              </td>
              <td>
                <strong><?php echo $elJurado3['nombre']; ?></strong>
                <br>
                <?php echo $elJurado3['cuerpoAcademico']; ?>
              </td>
              <td>
                <strong><?php echo $elJurado4['nombre']; ?></strong>
                <br>
                <?php echo $elJurado4['cuerpoAcademico']; ?>
              </td>
              <td>
                <strong><?php echo $elJurado5['nombre']; ?></strong>
                <br>
                <?php echo $elJurado5['cuerpoAcademico']; ?>
              </td>
            </tr>
          </tbody>
        </table>
      <?php } ?>
    </main>
  </body>

<?php
  }
?>
