<?php

namespace es\ucm\fdi\aw;

class FormularioCambiarDescuento extends Form {

  const HTML5_EMAIL_REGEXP = '^[a-zA-Z0-9.!#$%&\'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$';

  public function __construct() {
    parent::__construct('FormularioCambiarDescuento');
  }
  
  protected function generaCamposFormulario ($datos) {
    $tipoDescuentos = Butaca::tiposDescuentos();
    $camposFormulario = $this->selectTipoDescuentos($tipoDescuentos);    
    $nuevoP = isset($datos['nuevoPorcentaje']) ? $datos['nuevoPorcentaje'] : null ;
    $camposFormulario .=<<<EOF
    <p>Porcentaje actual:</p>
    <p id="porcentajeAnterior"> a</p>
	  <p>Nuevo porcentaje:</p>
    <input type="number" name="nuevoPorcentaje" value="$nuevoP" />
	  <input type="submit" name="submit" value="Confirmar"/>
EOF;
    return $camposFormulario;
  }



  private function selectTipoDescuentos($tipoDescuentos) {
    $html = '';
    $html .='<select name="tipoDescuentos" id="tipoDescuentos" >';
    $max = sizeof($tipoDescuentos);
    for($i = 0; $i < $max; $i++) 
     $html .='<option id="precio" value="' . $tipoDescuentos[$i] . '"> '. $tipoDescuentos[$i] . '</option>'; 
    $html .= '</select>';
    return $html;
  }

  /**
   * Procesa los datos del formulario.
   */
  protected function procesaFormulario($datos) {
    $ok = false;
    $result = array();
    session_regenerate_id(true);
    $nuevoP = isset($datos['nuevoPorcentaje']) ? $datos['nuevoPorcentaje'] : null;
    if($nuevoP != null) {
      if(isset($_POST['submit'])){
        $selected_val = $_POST['tipoDescuentos'];
        Butaca::cambiarPorcentajeDescuento($selected_val, $nuevoP);
        
      $result = \es\ucm\fdi\aw\Aplicacion::getSingleton()->resuelve('/i_admin.php');

    }
    else
      $result[] = "No se ha enviado formulario";  
  }
  else
    $result[] = "Debes especificar el nuevo porcentaje.";

  return $result;
  }
}
