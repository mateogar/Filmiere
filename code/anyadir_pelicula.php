<?php
namespace es\ucm\fdi\aw;
require_once __DIR__.'/includes/config.php';

?>
<!DOCTYPE html>

<html>
    <head>
        	
		<meta charset="utf-8" />
		<link rel="stylesheet" type="text/css" href="<?= $app->resuelve('/css/general.css') ?>">
		<link rel="stylesheet" type="text/css" href="<?= $app->resuelve('/css/gestion.css') ?>">
		<link rel="icon" type="image/x-icon" href="img/logotipo.png" />
		<title>Añadir Película</title>
    </head>

    <body>
        <div class="contenedor">
		
		<?php if(Aplicacion::getSingleton()->usuarioLogueado()
				&& Aplicacion::getSingleton()->rolUsuario() === "ADMIN"): ?>
			<div class="c_ag">
     			 <div class="c_gestion_ag">
   					 <h2>Añadir nueva película</h2>
   					 <div class="estilo_centrado">	
						<?php $formAnyadirPelicula = new FormularioAnyadirPelicula(); $formAnyadirPelicula->gestiona(); ?>

					</div>
    			</div>
    			<?php include 'into_menu_admin.php'; ?>
 			 </div>
        </div>
		<?php else: ?>
			<div class="estilo_bloque">
				<h2>Acceso restringido.</h2>
			</div>
		<?php endif; ?>
</div>
    </body>
</html>