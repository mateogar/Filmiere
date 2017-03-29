<?php
require_once __DIR__.'/includes/config.php';
?>
<!DOCTYPE html>

<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="<?= $app->resuelve('/css/general.css') ?>">	
    <link rel="icon" type="image/x-icon" href="<?= $app->resuelve('img/logotipo.png') ?>" />
	<script type="text/javascript" src="<?= $app->resuelve('/js/jquery-2.2.4.min.js') ?>"></script>
	<title>Filmière</title>
	<script>
	$(document).ready(function()
    {
      function get(name)
      {
         if(name = (new RegExp('[?&]' + encodeURIComponent(name) + '=([^&]*)')).exec(location.search))
          return decodeURIComponent(name[1]);
      }
      $.get("includes/pelicula_prox_index.php", mostrarEstadoActual);
      
      function mostrarEstadoActual(data, status)
      {
      
        document.getElementById("prox").innerHTML = data;
        
      }

     
    });

    </script>
</head>
	<body>
		<div class="contenedor">
			<?php
				include 'cabecera.php';
			?>
			<?php
				include 'into_cartelera.php';
			?>
			 <div id="c_proximamente" class="estilo_bloque_grande">
				<h2>Próximamente</h2>
				
				<div id="prox">
					
				</div>
			 </div>
			 
			<div class="estilo_bloque_grande">
				<h2>Promociones</h2>
				
				<div class="estilo_centrado">
					 <?php $promos = new \es\ucm\fdi\aw\CargaPromos(); $promos->generaPromos();?>
				</div>
		   </div>
		   
			<?php
				include 'footer.php';
			?>
		</div>
	</body>
</html>

