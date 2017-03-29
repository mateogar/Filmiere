<?php

namespace es\ucm\fdi\aw;

class FormularioCambiarPelicula extends Form {

  const HTML5_EMAIL_REGEXP = '^[a-zA-Z0-9.!#$%&\'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$';

  private $numSala;
  private $hora;

  public function __construct($numSala, $hora) {
	$opciones = array();
	$opciones['action'] = '/pag/includes/peliculas_DiayHora.php?diaH='.$hora;
    parent::__construct('formCambiarPelicula'.$numSala.$hora, $opciones);
    $this->numSala = $numSala;
    $this->hora = $hora;
  }
  
  protected function generaCamposFormulario ($datos) {
    $todasPeliculas = Pelicula::buscaTodasPeliculasSelector();
    $camposFormulario = $this->selectPeliculas($todasPeliculas);
    $camposFormulario.= '<p>3D
          <select name="TD">
          <option value="1"> Sí </option>
          <option value="0"> No </option>
          </select></p>';
    $camposFormulario.=<<<EOF
    <input type="submit" name="submit" value="Confirmar"/>
EOF;
	
    

    return $camposFormulario;
  }

  /**
   * Procesa los datos del formulario.
   */
  protected function procesaFormulario($datos) {
	$result = array();
    session_regenerate_id(true);
    if(isset($_POST['submit'])){
      $selected_val = $_POST['peliculaS'];
      $select_val = $_POST['TD'];
      if(Pelicula::buscarPeliculaEnSala($this->numSala))
        Pelicula::cambiarPeliculaSala($this->numSala, $selected_val, $this->hora, $select_val);
      else
        Horario::anyadirHorario($this->numSala, $this->hora, $selected_val, $select_val);
	
	  $result = \es\ucm\fdi\aw\Aplicacion::getSingleton()->resuelve('/i_gestor.php');
    }
	return $result;
  }


  private function selectPeliculas($todasPeliculas) {
    $html = '';
    $html .='<select name="peliculaS" id="peliculaS" >';
    $max = sizeof($todasPeliculas);
    for($i = 0; $i < $max; $i++) 
     $html .='<option value="' . $todasPeliculas[$i]->getId() . '"> '. $todasPeliculas[$i]->getTitulo() . '</option>'; 
    $html .= '</select>';
    return $html;
  }
}
