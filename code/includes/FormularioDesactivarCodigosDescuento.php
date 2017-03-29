<?php

namespace es\ucm\fdi\aw;

class FormularioDesactivarCodigosDescuento extends Form {

  const HTML5_EMAIL_REGEXP = '^[a-zA-Z0-9.!#$%&\'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$';

  public function __construct() {
    parent::__construct('formDesactivarCodigosDescuento');
  }
  
  protected function generaCamposFormulario ($datos) {
    $codDescuentos = Butaca::codigosDescuentos();
    $camposFormulario = $this->selectCodsDescuento($codDescuentos);    
    
    $camposFormulario .=<<<EOF
    <p>Estado actual:</p>
    <p id="estadoAnterior"> </p>
	  <p>Nuevo estado:</p>
    <p>
      <select name="nuevoEstado">
          <option value="1"> Activado </option>
          <option value="0"> Desactivado </option>
    </select>
    </p>
    

	  <input type="submit" name="submit" value="Confirmar"/>
EOF;
    return $camposFormulario;
  }



  private function selectCodsDescuento($cods) {
    $html = '';
    $html .='<select name="codDescuentos" id="codDescuentos" >';
    $max = sizeof($cods);
    for($i = 0; $i < $max; $i++) 
     $html .='<option id="activo" value="' . $cods[$i] . '"> '. $cods[$i] . '</option>'; 
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
    $nuevoE = isset($datos['nuevoEstado']) ? $datos['nuevoEstado'] : null;
    if(isset($_POST['submit'])){
      $selected_val = $_POST['codDescuentos'];
        Butaca::cambiarCodDescuento($selected_val, $nuevoE);
        
      $result = \es\ucm\fdi\aw\Aplicacion::getSingleton()->resuelve('/i_admin.php');

    }
    else
      $result[] = "No se ha enviado formulario";  
  

  return $result;
  }
}
