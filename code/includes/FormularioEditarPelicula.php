<?php

namespace es\ucm\fdi\aw;

class FormularioEditarPelicula extends Form {

  const HTML5_EMAIL_REGEXP = '^[a-zA-Z0-9.!#$%&\'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$';

  private $idP;
	
  public function __construct($idPelicula) {
	  $opciones = array();
	  $opciones['enctype'] = 'multipart/form-data';
	  $opciones['action'] = \es\ucm\fdi\aw\Aplicacion::getSingleton()->resuelve('/editar_pelicula.php?pelicula='.$idPelicula );
	  $this->idP = $idPelicula;
    parent::__construct('formEditarPelicula', $opciones);
  }
  
  protected function generaCamposFormulario ($datos) {
	$pelicula = Pelicula::buscaPeliculas($this->idP);	
    $titulo = $pelicula->getTitulo();
    $estreno = $pelicula->getFecha();
    $generoPelicula = $pelicula->getGeneroEnum();
    $duracion = $pelicula->getDur();
    $director = $pelicula->getDirect();
    $reparto = $pelicula->getReparto();
    $sinop = $pelicula->getSinopsis();
    $valo = $pelicula->getValor();
	$img = $pelicula->getImg();
	$generos = array();
	$generos = Pelicula::getArrayGeneros();
	$size = count($generos);
	$campoGenero = "";
	for($i=0; $i<$size; $i++){
		if($generos[$i] == $generoPelicula){
			$campoGenero .= '<option value="'.$generos[$i].'" selected> '.$generos[$i].' </option>';
		}else{
			$campoGenero .= '<option value="'.$generos[$i].'"> '.$generos[$i].' </option>';
		}
	}
	$campoValor = "";
	for($i=1; $i<=5; $i++){
		if($i == $valo){
			$campoValor .= '<option value="'.$i.'" selected> '.$i.' </option>';
		}else{
			$campoValor .= '<option value="'.$i.'"> '.$i.' </option>';
		}
	}
    $camposFormulario=<<<EOF
    
        <p>Título película:</p>
         <input type="text" name="nombrePelicula" value="$titulo" />
        
         <p>Estreno (YYYY-MM-DD):</p>
         <input type="date" name="fechaEstreno" value="$estreno" />
        <p>Género: </p>
        <select name="generoPelicula">
        $campoGenero
        </select>
        
        <p>Duración:</p>
         <input type="number" name="duracionPelicula" value="$duracion" />
        
        <p>Director:</p>
         <input type="text" name="directorPelicula" value="$director" />
        
        <p>Reparto:</p>
		<textarea name="repartoPelicula" rows="10" cols="60"/>$reparto</textarea>

        <p>Sinopsis:</p>
        <textarea name="sinopsis" rows="10" cols="60"/>$sinop</textarea>
        
        <p>Valoración: </p>
        <select name="valoracion" value="$valo">
        $campoValor
        </select>
		<p><label for="archivo">Imagen:(823px x 1200px)</label><input type="file" name="archivo" id="archivo"/>($img)</p>
		<p><button type="submit" name="subir">Editar</button>
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
    if ( !$titulo || !$estreno || !$generoPelicula || !$duracion || !$director || !$reparto || !$sinop || !$valo) {
      
      $ok = false;
    }
	
	if($_FILES['archivo']['size']>0){	
		$okImg = true;
	}else{
		$okImg = false;
	}
	global $EXTENSIONES_PERMITIDAS_IMAGEN;
	
	if ($ok) {
		$nombre="";
		if($okImg){
			$archivo = $_FILES['archivo'];
			$nombre = $_FILES['archivo']['name'];
			
			$ok = $this->check_file_uploaded_name($nombre) && $this->check_file_uploaded_length($nombre) && in_array(pathinfo($nombre, PATHINFO_EXTENSION), $EXTENSIONES_PERMITIDAS_IMAGEN);
		}
		if ( $ok ) {
			$tmp_name = "";
			
			$fecha = array();
			$fecha = explode('-',$estreno);	
			if($fecha[0] > '1900' && $fecha[0] < '2100' && $fecha[1] > '00' && $fecha[1] < '13' && $fecha[2] > '00' && $fecha[2] < '32' && $fecha){
				if($okImg){
					$tmp_name = $_FILES['archivo']['tmp_name'];
					$nombre = 'img/'.$nombre;
					$img_info = getimagesize($_FILES['archivo'] ['tmp_name']); //
					$ancho=$img_info[0];
					$alto=$img_info[1];
					if($ancho == 823 && $alto == 1200){
						if(!move_uploaded_file($tmp_name, $nombre)){
							$result[] = 'Error al mover el archivo';
						}
						$pelicula = new Pelicula($this->idP, $titulo, $estreno,$generoPelicula,$duracion,$director,$reparto,$sinop,$valo,$nombre);
					}else{
						$result[] = 'El archivo tiene unas dimensiones no soportadas.(min(823px x 1200px))';
						$ok = false;
					}					
				}else{
					$peliculaBD = Pelicula::buscaPeliculas($this->idP);
					$pelicula = new Pelicula($this->idP, $titulo, $estreno,$generoPelicula,$duracion,$director,$reparto,$sinop,$valo,$peliculaBD->getImg());
				}
				if($ok){
					if(!Pelicula::updatePelicula($pelicula)){
						$result[] = 'No se ha podido editar en la BD';
					}else
						$result = \es\ucm\fdi\aw\Aplicacion::getSingleton()->resuelve('/editar_pelicula.php?pelicula='.$this->idP );
				}
			}
			else $result[] = 'El formato de la fecha de estreno no es el indicado';
		}else {
			$result[] = 'El archivo tiene un nombre o tipo no soportado. No puede contener espacios.';
		}
	}else 
		$result[] = 'Debes rellenar bien todos los campos';
    
    return $result;
  }
  
}
