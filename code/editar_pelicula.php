<?php

require_once __DIR__.'/includes/config.php';

?>
<!DOCTYPE html>

<html>
    <head>
        <title>Editar Película</title>
		<meta charset="utf-8" />
		<link rel="stylesheet" type="text/css" href="<?= $app->resuelve('/css/general.css') ?>">
		<link rel="stylesheet" type="text/css" href="<?= $app->resuelve('/css/gestion.css') ?>">
		<link rel="icon" type="image/x-icon" href="img/logotipo.png" />
		
    </head>

    <body>
        <div class="contenedor">
		
		<?php if(\es\ucm\fdi\aw\Aplicacion::getSingleton()->usuarioLogueado()
				&& \es\ucm\fdi\aw\Aplicacion::getSingleton()->rolUsuario() === "ADMIN"): ?>
		<div class="c_ag">
      <div class="c_gestion_ag">
    <h2>Editar película</h2>
    <div class="estilo_centrado">
		<?php
			$idPelicula = $_REQUEST['pelicula'];
			if(isset($idPelicula)){
				$formEditarPelicula = new \es\ucm\fdi\aw\FormularioEditarPelicula($idPelicula); $formEditarPelicula->gestiona(); 
			}else{
				echo "<h2>Ha ocurrido un problema</h2>";
			}		
		?>

		</div>
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