<?php

require_once __DIR__.'/includes/config.php';

?>
<!DOCTYPE html>

<html>
    <head>
        <title>Registro</title>
        <meta charset="utf-8" />
		<link rel="stylesheet" type="text/css" href="<?= $app->resuelve('/css/general.css') ?>">
		<link rel="icon" type="image/x-icon" href="img/logotipo.png" />
    </head>

    <body>
        <div class="contenedor">
			<?php
				include 'cabecera.php';
			?>
			
            <div class="estilo_bloque">
                <h2>REGISTRO</h2>

				<div class="estilo_centrado">
					<?php $formRegistro = new \es\ucm\fdi\aw\FormularioRegistro(); $formRegistro->gestiona(); ?>
				</div>
		   </div>

			<?php
				include 'footer.php';
			?>
        </div>
    </body>
</html>