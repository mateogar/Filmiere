<?php

namespace es\ucm\fdi\aw;

class FormularioAnyadirCodigoDescuento extends Form {

  const HTML5_EMAIL_REGEXP = '^[a-zA-Z0-9.!#$%&\'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$';

  public function __construct() {
    parent::__construct('formAnyadirCodigoDescuento');
  }
  
  protected function generaCamposFormulario ($datos) {
    
    
    $codigoDescuento = isset($datos['codigoDescuento']) ? $datos['codigoDescuento'] : null ;
    $porcentajeDescuento = isset($datos['porcentajeDescuento']) ? $datos['porcentajeDescuento'] : null ;
    $camposFormulario=<<<EOF
    <div>
    <p>Introduce el nuevo código de descuento:</p>
	 <input type="text" name="codigoDescuento" value="$codigoDescuento" />
   </div>
    <div>
    <p>Porcentaje de descuento:</p>
    <input type="text" name="porcentajeDescuento" value="$porcentajeDescuento" />
    </div>
   <p> Activado</p>
   <p>
      <select name="activo">
          <option value="1"> Sí </option>
          <option value="0"> No </option>
    </select></p>
	<button class="button_input" type="submit">Añadir</button>
EOF;
    return $camposFormulario;
  }

  /**
   * Procesa los datos del formulario.
   */
  protected function procesaFormulario($datos) {
    $result = array();
    $ok = true;
    $codigoDescuento = isset($datos['codigoDescuento']) ? $datos['codigoDescuento'] : null ;
    $porcentajeDescuento = isset($datos['porcentajeDescuento']) ? $datos['porcentajeDescuento'] : null ;
    if ( !$codigoDescuento ) {
      $result[] = 'Debes introducir el código de descuento';
      $ok = false;
    }
    if ( !$porcentajeDescuento ) {
      $result[] = 'Debes introducir el porcentaje de descuento';
      $ok = false;
    }
    if ( $ok ) {
      $activo = isset($datos['activo']) ? $datos['activo'] : null;
      // SEGURIDAD: Forzamos que se genere una nueva cookie de sesión por si la han capturado antes de hacer login
    	session_regenerate_id(true);
      
    	$ok = Butaca::anyadirCodigoDescuento($codigoDescuento, $porcentajeDescuento, $activo);
	     if($ok)
		      $result = \es\ucm\fdi\aw\Aplicacion::getSingleton()->resuelve('/i_admin.php');
	     else 
          $result[] = 'No se ha podido añadir el código';
	
  }
    return $result;
  }
}
