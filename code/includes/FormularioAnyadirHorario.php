<?php

namespace es\ucm\fdi\aw;

class FormularioAnyadirHorario extends Form {

  const HTML5_EMAIL_REGEXP = '^[a-zA-Z0-9.!#$%&\'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$';

  public function __construct() {
    parent::__construct('FormPerfilUsuario');
  }
  
  protected function generaCamposFormulario ($datos) {
    $salas = array();
    $salas = Gestor::buscaSalasGestorConectado();
	$peliculas = array();
	$peliculas = Pelicula::buscaTodasPeliculasSelector();
	
	$campos = '<div>'.
				'<p>Sala '.
				'<select name="salas">';
        
	for($i = 0; $i < sizeof($salas); $i++)
		$campos .= '<option value="'.$salas[$i].'">'.$salas[$i].'</option>';
          
	$campos .= '</select></p>'.
		'</div>';
		$campos .= '<p>3D
					<select name="TD">
					<option value="1"> Sí </option>
					<option value="0"> No </option>
					</select></p>';
		
	$campos .= '<div>Fecha <input type="datetime-local" name="fecha"></div>';
	$campos .= '<div>Película <select name="peliculas">';
	
	for($i = 0; $i < sizeof($peliculas); $i++)
		$campos .= '<option value="'.$peliculas[$i]->getTitulo().'">'.$peliculas[$i]->getTitulo().'</option>';

	$campos .= '</select></div>';
	
    $camposFormulario=<<<EOF
		$campos
		<button class="button_input" type="submit">Añadir</button></p>
EOF;
    return $camposFormulario;
  }

  /**
   * Procesa los datos del formulario.
   */
	protected function procesaFormulario($datos)
	{
		$result = array();
		$ok = true;
		
		$sala = isset($datos['salas']) ? $datos['salas'] : null;
		
		if(!$sala)
		{
			$result[] = 'Seleccione una sala antes de añadir el horario.';
			$ok = false;
		}
		
		$fecha = isset($datos['fecha']) ? $datos['fecha'] : null;
		
		if(!$fecha)
		{
			$result[] = 'Seleccione una fecha antes de añadir el horario.';
			$ok = false;
		}
		
		$pelicula = isset($datos['peliculas']) ? $datos['peliculas'] : null;
		
		if(!$pelicula)
		{
			$result[] = 'Seleccione una película antes de añadir el horario.';
			$ok = false;
		}
		
		if($ok)
		{
			$TD = isset($datos['TD']) ? $datos['TD'] : null;
			$ok = Horario::anyadirHorario($sala, $fecha, $pelicula, $TD);
			
			if($ok)
				$result = \es\ucm\fdi\aw\Aplicacion::getSingleton()->resuelve('/i_gestor.php');
			else
				$result[] = 'No se ha podido añadir el horario';
		}
		
		return $result;
	}
}
?>