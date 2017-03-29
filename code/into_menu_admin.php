<?php

require_once __DIR__.'/includes/config.php';

?>

<?php
function mostrarNombreAdmin() {
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
              <?= mostrarNombreAdmin()?>
          </li>
          <li>
            <?= mostrarCerrarSesion() ?>
          </li>
               <li>
                <a href="i_admin.php">
                  <p>Home</p>
                </a>
              </li>
              <li>
                <a href="registro_logs.php">
                  <p>Registro Logs</p>
                </a>
              </li>
              <li>
                <a href="previo.php">
                  <p>Cambio contraseña</p>
                </a>
              </li>
              <li>
                <a href="registro_gestor.php">
                  <p>Registrar gestor</p>
                </a>
              </li>
               <li>
                <a href="RegistroAdmin.php">
                  <p>Registrar administrador</p>
                </a>
              </li>
              <li>
                <li>
                <a href="eliminarUsuario.php">
                  <p>Eliminar usuario</p>
                </a>
              </li>
              <li>
                <a href="peliculas_eliminar.php">
                 <p>Películas</p>
                </a>
              </li>
              <li>
                <a href="cambiarPrecioButacas.php">
                 <p>Precios de butacas</p>
                </a>
              </li>
              <li>
                <a href="cambiarDescuento.php">
                 <p>Porcentajes de descuentos</p>
                </a>
              </li>
              <li>
                <a href="nuevo_codigo_descuento.php">
                 <p>Añadir código descuento</p>
                </a>
              </li>
              <li>
                <a href="cambiar_cod_descuento.php">
                 <p>Cambiar estado código descuento</p>
                </a>
              </li>
              <li>
                <a href="index.php">
                  <p>Portada</p>
                </a>
              </li>
			         <li>
                <a href="mensajes_contacto.php">
                  <p>Mensajes de Contacto</p>
                </a>
              </li>
            </ul>
          </div>