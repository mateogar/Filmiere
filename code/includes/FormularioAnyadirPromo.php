<?php

namespace es\ucm\fdi\aw;

class FormularioAnyadirPromo extends Form {

  const HTML5_EMAIL_REGEXP = '^[a-zA-Z0-9.!#$%&\'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$';

  public function __construct() {
	  $opciones = array();
	  $opciones['enctype'] = 'multipart/form-data';
    parent::__construct('formAnyadirPromo', $opciones);
  }
  
  protected function generaCamposFormulario ($datos) {
    $camposFormulario=<<<EOF
    
		<p><label for="imagen">Imagen:(207px x 150px)</label><input type="file" name="imagen" id="imagen" /></p>
		<p><label for="pdf">PDF:</label><input type="file" name="pdf" id="pdf" /></p>
		<p><button type="submit" name="subir">Subir</button>
EOF;
    return $camposFormulario;
  }

  function check_file_uploaded_name ($filename) {
    return (bool) ((preg_match('/^[0-9A-Z-_\.]+$/i',$filename) === 1) ? true : false );
}

function check_file_uploaded_length ($filename) {
    return (bool) ((mb_strlen($filename,'UTF-8') < 250) ? true : false);
}

  

  /**
   * Procesa los datos del formulario.
   */
  protected function procesaFormulario($datos) {
    $result = array();
    $ok = true;
    if (!$_FILES['imagen'] || !$_FILES['pdf']) {
      $ok = false;
    }
	global $EXTENSIONES_PERMITIDAS_IMAGEN;
	global $EXTENSIONES_PERMITIDAS_ARCHIVO;
	
	if ( $ok ) {
		$imagen = $_FILES['imagen'];
		$nombreImg = $_FILES['imagen']['name'];
		$ok = $this->check_file_uploaded_name($nombreImg) && $this->check_file_uploaded_length($nombreImg) && in_array(pathinfo($nombreImg, PATHINFO_EXTENSION), $EXTENSIONES_PERMITIDAS_IMAGEN);
		
		if ( $ok ) {
			$tmp_name = $_FILES['imagen']['tmp_name'];
			$nombreImg = 'img/'.$nombreImg;
			$img_info = getimagesize($_FILES['imagen'] ['tmp_name']); //
			$ancho=$img_info[0];
			$alto=$img_info[1];
			if($ancho == 207 && $alto == 150){
				if ( !move_uploaded_file($tmp_name, $nombreImg) ) {
					$ok = false;
					$result[] = 'Error al mover la imagen';
				}
			}else{
				$ok = false;
				$result[] = 'La imagen tiene un tamaño no soportado.(207px x 150px)';
			}
			
		}else {
			$result[] = 'La imagen tiene un nombre o tipo no soportado. No puede contener espacios.';
		}
		
		
		$pdf = $_FILES['pdf'];
		$nombrePdf = $_FILES['pdf']['name'];
		if($ok){
			$ok = $this->check_file_uploaded_name($nombrePdf) && $this->check_file_uploaded_length($nombrePdf) && in_array(pathinfo($nombrePdf, PATHINFO_EXTENSION), $EXTENSIONES_PERMITIDAS_ARCHIVO);
			if ( $ok ) {
				$tmp_name = $_FILES['pdf']['tmp_name'];
				
				$nombrePdf = 'promos/'.$nombrePdf;
				if ( !move_uploaded_file($tmp_name, $nombrePdf) ) {
					$result[] = 'Error al mover el pdf';
				}
				else{
					$promo = new Promo(null, $nombreImg, $nombrePdf);
					if(!Promo::insertaPromo($promo)){
						$result[] = 'No se ha podido insertar la promo en la BD';
					}
					$result = \es\ucm\fdi\aw\Aplicacion::getSingleton()->resuelve('/anyadir_promo_gestor.php');
				}
			}else {
				$result[] = 'El pdf tiene un nombre o tipo no soportado. No puede contener espacios.';
			}
		}
		
	}else 
		$result[] = 'Debes rellenar bien todos los campos';
    
    return $result;
  }
  
  
  
}
