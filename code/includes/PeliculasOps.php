<?php

namespace es\ucm\fdi\aw;

/**
 * Clase de  de gestión de tablas.
 *
 * Gestión de token CSRF está basada en: https://www.owasp.org/index.php/PHP_CSRF_Guard
 */
class PeliculasOps {

  public function __construct() {

  }

  /**
   * Función que genera el HTML necesario para la tabla.
   */
  public function generaCartelera() {
    $idpelis = array();
    $idpelis = Pelicula::buscaPeliculasCart();
    $app = Aplicacion::getSingleton();   
    if($idpelis != null){
        $max = sizeof($idpelis);
        $i = 0;
        while($i < $max){
          echo '<div class="c_pelicula">';
          echo '<div class="c_imagen">';
          $pelisDatos = Pelicula::buscaPeliculas($idpelis[$i]);
          echo '<a href="'.$app->resuelve('/horarios.php?id='.$idpelis[$i].'').'">
                <img src="'.$pelisDatos->getImg().'"/></a>';

    			echo '</div>';
    			echo '</div>';
          $i++;
       }
     }else{
      echo '<h3 class="estilo_centrado">En este momento no hay películas en la cartelera</h3>';
     }
  }

  public function generaProxPeliculas () {
     $uPeliculas = array();
     $uPeliculas = Pelicula::buscaProxPeliculas();
     if($uPeliculas != null){
       $max = sizeof($uPeliculas);
       $i = 0;   
       while($i < $max){         
         echo '<div class="c_pelicula_prox">';
            echo '<div class="c_imagen_prox">';
             echo '<img src="'.$uPeliculas[$i]->getImg().'"/>';
          echo '</div>';
          echo '<div class="c_datos">';
             echo '<h4>'.$uPeliculas[$i]->getTitulo().'</h4>';
             echo '<p><span class="negrita">Fecha: </span>'.$uPeliculas[$i]->getFecha().'</p>';
             echo '<p><span class="negrita">Sinópsis: </span> </p>';
             echo '<p>'.$uPeliculas[$i]->getSinopsis().'</p>';
           echo '</div>';
         echo '</div>';
         
         $i++;
       }
     }else{
      echo '<div class="estilo_bloque_grande">';
        echo '<h2>En este momento no hay próximas películas.</h2>';
      echo '</div>';
     }
  }

  public static function peliculasDatosHorario($idPeli){
    if(isset($idPeli) && ctype_digit($idPeli)){
      $pelicula = Pelicula::buscaPeliculas($idPeli);
      if(isset($pelicula) && $pelicula){
        echo '<div>';
        
        echo '<img id="imagen_horario" src="'.$pelicula->getImg().'"/>';
        echo '<div id="listadatos_horario">';
        echo  '<ul>';
        echo    '<li><span class="negrita">Título: </span>'.$pelicula->getTitulo().'</li>';
        echo    '<li><span class="negrita">Año: </span>'.$pelicula->getFecha().'</li>';
        echo    '<li><span class="negrita">Género: </span>'.$pelicula->getGenero().'</li>';
        echo    '<li><span class="negrita">Duración: </span>'.$pelicula->getDur().' min</li>';
        echo    '<li><span class="negrita">Director: </span>'.$pelicula->getDirect().'</li>';
        echo    '<li><span class="negrita">Reparto: </span>'.$pelicula->getReparto().'</li>';
        echo    '<li id="sinopsis"><span class="negrita">Sinopsis: </span>'.$pelicula->getSinopsis().'</li>';
        echo  '</ul>';
          
        echo  '<div id="valoracion">';
        
        $valor = "";
        $i = 0;
        
        while($i < $pelicula->getValor()) {
          $valor .= "&#9733 ";
          $i++;
        }
        
        echo    'Valoración: <span>'.$valor.'</span>';
        echo  '</div>';
        echo '</div>';
        
        
        echo'</div>';

        echo  '<div id="horas" class="estilo_centrado">';
       echo  '<div id="horario">';
        echo    '<p>Fecha ';
        $app = Aplicacion::getSingleton();
        $days = $app->getDias(3);
        echo  '<select name="fecha" id="fecha">';
        $i = 0;
        while($i<3){
          echo  '<option id="dia" value="'.$days[$i].'">'.$days[$i].'</option>';
          $i++;
        }
        echo  '</select></p>';
        echo  '</div>';
        echo  '<ul id="lista_horas">';
        echo  '</ul>';
        echo  '</div>';
      }
      else
	  {
		echo '<div class="estilo_bloque">'.
				'<h2>Acceso restringido.</h2>'.
			'</div>';
	  }
  
    }
    else
      echo '<div class="estilo_bloque">'.
				'<h2>Acceso restringido.</h2>'.
			'</div>';

  }


   public static function generaTodasPeliculas () {
     $uPeliculas = array();
     $uPeliculas = Pelicula::buscaTodasPeliculasSelector();
     if($uPeliculas != null){
       $max = sizeof($uPeliculas);
       $i = 0;   
       while($i < $max){
         
         echo '<tr>';
         echo '<td>';
         echo '<p>'.$uPeliculas[$i]->getTitulo().'</p>';
         echo '</td>';
         echo '<td>';
         $formEliminarPelicula = new \es\ucm\fdi\aw\FormularioEliminarPelicula($uPeliculas[$i]->getId()); 
         $formEliminarPelicula->gestiona();
         $ruta = \es\ucm\fdi\aw\Aplicacion::getSingleton()->resuelve('/editar_pelicula.php?pelicula='.$uPeliculas[$i]->getId() );
         echo '<a href="'.$ruta.'">';
         echo '<img src="img/editar.png" />';
         echo '</a>';
         echo '</td>';
         echo '</tr>';
         
         $i++;
       }
     }
  }

  public function muestraDias($numDias) {
  echo  '<div id="horas" class="estilo_bloque_grande">';
       echo  '<div id="horario">';
        echo    '<p>Fecha ';
        $app = Aplicacion::getSingleton();
        $days = $app->getFechas(7);
        echo  '<select name="fecha" id="fecha">';
        $i = 0;
        while($i<7){
          echo  '<option id="dia" value="'.$days[$i].'">'.$days[$i].'</option>';
          $i++;
        }

        echo  '</select></p>';
        echo  '</div>';
        echo  '<p>Horas ';
        echo  '<select name="l_horas" id="l_horas">';
        echo  '</select></p>';
    echo  '</div>';
       
}

}
?>