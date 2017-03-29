<?php

namespace es\ucm\fdi\aw;

class FormularioCambiarGestor extends Form {

  const HTML5_EMAIL_REGEXP = '^[a-zA-Z0-9.!#$%&\'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$';

  private $numSala;

  public function __construct($numSala) {
    parent::__construct('formCambiar'.$numSala);
    $this->numSala = $numSala;
  }
  
  protected function generaCamposFormulario ($datos) {
    $todosGestores = Gestor::devuelveTodosGestores();
    $camposFormulario = $this->selectGestores($todosGestores);
    $camposFormulario.=<<<EOF
    <input type="submit" name="submit" value="Confirmar"/>
    <input type="hidden" name="salaGestor" value="
EOF;
    $camposFormulario.=$this->numSala;
    $camposFormulario.=<<<EOF
    "/>
EOF;
    return $camposFormulario;
  }

  /**
   * Procesa los datos del formulario.
   */
  protected function procesaFormulario($datos) {
	  $result = array();
    session_regenerate_id(true);
    if(isset($_POST['submit'])){
      //UTILIZAR ISSET
      $selected_val = $_POST['gestorS'];
      if(Gestor::gestorEnSala($this->numSala))
        Gestor::cambiarGestorSala($this->numSala, $selected_val);
      else
        Gestor::insertarGestorEnSala($this->numSala, $selected_val);
	
	  $result = \es\ucm\fdi\aw\Aplicacion::getSingleton()->resuelve('/i_admin.php');
    }
	return $result;
  }


  private function selectGestores($todosGestores) {
	  $html = '';
	  $html .='<select name="gestorS" id="gestorS" >';
	  $max = sizeof($todosGestores);
	  for($i = 0; $i < $max; $i++) 
		 $html .='<option value="' . $todosGestores[$i] . '"> '. $todosGestores[$i] . '</option>'; 
	  $html .= '</select>';
	  return $html;
  }
}
