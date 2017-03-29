<?php

namespace es\ucm\fdi\aw;

class FormularioAnyadirPelicula extends Form {

  const HTML5_EMAIL_REGEXP = '^[a-zA-Z0-9.!#$%&\'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$';

  public function __construct() {
	  $opciones = array();
	  $opciones['enctype'] = 'multipart/form-data';
	  $opciones['action'] = 'anyadir_pelicula.php';
    parent::__construct('formAnyadirPelicula', $opciones);
  }
  
  protected function generaCamposFormulario ($datos) {
    
    $titulo = isset($datos['nombrePelicula']) ? $datos['nombrePelicula'] : null;
    $estreno = isset($datos['fechaEstreno']) ? $datos['fechaEstreno'] : null;
    $generoPelicula = isset($datos['generoPelicula']) ? $datos['generoPelicula'] : null;
    $duracion = isset($datos['duracionPelicula']) ? $datos['duracionPelicula'] : null;
    $director = isset($datos['directorPelicula']) ? $datos['directorPelicula'] : null;
    $reparto = isset($datos['repartoPelicula']) ? $datos['repartoPelicula'] : null;
    $sinop = isset($datos['sinopsis']) ? $datos['sinopsis'] : null;
    $valo = isset($datos['valoracion']) ? $datos['valoracion'] : null;
    $img = isset($datos['imagen']) ? $datos['imagen'] : null;
    $camposFormulario=<<<EOF
    
        <p>Título película:</p>
         <input type="text" name="nombrePelicula" value="$titulo" />
        
         <p>Estreno:</p>
         <input type="date" name="fechaEstreno" value="$estreno" />
        <p>Género: </p>
        <select name="generoPelicula">
        <option value="DRAMA"> DRAMA</option>
        <option value="COMEDIA"> COMEDIA</option>
        <option value="CIENCIA_FICCION"> CIENCIA FICCION</option>
        <option value="BELICA"> BELICA</option>
        <option value="HISTORICA"> HISTORICA</option>
        <option value="TERROR"> TERROR</option>
        <option value="TRAGICOMEDIA"> TRAGICOMEDIA</option>
        </select>
        
        <p>Duración:</p>
         <input type="number" name="duracionPelicula" value="$duracion" />
        
        <p>Director:</p>
         <input type="text" name="directorPelicula" value="$director" />
        
        <p>Reparto:</p>
         <input type="text" name="repartoPelicula" value="$reparto" />

        <p>Sinopsis:</p>
        <textarea name="sinopsis" rows="10" cols="60"/>$sinop</textarea>
        
        <p>Valoración: </p>
        <select name="valoracion">
        <option value="1"> 1 </option>
        <option value="2"> 2 </option>
        <option value="3"> 3 </option>
        <option value="4"> 4 </option>
        <option value="5"> 5 </option>
        </select>
		<p><label for="archivo">Imagen: (823px x 1200px)</label><input type="file" name="archivo" id="archivo" /></p>
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
    $titulo = isset($datos['nombrePelicula']) ? $datos['nombrePelicula'] : null;
    $estreno = isset($datos['fechaEstreno']) ? $datos['fechaEstreno'] : null;
    $generoPelicula = isset($datos['generoPelicula']) ? $datos['generoPelicula'] : null;
    $duracion = isset($datos['duracionPelicula']) ? $datos['duracionPelicula'] : null;
    $director = isset($datos['directorPelicula']) ? $datos['directorPelicula'] : null;
    $reparto = isset($datos['repartoPelicula']) ? $datos['repartoPelicula'] : null;
    $sinop = isset($datos['sinopsis']) ? $datos['sinopsis'] : null;
    $valo = isset($datos['valoracion']) ? $datos['valoracion'] : null;
    if ( !$titulo || !$estreno || !$generoPelicula || !$duracion || !$director || !$reparto || !$sinop || !$valo || !$_FILES['archivo']) {
      
      $ok = false;
    }
	global $EXTENSIONES_PERMITIDAS_IMAGEN;
	
	if ( $ok ) {
		
		$archivo = $_FILES['archivo'];
		$nombre = $_FILES['archivo']['name'];
		$ok = $this->check_file_uploaded_name($nombre) && $this->check_file_uploaded_length($nombre) && in_array(pathinfo($nombre, PATHINFO_EXTENSION), $EXTENSIONES_PERMITIDAS_IMAGEN);
		if ( $ok ) {
			$tmp_name = $_FILES['archivo']['tmp_name'];
			$nombre = 'img/'.$nombre;
			$img_info = getimagesize($_FILES['archivo'] ['tmp_name']); //
			$ancho=$img_info[0];
			$alto=$img_info[1];
			if($ancho == 823 && $alto == 1200){
				if ( !move_uploaded_file($tmp_name, $nombre) ) {
					$result[] = 'Error al mover el archivo';
				}
				else{
					$pelicula = new Pelicula(null, $titulo, $estreno,$generoPelicula,$duracion,$director,$reparto,$sinop,$valo,$nombre);
					if(!Pelicula::insertaPelicula($pelicula)){
						$result[] = 'No se ha podido insertar en la BD';
					}
					$result = \es\ucm\fdi\aw\Aplicacion::getSingleton()->resuelve('/peliculas_eliminar.php');
				}
			}else{
				$result[] = 'El archivo tiene unas dimensiones no soportadas.(min(823px x 1200px))';
			}
		}else {
			$result[] = 'El archivo tiene un nombre o tipo no soportado. No puede contener espacios.';
		}
	}else 
		$result[] = 'Debes rellenar bien todos los campos';
    
    return $result;
  }
  
  
  
}
