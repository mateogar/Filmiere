<?php
	namespace es\ucm\fdi\aw;
	require_once '/config.php';
	
	
	$seleccionado = $_REQUEST['dia'];	
	$horarios = array();
	$horarios = Horario::getHorarioDia($seleccionado);
	
	if($horarios)
	{
		
		$max = sizeof($horarios);
		
		$j = 0;
		while($j < $max)
		{

				
				$html .= '<option id="horas" value="'.$horarios[$j]->getHora().'">'
				.date('H:i', strtotime($horarios[$j]->getHora())).'</option>';
				
			$j++;
		}
		
		echo $html;
	}
	//Aún no hay ningún horario para ese día.
	else
		echo '<p>La película no se está reproduciendo en ninguna sala :(</p>';
?>