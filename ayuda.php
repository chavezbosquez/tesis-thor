<?php
  session_start();
  $tituloPagina = "Ayuda";
  include_once "php/header.php";
  include_once "php/header2.php";
?>

<div class="wrapper pl-4 pr-4">
  <!--<p>
    <ul style="list-style-type:square; padding-left: 25px; font-weight: bold">
            <li><a href="#intro" class="link-peque">1. Introducción</a></li>
            <li><a href="#app" class="link-peque">2. Aplicación de Captura</a></li>
            <li><a href="#web" class="link-peque">3. Sistema Web</a></li>
            <li><a href="#mas" class="link-peque">4. ¿Más dudas?</a></li>
    </ul>
  </p>-->
  <br>
  <h4><a name="intro">1. Introducci&oacute;n</a></h4>
  <p class="text-justify">
    El Sistema THOR (<code>THesis Online Repository</code>) es un sistema web que
    permite la gestión de los proyectos de tesis desarrollados en la DAIS. 
  </p>
  <br>
  <h4><a name="inicio">2. Inicio</a></h4>
  <p class="text-justify">
    Ingrese a la URL <a href="http://148.236.18.34/thor">http://148.236.18.34/thor</a> 
    para ingresar al Sistema. En la pantalla de inicio de sesión se muestra una
    pequeña reseña del proyecto, así como acceso al catálogo de profesores de la
    División y acceso a los formatos relacionados con el desarrollo de tesis.
  </p>
  <figure class="figure text-center">
          <img class="figure-img" src="img/ayuda/index.png" width="75%">
          <figcaption class="figure-caption">Fig. 1 - Pantalla de acceso al Sistema THOR</figcaption>
  </figure>
  <p>
    Al autenticarse correctamente en el Sistema se muestra la pantalla de inicio.
  </p>
  <figure class="figure text-center">
    <img class="figure-img" src="img/ayuda/inicio.png" width="75%">
    <figcaption class="figure-caption">Fig. 2 - Pantalla principal del Sistema THOR</figcaption>
  </figure>
</div>

<!-- Pie de página -->
<?php
    include_once "php/footer.php";
  //}
?>