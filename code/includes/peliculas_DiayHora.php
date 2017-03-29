<?php
	namespace es\ucm\fdi\aw;
	require_once '/config.php';
	
	
	$dia = $_REQUEST['diaH'];	
	$uPeliculas = array();
	   $uPeliculas = Pelicula::buscaPeliculasGestor($dia);
	   $uSalas = array();
	   $uSalas = Gestor::buscaSalasGestorConectado();
	    
	   if($uPeliculas != null){
	   	echo'
	   	<tr>
            <th>Salas</th>
            <th>Películas</th>
        </tr>';
		   $max = sizeof($uPeliculas);
		   $cuantasSalas = sizeof($uSalas);
		   $i = 0;   
		   while($i < $max){
			echo '<tr>';			   
				echo '<td><p>Sala '.$uPeliculas[$i]->getSala().'</p></td>';
				echo '<td><p>'.$uPeliculas[$i]->getTitulo().'</p>';
					if(in_array($uPeliculas[$i]->getSala(), $uSalas)){
						
						$formCambiarPelicula = new \es\ucm\fdi\aw\FormularioCambiarPelicula($uPeliculas[$i]->getSala(), $dia); 
						$formCambiarPelicula->gestiona();
					}
				echo '</td>';
			echo'</tr>';			   
			$i++;
		   }
		 
	   }
	   else
	   	echo '<p>No hay películas</p>';
?>