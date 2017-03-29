<?php

require_once __DIR__.'/includes/config.php';

?>
<?php
function mostrarSaludo() {
  $html = '';
  $app = \es\ucm\fdi\aw\Aplicacion::getSingleton();
  $nombreUsuario = $app->nombreUsuario();
	if ($app->usuarioLogueado()) {
    	$logoutUrl = $app->resuelve('/logout.php');
		$html = "<p>Bienvenido, ${nombreUsuario}.<a href='${logoutUrl}'>(salir)</a> </p>";
	} else {
    $loginUrl = $app->resuelve('/login.php');
		$html = "<a href='login.php' class='estilo_boton_a' id='boton_login'>Login</a>";
	}

  return $html;
}
?>


<?php
function mostrarMenu() {
  $html = '';
  $app = \es\ucm\fdi\aw\Aplicacion::getSingleton();
  $rolUser = $app->rolUsuario();
	if ($app->usuarioLogueado()) {
    	if($rolUser === "GESTOR")
    		$html = "<a href='i_gestor.php' class='estilo_boton_a'><li>Menu Gestor</li></a>";
    	else if($rolUser  === "ADMIN")
    		$html = "<a href='i_admin.php' class='estilo_boton_a'><li>Menu Admin</li></a>";
    	else
    		$html = "<a href='perfil_usuario.php' class='estilo_boton_a'><li>Perfil Socio</li></a>";
	}else
		$html = "<a href='register.php' class='estilo_boton_a'><li>Regístrate</li></a>";

  return $html;
}
?>


<!DOCTYPE html>

<html>
<div class="estilo_bloque_grande">
	 <div class="div_img_logotipo">
			<a href="index.php"><img src="img/logotipo.png"></a>
	 </div>
	 <div>
		
		<div class="titulo_cabecera">
			<img src="img/titulo1.png" style="width: 100%;">				
		</div>

		<?=
			mostrarSaludo();
		?>

		<div id="barra_navegacion">
			<ul id="menu">
				<a href="index.php" class="estilo_boton_a"><li> Inicio</li></a>
				<a href="cartelera.php" class="estilo_boton_a"><li> Cartelera</li></a>
				<a href="proximamente.php" class="estilo_boton_a"><li> Próximamente</li></a>
				<a href="quienesSomos.php" class="estilo_boton_a"><li> ¿Quiénes somos?</li></a>
				<a href="contacto.php" class="estilo_boton_a"><li>Contacto</li></a>
				<?= mostrarMenu() ?>	   		
			</ul>
		 </div>
	</div>
</div>
</html>
