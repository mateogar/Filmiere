<?php

namespace es\ucm\fdi\aw;

/**
 * Clase de  de gestión de tablas.
 *
 * Gestión de token CSRF está basada en: https://www.owasp.org/index.php/PHP_CSRF_Guard
 */
class TablaContactos implements Tabla
{
	public function __construct()
	{
	}

	/**
	* Devuelve un <code>string</code> con el HTML necesario para presentar los campos del tabla. Es necesario asegurarse que como parte del envío se envía un parámetro con nombre <code$tablaId</code> (i.e. utilizado como valor del atributo name del botón de envío del tabla).
	*/
	public function generaCamposTabla () 
	{
		$html = "";
		$contactos = array();
		$contactos = Contacto::getTodosContactos();
		
		echo '<tr>';
		echo		'<th>Nombre</th>';
		echo		'<th>Correo</th>';
		echo		'<th>Asunto</th>';
		echo		'<th>Mensaje</th>';
		echo		'<th>Eliminar</th>';
		echo '</tr>';
				
		if($contactos)
		{
		   $max = sizeof($contactos);
		   $i = 0;
		   
		   while($i < $max)
		   {
			   echo '<tr><td class="columnaTablaContactos"><p>'.
					$contactos[$i]->getNombre().
					'</p></td><td class="columnaTablaContactos"><p>'.
					$contactos[$i]->getCorreo().
					'</p></td><td class="columnaTablaContactos"><p>'.
					$contactos[$i]->getAsunto().
					'</p></td><td class="columnaTablaContactos"><p>'.
					$contactos[$i]->getMensaje().
					'</p></td><td class="columnaTablaContactos"><p>';
			   
			   $formEliminarContacto = new \es\ucm\fdi\aw\FormularioEliminarContacto($contactos[$i]->getId());
			   $formEliminarContacto->gestiona();
			   echo	'</p></td></tr>';
			   $i++;
		   }
		}
		else
			echo'<p>No hay mensajes de Contacto';
	}

	/**
	* Función que genera el HTML necesario para el tabla.
	*/
	public function generaTabla()
	{
		echo '<table id="tablaContactos">';
		$this->generaCamposTabla();
		echo'</table>';
	}
}
?>