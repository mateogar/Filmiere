<?php

namespace es\ucm\fdi\aw;

class FormularioCambiarPass extends Form {
	
  public function __construct() {
    parent::__construct('formCambiarPass');
  }
  
  protected function generaCamposFormulario ($datos) {

    $camposFormulario=<<<EOF
	<p id="pin">Antigua Contraseña:</p>
	<p><input type="password" name="apass" /></p>
	<p id="pin">Nueva Contraseña:</p>
	<p><input type="password" name="npass" /></p>
	<p id="pin">Repita Contraseña:</p>
	<p><input type="password" name="rpass" /></p>
    <input type="submit" name="submit" value="Confirmar"/>
EOF;
    return $camposFormulario;
  }

  /**
   * Procesa los datos del formulario.
   */
  protected function procesaFormulario($datos) {
    $result = array();
	$ok = true;
	$apass = isset($datos['apass']) ? $datos['apass'] : null ;
	$npass = isset($datos['npass']) ? $datos['npass'] : null ;
	$rpass = isset($datos['rpass']) ? $datos['rpass'] : null ;
	
	if($npass !== $rpass){
	  $result[] = 'Las contraseñas no coinciden';
      $ok = false;
    }
	
	if ( !$npass ||  mb_strlen($npass) < 4 ) {
      $result[] = 'La nueva contraseña no es válida';
      $ok = false;
    }
	

	//$pass: Contraseña almacenada en la BD
	//$apss: Contraseña que introduce el usuario como antigua contraseña.
	//Login dado un usuario y contraseña que se introduce te dice si coincide con lo de la bd.
	//$pass = Usuario::devuelvePass($_SESSION['nombre']);
	//if( !$apass || password_verify($pass, $apass)){
    $coinciden = Usuario::login($_SESSION['nombre'], $apass);
  	if(!$coinciden) {
	  $result[] = 'La contraseña antigua no es válida';
      $ok = false;
	}
	
	if($ok){
		//$npass: Nueva contraseña en texto plano
		session_regenerate_id(true);
		$aleatorio = rand();
          			
		$passwordA = $npass . $aleatorio;
		$contrasena = password_hash($passwordA, PASSWORD_BCRYPT);	
		if(Usuario::cambiarPass($_SESSION['nombre'], $contrasena, $aleatorio))
			
			$result = \es\ucm\fdi\aw\Aplicacion::getSingleton()->resuelve('/i_admin.php');
    	else
    		$result[] = 'No se ha podido cambiar la contraseña';
    }
	return $result;
  }



}
