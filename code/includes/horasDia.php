<?php
	namespace es\ucm\fdi\aw;
	require_once 'config.php';
	
	$id_peli = $_REQUEST['id_peli'];
	$seleccionado = $_REQUEST['dia'];	
	$horarios = array();
	$horarios = Horario::getHorarioPelicula($id_peli);
	$dia = explode(" ", $seleccionado);
	$fecha = explode("-", $dia[1]);
	if($fecha[0]<10){
		$fecha[0] = '0'. $fecha[0];
	}
	$diaSelecionado = $fecha[0].'-'.$fecha[1].'-'.$fecha[2];
	
	if($horarios)
	{
		$html = '';
		$max = sizeof($horarios);
		$j = 0;
		while($j < $max)
		{	
			if($diaSelecionado == Horario::getDia($horarios[$j]->getHora())){
				if($horarios[$j]->getTD() == 0) {
					$html .= '<li><a class="horaC" href=butacas.php?date='.$horarios[$j]->getId().'>'.
								date('H:i', strtotime($horarios[$j]->getHora())).'</a></li>';
				}
				else {
					$html .= '<li><a class="horaC" href=butacas.php?date='.$horarios[$j]->getId().'>'.
								date('H:i', strtotime($horarios[$j]->getHora())).' (3D)</a></li>';
					
				}
			}
			$j++;
		}
		
		echo $html;
	}
	else
		echo '<li>La película no se reproduce ningún día :(</li>';
?>