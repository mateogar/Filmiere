<?php
namespace es\ucm\fdi\aw;
require_once __DIR__.'/includes/config.php';

?>
<html>
<head>
    <meta charset="utf-8" />
	<link rel="stylesheet" type="text/css" href="<?= $app->resuelve('/css/general.css') ?>">
	<link rel="icon" type="image/x-icon" href="<?= $app->resuelve('/img/logotipo.png') ?>">
	<script type="text/javascript" src="<?= $app->resuelve('/js/jquery-2.2.4.min.js') ?>"></script>
	
    <title>Horario</title>
	
    <script>
		$(document).ready(function()
		{
			function get(name)
			{
			   if(name = (new RegExp('[?&]' + encodeURIComponent(name) + '=([^&]*)')).exec(location.search))
				  return decodeURIComponent(name[1]);
			}
			
			$id_peli = get('id');
			$seleccionado = document.getElementById('fecha').value;
			$.get("includes/horasDia.php?dia=" + $seleccionado + "&id_peli=" + $id_peli, mostrarHoras);
		
			$("#fecha").change(function()
			{
				$seleccionado = document.getElementById('fecha').value;
				$.get("includes/horasDia.php?dia=" + $seleccionado + "&id_peli=" + $id_peli, mostrarHoras);
			});
			
			function mostrarHoras(data, status)
			{
				document.getElementById("lista_horas").innerHTML = data;
			}
			
		});

    </script>
</head>
<body>
	<div class="contenedor">
		<?php include 'cabecera.php'; ?>
		<div class="estilo_bloque_grande">
			<?php PeliculasOps::peliculasDatosHorario($_REQUEST["id"]); ?>
		</div>
		
		<?php include 'footer.php'; ?>
	</div>
</body>
</html>