<?php

namespace es\ucm\fdi\aw;

/**
 * Clase de  de gestión de tablas.
 *
 * Gestión de token CSRF está basada en: https://www.owasp.org/index.php/PHP_CSRF_Guard
 */
class TablaHistorialSocio implements Tabla
{
	public function __construct()
	{
	}

	/**
	* Devuelve un <code>string</code> con el HTML necesario para presentar los campos del tabla. Es necesario asegurarse que como parte del envío se envía un parámetro con nombre <code$tablaId</code> (i.e. utilizado como valor del atributo name del botón de envío del tabla).
	*/
	public function generaCamposTabla () 
	{
		$historial = array();
		$historial = HistorialComprasSocio::getHistorialCompras();
		
		echo '<tr>';
		echo		'<th>Película</th>';
		echo		'<th>Nº Entradas</th>';
		echo		'<th>Precio (€)</th>';
		echo		'<th>Fecha</th>';
		echo		'<th colspan="2">Butaca</th>';
		
		echo '</tr>';
				
		if($historial)
		{
		   $max = sizeof($historial);
		   $i = 0;
		   $pelicula = $historial[$i]->getPelicula();
		   $date = $historial[$i]->getFecha();
		   $entradas = $historial[$i]->getNumEntradas();
		   $price = $historial[$i]->getPrecio();
		   if($max > 0){
			   echo '<tr><td rowspan="'.$entradas.'" class="columnaTablaHistorial"><p>'.
					$historial[$i]->getPelicula().
					'</p></td><td rowspan="'.$entradas.'" class="columnaTablaHistorial"><p>'.
					$historial[$i]->getNumEntradas().
					'</p></td><td rowspan="'.$entradas.'" class="columnaTablaHistorial"><p>'.
					$historial[$i]->getPrecio().
					'</p></td><td rowspan="'.$entradas.'" class="columnaTablaHistorial"><p>'.
					$historial[$i]->getFecha().
					'</p></td><td class="columnaTablaHistorial"><p>'.
					$historial[$i]->getFila().
					'</p></td><td class="columnaTablaHistorial"><p>'.
					$historial[$i]->getColumna().
					'</p></td></tr>';
					$i++;
		   }
		   while($i < $max)
		   {	
				if(($historial[$i]->getPelicula() == $pelicula) && 
				($historial[$i]->getNumEntradas() == $entradas) && 
				($historial[$i]->getPrecio() == $price) && 
				($historial[$i]->getFecha() == $date) ){
					echo '<tr><td class="columnaTablaHistorial"><p>'.
					$historial[$i]->getFila().
					'</p></td><td class="columnaTablaHistorial"><p>'.
					$historial[$i]->getColumna().
					'</p></td></tr>';
				}else{
					$pelicula = $historial[$i]->getPelicula();
					$date = $historial[$i]->getFecha();
					$entradas = $historial[$i]->getNumEntradas();
					$price = $historial[$i]->getPrecio();
					echo '<tr><td rowspan="'.$entradas.'" class="columnaTablaHistorial"><p>'.
					$historial[$i]->getPelicula().
					'</p></td><td rowspan="'.$entradas.'" class="columnaTablaHistorial"><p>'.
					$historial[$i]->getNumEntradas().
					'</p></td><td rowspan="'.$entradas.'" class="columnaTablaHistorial"><p>'.
					$historial[$i]->getPrecio().
					'</p></td><td rowspan="'.$entradas.'" class="columnaTablaHistorial"><p>'.
					$historial[$i]->getFecha().
					'</p></td><td class="columnaTablaHistorial"><p>'.
					$historial[$i]->getFila().
					'</p></td><td class="columnaTablaHistorial"><p>'.
					$historial[$i]->getColumna().
					'</p></td></tr>';
				}   
			   $i++;
		   }
		}
		else
			echo'<p class="estilo_centrado">No hay historial de compras</p>';
	}

	/**
	* Función que genera el HTML necesario para el tabla.
	*/
	public function generaTabla()
	{
		echo '<table id="tablaContactos" class="estilo_centrado">';
		$this->generaCamposTabla();
		echo'</table>';
	}
}
?>