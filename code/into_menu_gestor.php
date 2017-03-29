<?php

require_once __DIR__.'/includes/config.php';

?>


<?php
function mostrarNombreGestor() {
  $html = '';
  $app = \es\ucm\fdi\aw\Aplicacion::getSingleton();
  $nombreUsuario = $app->nombreUsuario();
  if ($app->usuarioLogueado()) {
    $logoutUrl = $app->resuelve('/logout.php');
    $html = "<h3>Bienvenido, ${nombreUsuario}.</h3>";
  }

  return $html;
}



function mostrarCerrarSesion() {
  $html = '';
  $app = \es\ucm\fdi\aw\Aplicacion::getSingleton();
  if ($app->usuarioLogueado()) {
    $logoutUrl = $app->resuelve('/logout.php');
    $html = "<a href='${logoutUrl}'><h4>Cerrar Sesión</h4></a>";
  }

  return $html;
}
?>  

<div class="menu_ag">
        <ul>
          <li>
              <?= mostrarNombreGestor()?>
          </li>
          <li>
            <?= mostrarCerrarSesion() ?>
          </li>
		  <li>
            <a href="i_gestor.php">
              <p>Home</p>
            </a>
          </li>
          <li>
            <a href="promociones_gestor.php">
              <p>Promociones</p>
            </a>
          </li>
          <li>
            <a href="index.php">
              <p>Portada</p>
            </a>
          </li>
		  <li>
            <a href="anyadir_horario.php">
              <p>Añadir horario</p>
            </a>
          </li>
        </ul>
      </div>