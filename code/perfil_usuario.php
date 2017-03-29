<?php

require_once __DIR__.'/includes/config.php';

?>

<!DOCTYPE html>

<html>
	<head>
		<title>Perfil</title>
		<meta charset="utf-8" />
		<link rel="stylesheet" type="text/css" href="<?= $app->resuelve('/css/general.css') ?>">
		<link rel="icon" type="image/x-icon" href="img/logotipo.png" />
	</head>
	
	<body>
		<div class="contenedor">
			<?php
				include 'cabecera.php';
			?>
			
			<?php if(\es\ucm\fdi\aw\Aplicacion::getSingleton()->usuarioLogueado()
				&& \es\ucm\fdi\aw\Aplicacion::getSingleton()->rolUsuario() === "SOCIO"): ?>
			
				
				<div class="estilo_bloque">
					<h2>Datos Personales</h2>
					
					<div class="estilo_centrado">
						<?php $formPerfilUsuario = new \es\ucm\fdi\aw\FormularioPerfilUsuario(); $formPerfilUsuario->gestiona(); ?>
					</div>
				</div>
				<div class="estilo_bloque">
					<h2>Historial de Compras</h2>
					
                    <?php
                        $tablaHistorialSocio = new \es\ucm\fdi\aw\TablaHistorialSocio();
                        $tablaHistorialSocio->generaTabla();
                    ?>
				</div>
			<?php else: ?>
				<div class="estilo_bloque">
					<h2><a href="login.php" >Inicie sesión</a> para acceder a su perfil personal.</h2>
				</div>
			<?php endif; ?>
			<?php
				include 'footer.php';
			?>
		</div>
	</body>
</html>