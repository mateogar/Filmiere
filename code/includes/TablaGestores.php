<?php

namespace es\ucm\fdi\aw;

/**
 * Clase de  de gestión de tablas.
 *
 * Gestión de token CSRF está basada en: https://www.owasp.org/index.php/PHP_CSRF_Guard
 */
class TablaGestores{

  public function __construct() {

  }

  private function generaCamposSala($gestoresEnSala,&$contador, $numSala) {
    
   //Posiciones del array con elementos.
   $max = sizeof($gestoresEnSala);
   //Contador para saber cuantas posiciones del array hemos recorrido.
   echo'
			  <tr>
              <td>
                <h1> ' .$numSala. ' </h1>
              </td>
              <td>';

	if($contador < $max && $gestoresEnSala[$contador]->sala() == $numSala) {
		echo '<p name="gestorSala'.$numSala.' ">' .$gestoresEnSala[$contador]->userName(). ' </p>';
	    $contador++;
	}

	$this->cambiarGestor($numSala);
	echo'</td><td>';

	$this->eliminarGestor($numSala);
	echo'</td></tr>';

  }
  
  /**
   * Función que genera el HTML necesario para la tabla.
   */
  public function generaTabla() {
    $html = '';
    echo '<table> 
              <tr>
                <th>Sala</th>
                <th>Gestor</th>
                <th>Eliminar Gestor</th>
              </tr>';
    $gestoresEnSala = array();
    $todosGestores = array();

    $gestoresEnSala = Gestor::devuelveGestoresEnSala();
    $contador = 0;
    for($i = 1; $i <= 6; $i++)
     $this->generaCamposSala($gestoresEnSala,$contador, $i);
    echo'</table>';
  }





  private function eliminarGestor($numSala){
    $formEliminarGestor = new \es\ucm\fdi\aw\FormularioEliminarGestor($numSala); $formEliminarGestor->gestiona();
  }

  private function cambiarGestor($numSala) {
    $formCambiarGestor = new \es\ucm\fdi\aw\FormularioCambiarGestor($numSala); $formCambiarGestor->gestiona();
  }
}
?>