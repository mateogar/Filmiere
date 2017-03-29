<?php
	namespace es\ucm\fdi\aw;
	require_once __DIR__.'/includes/config.php';

	if(isset($_REQUEST['date']) && isset($_REQUEST['butacas']))
	{
		$idHorario = $_REQUEST['date'];
		$butacas = array();
		$butacas = $_REQUEST['butacas'];
		$butacas = explode(',', $butacas);
		$horario = Horario::getHorarioById($idHorario);
		$precioTotal = 0;
		
		//Calcular el precio total.
		foreach($butacas as &$butaca)
		{
			$aux = explode('_', $butaca);
			$fila = $aux[0];
			$columna = $aux[1];
			
			$butacaAux = Butaca::buscaButacaSalaCompra($horario->getSala(), $fila, $columna);
			$precioTotal += Butaca::devuelvePrecio($butacaAux->getTipo());
			
			if($horario->getTD())
				$precioTotal += Butaca::devuelvePrecio("3D");
		}
		
		//Comprobar si hay que aplicar algún tipo de descuento
		$tipoDescuento = $_REQUEST['tipodescuento'];
		
		if($tipoDescuento != "sin_descuento")
		{
			if($tipoDescuento == "cod_promo")
			{
				$codigo = CodigoPromo::getCodigoPromo($_REQUEST['codigopromo']);
				
				if($codigo && $codigo->getEstado() == 1)
					$precioTotal = $precioTotal * ((100 - $codigo->getPorcentajeDescuento()) / 100);				
			}
			else
				if($tipoDescuento == "pack4o5" || $tipoDescuento == "packmayor5")
				{
					$type = "SIN_DESCUENTO";
					
					switch($tipoDescuento)
					{
						case "sin_descuento":
							$type = "SIN_DESCUENTO";
							break;
						case "pack4o5":
							$type = "PACK_4o5";
							break;
						case "packmayor5":
							$type = "PACK_MAYOR_5";
							break;
						default:
							$type = "SIN_DESCUENTO";
					}
					
					$porcentajeDesc = Butaca::buscaPorcentajeDescuento($type);
					$precioTotal = $precioTotal * ((100 - $porcentajeDesc) / 100);
				}
		}
		
		//Comprobar si hay un socio conectado.
		$usuario = null;
		
		if(\es\ucm\fdi\aw\Aplicacion::getSingleton()->usuarioLogueado() && \es\ucm\fdi\aw\Aplicacion::getSingleton()->rolUsuario() === "SOCIO")
			$usuario = \es\ucm\fdi\aw\Aplicacion::nombreUsuario();
		
		//Guardar la compra de entrada en la base.
		$idHistorial = HistorialCompras::insertarHistorial($usuario, $horario->getPelicula(), sizeof($butacas), number_format($precioTotal, 2), $horario->getHora());
		
		//Ocupar las butacas.
		foreach($butacas as &$butaca)
		{
			$aux = explode('_', $butaca);
			$fila = $aux[0];
			$columna = $aux[1];
			
			Butaca::ocuparButaca($fila, $columna, $idHorario, $idHistorial);
		}
		
		if($idHistorial)
			echo "<p>Gracias por realizar su compra, puede ir a la página de <a href='index.php'>inicio</a> o a su <a href='perfil_usuario.php'>perfil personal</a>.";
		else
			echo "No se ha podido realizar la compra.";
	}
	else
		echo "No se ha podido realizar la compra.";
?>