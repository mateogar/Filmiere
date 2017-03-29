<?php

namespace es\ucm\fdi\aw;

class FormularioEliminarUsuario extends Form {

  const HTML5_EMAIL_REGEXP = '^[a-zA-Z0-9.!#$%&\'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$';

  public function __construct() {
    parent::__construct('formEliminarUsuario');
  }
  
  protected function generaCamposFormulario ($datos) {
    $usuarios = Usuario::getUsuarios();
    $camposFormulario = $this->selectTipoButacas($usuarios);    
    $nuevoP = isset($datos['nuevoPrecio']) ? $datos['nuevoPrecio'] : null ;
    $camposFormulario .=<<<EOF
    <p>ROL:</p>
    <p id="rol"> </p>
	  <input type="submit" name="submit" value="Eliminar"/>
EOF;
    return $camposFormulario;
  }



  private function selectTipoButacas($usuarios) {
    $html = '';
    $html .='<select name="usuarios" id="usuarios" >';
    $max = sizeof($usuarios);
    for($i = 0; $i < $max; $i++) 
     $html .='<option id="usu" value="' . $usuarios[$i] . '"> '. $usuarios[$i] . '</option>'; 
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
    if(isset($_POST['submit'])){
      $selected_val = $_POST['usuarios'];
      
      if(Usuario::eliminarUsuario($selected_val))
        $result = \es\ucm\fdi\aw\Aplicacion::getSingleton()->resuelve('/i_admin.php');
      else
        $result[] = "No se ha podido eliminar al usuario";  
    }
    else
      $result[] = "No se ha enviado formulario";  

  return $result;
  }
}
