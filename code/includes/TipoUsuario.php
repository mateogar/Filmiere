<?php
	namespace es\ucm\fdi\aw;
	require_once '/config.php';
	
	
	$seleccionado = $_REQUEST['usuario'];
	$user = Usuario::buscaUsuario($seleccionado);
	$tipo = $user->rol();

	if($tipo)
	{
		
		echo $tipo;
	
	}
		
	else
		echo '<p>Error al mostrar el precio</p>';
?>