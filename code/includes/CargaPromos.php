<?php

namespace es\ucm\fdi\aw;

class CargaPromos {

  public function __construct() {}

  public function generaPromos () {
	   $html = "";
	   $uPromos = array();
	   $uPromos = Promo::buscaPromos();
	   if($uPromos != null){
		   $max = sizeof($uPromos);
		   $i = 0;   
		   while($i < $max){
				echo '<a href="'.$uPromos[$i]->getPDF().'" target="_blank">';
					echo '<img src="'.$uPromos[$i]->getImagen().'" />';
				echo '</a>';			   
			   $i++;
		   }
	   }
  }
  
  public function generaTodasPromosGestor() {
	   $html = "";
	   $uPromos = array();
	   $uPromos = Promo::buscaPromos();
	   if($uPromos != null){
		   $max = sizeof($uPromos);
		   $i = 0;   
		   while($i < $max){
				echo '<tr>';
					echo '<td>';
						echo '<p>'.$uPromos[$i]->getId().'</p>';
					echo '</td>';
					echo '<td>';
						$this->eliminarPromo($uPromos[$i]->getId());
					echo '</td>';
				echo '</tr>';
				
			   $i++;
		   }
	   }
  }
  
  private function eliminarPromo($idPromo){
    $formEliminarPromo = new \es\ucm\fdi\aw\FormularioEliminarPromo($idPromo); $formEliminarPromo->gestiona();
  }
}
?>