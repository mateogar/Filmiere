<?php
	namespace es\ucm\fdi\aw;
	require_once '/config.php';
	
	
	$seleccionado = $_REQUEST['precio'];
	
	$precio = Butaca::buscaPrecioTipoButaca($seleccionado);
	
	if($precio)
	{
		
		echo $precio;
		
	
	}
		
	else
		echo '<p>Error al mostrar el precio</p>';
?>