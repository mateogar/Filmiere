<?php

require_once __DIR__.'/includes/config.php';

?>
<!DOCTYPE html>
	<head>
	    <meta charset="utf-8" />
	    <link rel="stylesheet" type="text/css" href="<?= $app->resuelve('/css/general.css') ?>">
		<link rel="stylesheet" type="text/css" href="<?= $app->resuelve('/css/gestion.css') ?>">
		<link rel="icon" type="image/x-icon" href="img/logotipo.png" />
		
	    <title>Administrador</title>
	</head>
	<body>
	<div class="contenedor">
		<?php if(\es\ucm\fdi\aw\Aplicacion::getSingleton()->usuarioLogueado()
				&& \es\ucm\fdi\aw\Aplicacion::getSingleton()->rolUsuario() === "ADMIN"): ?>
			
      <div class="c_ag">
        <div class="c_gestion_ag">
		<?php $tablaLogs = new \es\ucm\fdi\aw\TablaLogs(); $tablaLogs->generaTabla();?>
                
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