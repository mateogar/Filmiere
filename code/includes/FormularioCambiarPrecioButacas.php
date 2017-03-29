<?php

namespace es\ucm\fdi\aw;

class FormularioCambiarPrecioButacas extends Form {

  const HTML5_EMAIL_REGEXP = '^[a-zA-Z0-9.!#$%&\'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$';

  public function __construct() {
    parent::__construct('formCambiarPrecioButacas');
  }
  
  protected function generaCamposFormulario ($datos) {
    $tipoButacas = Butaca::tiposButacas();
    $camposFormulario = $this->selectTipoButacas($tipoButacas);    
    $nuevoP = isset($datos['nuevoPrecio']) ? $datos['nuevoPrecio'] : null ;
    $camposFormulario .=<<<EOF
    <p>Precio actual:</p>
    <p id="precioAnterior"> </p>
	  <p>Nuevo precio:</p>
    <input type="number" name="nuevoPrecio" value="$nuevoP" />
	  <input type="submit" name="submit" value="Confirmar"/>
EOF;
    return $camposFormulario;
  }



  private function selectTipoButacas($tipoButacas) {
    $html = '';
    $html .='<select name="tipoButacas" id="tipoButacas" >';
    $max = sizeof($tipoButacas);
    for($i = 0; $i < $max; $i++) 
     $html .='<option id="precio" value="' . $tipoButacas[$i] . '"> '. $tipoButacas[$i] . '</option>'; 
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
    $nuevoP = isset($datos['nuevoPrecio']) ? $datos['nuevoPrecio'] : null;
    if($nuevoP) {
    if(isset($_POST['submit'])){
      $selected_val = $_POST['tipoButacas'];
        Butaca::cambiarPrecioButaca($selected_val, $nuevoP);
        
      $result = \es\ucm\fdi\aw\Aplicacion::getSingleton()->resuelve('/i_admin.php');

    }
    else
      $result[] = "No se ha enviado formulario";  
  }
  else
    $result[] = "Debes especificar el nuevo precio.";

  return $result;
  }
}
