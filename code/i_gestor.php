<?php
namespace es\ucm\fdi\aw;
require_once __DIR__.'/includes/config.php';

?>
<!DOCTYPE html>
<head>
  <meta charset="utf-8" />
  <link rel="stylesheet" type="text/css" href="<?= $app->resuelve('/css/general.css') ?>">
  <link rel="stylesheet" type="text/css" href="<?= $app->resuelve('/css/gestion.css') ?>">        
  <link rel="icon" type="image/x-icon" href="img/logotipo.png" />
  <script type="text/javascript" src="<?= $app->resuelve('/js/jquery-2.2.4.min.js') ?>"></script>
          <title>Gestor</title>


   <script>
    $(document).ready(function()
    {
      function get(name)
      {
         if(name = (new RegExp('[?&]' + encodeURIComponent(name) + '=([^&]*)')).exec(location.search))
          return decodeURIComponent(name[1]);
      }
      $seleccionado = document.getElementById('fecha').value;
      $.get("includes/horasDiaporFecha.php?dia=" + $seleccionado, mostrarHoras);
    
      $("#fecha").change(function()
      {
        $seleccionado = document.getElementById('fecha').value;
        $.get("includes/horasDiaporFecha.php?dia=" + $seleccionado, mostrarHoras);
        
      });
      
      function mostrarHoras(data, status)
      {
        document.getElementById("l_horas").innerHTML = data;
        $seleccionado = document.getElementById('l_horas').value;
        $.get("includes/peliculas_DiayHora.php?diaH=" + $seleccionado, mostrarPeliculas);
      }

     $seleccionadoH = document.getElementById('l_horas').value;
      $.get("includes/peliculas_DiayHora.php?diaH=" + $seleccionado, mostrarPeliculas);
    
      $("#l_horas").change(function()
      {
        $seleccionado = document.getElementById('l_horas').value;
        $.get("includes/peliculas_DiayHora.php?diaH=" + $seleccionado, mostrarPeliculas);
      });
      
      function mostrarPeliculas(data, status)
      {
        document.getElementById("tabla_pelis").innerHTML = data;
      }
      
    });

    </script>
  </head>
<body>
  <div class="contenedor">
	<?php if(\es\ucm\fdi\aw\Aplicacion::getSingleton()->usuarioLogueado()
			&& \es\ucm\fdi\aw\Aplicacion::getSingleton()->rolUsuario() === "GESTOR"): ?>
    <div class="c_ag">
      <div class="c_gestion_ag">
        <table id="tabla_pelis">
		      <?php 
           $peliculas = new PeliculasOps(); 
           $peliculas->muestraDias(7);
          ?>
        </table>

      </div>
      <?php include 'into_menu_gestor.php'; ?>
    </div>
	
	<?php else: ?>
		<div class="estilo_bloque">
			<h2>Acceso restringido.</h2>
		</div>
	<?php endif; ?>
  </div>
</body>
</html>