<?php

require_once __DIR__.'/includes/config.php';

?>

<!DOCTYPE html>
<html>
	<head>
	    <meta charset="utf-8" />
	    <link rel="stylesheet" type="text/css" href="<?= $app->resuelve('/css/general.css') ?>">
		<link rel="stylesheet" type="text/css" href="<?= $app->resuelve('/css/gestion.css') ?>">
		<link rel="icon" type="image/x-icon" href="img/logotipo.png" />
	    <title>Mensajes de Contacto</title>
	</head>
	<body>
		<div class="contenedor">
		<?php if(\es\ucm\fdi\aw\Aplicacion::getSingleton()->usuarioLogueado()
			&& \es\ucm\fdi\aw\Aplicacion::getSingleton()->rolUsuario() === "ADMIN"): ?>
		
		  <div class="c_ag">
			<div class="c_gestion_ag">
				<?php
					$tablaContactos = new \es\ucm\fdi\aw\TablaContactos();
					$tablaContactos->generaTabla();
				?>		
			</div>
			
			  <?php include 'into_menu_admin.php'; ?>
			</div>
			
		<?php else: ?>
			<div class="estilo_bloque">
				<h2>Acceso restringido.</h2>
			</div>
		<?php endif; ?>
		</div>
	</body>
</html>