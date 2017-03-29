<?php

require_once __DIR__.'/includes/config.php';

?>
<!DOCTYPE html>

<html>
    <head>
        	<title>Añadir Promoción</title>
		<meta charset="utf-8" />
		<link rel="stylesheet" type="text/css" href="<?= $app->resuelve('/css/general.css') ?>">
		<link rel="stylesheet" type="text/css" href="<?= $app->resuelve('/css/gestion.css') ?>">
		<link rel="icon" type="image/x-icon" href="img/logotipo.png" />
    </head>

    <body>
        <div class="contenedor">
			
			<?php if(\es\ucm\fdi\aw\Aplicacion::getSingleton()->usuarioLogueado()
				&& \es\ucm\fdi\aw\Aplicacion::getSingleton()->rolUsuario() === "GESTOR"): ?>
		
			<div class="c_ag">
           		<div class="c_gestion_ag">
 					<h2>Añadir nueva promoción</h2>
					<div class="estilo_centrado">
						<?php $formAnyadirPromo = new \es\ucm\fdi\aw\FormularioAnyadirPromo(); $formAnyadirPromo->gestiona(); ?>
					</div>
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