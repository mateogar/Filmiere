<?php

require_once __DIR__.'/includes/config.php';

?>
<!DOCTYPE html>

<head>
    <meta charset="utf-8" />
		<link rel="stylesheet" type="text/css" href="<?= $app->resuelve('/css/general.css') ?>">
	<link rel="icon" type="image/x-icon" href="img/logotipo.png" />
    <title>Contacto</title>
</head>
<body>
	<div class="contenedor">
    <?php include 'cabecera.php'; ?>
		<div class="estilo_bloque">
			<h2>Si quieres contactar con nosotros:</h2>
			<h2>Mediante formulario</h2>
			
			<div class="estilo_centrado">
				<?php $formContacto = new \es\ucm\fdi\aw\FormularioContacto(); $formContacto->gestiona(); ?>
			</div>
			
			<h2>O a través de nuestro:</h2>
			<div class="estilo_centrado">
				<p><em>Correo:</em> info@cinesfilmiere.com</p>
				<p><em>Teléfono:</em> 91 666 66 66</p>
			</div>
		</div>
		<?php include 'footer.php'; ?>
	</div>
</body>
</html>