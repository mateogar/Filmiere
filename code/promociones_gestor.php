<?php

require_once __DIR__.'/includes/config.php';

?>
<!DOCTYPE html>
<head>
  <meta charset="utf-8" />
   <link rel="stylesheet" type="text/css" href="<?= $app->resuelve('/css/general.css') ?>">
  <link rel="stylesheet" type="text/css" href="<?= $app->resuelve('/css/gestion.css') ?>">
  <link rel="icon" type="image/x-icon" href="img/logotipo.png" />
  <title>Gestor</title>
</head>
<body>
  <div class="contenedor">
	<?php if(\es\ucm\fdi\aw\Aplicacion::getSingleton()->usuarioLogueado()
			&& \es\ucm\fdi\aw\Aplicacion::getSingleton()->rolUsuario() === "GESTOR"): ?>
  
    <div class="c_ag">
      <div class="c_gestion_ag">
        <table>
          <tr>
             <th>Promoción</th>
			       <th>Eliminar</th>
          </tr>
		        <?php $promos = new \es\ucm\fdi\aw\CargaPromos(); $promos->generaTodasPromosGestor();?>       
        </table>
		<div>
			<button class="button_input" onClick="parent.location.href='anyadir_promo_gestor.php'">Añadir</button>
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