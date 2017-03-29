<?php

namespace es\ucm\fdi\aw;

/**
 * Clase de  de gestión de tablas.
 *
 * Gestión de token CSRF está basada en: https://www.owasp.org/index.php/PHP_CSRF_Guard
 */
class TablaLogs implements Tabla{

  public function __construct() {}

  /**
   * Devuelve un <code>string</code> con el HTML necesario para presentar los campos del tabla. Es necesario asegurarse que como parte del envío se envía un parámetro con nombre <code$tablaId</code> (i.e. utilizado como valor del atributo name del botón de envío del tabla).
   */
  public function generaCamposTabla () {
   $html = "";
   $uRegistros = array();
   $uRegistros = RegistroLogs::buscaRegistros();
   $html .= '<tr>
					<th>Nombre Empleado</th>
					<th>Último registro</th>
			</tr>';
   if($uRegistros != null){
	   $max = sizeof($uRegistros);
	   $i = 0;   
	   while($i < $max){
		   $html .='<tr><td><p>';
		   $html .= $uRegistros[$i]->userName();
		   $html .='</p></td><td><p>';
		   $time = $uRegistros[$i]->ultimoRegistro();
		   $html .= $time;
		   $html .='</p></td></tr>';
		   $i++;
	   }
   }else{
	   $html .= '<tr>
					<td>No hay ningún gestor</td>
					<td>dado de alta</tds>
				</tr>';
   }
   return $html;
  }
  
  /**
   * Función que genera el HTML necesario para el tabla.
   */
  public function generaTabla() {
	$html = "";
    $html .= '<table>';
    $html .= $this->generaCamposTabla();
    $html .= '</table>';
    echo $html;
  }

}
?>