<?php

namespace es\ucm\fdi\aw;

use es\ucm\fdi\aw\Aplicacion as App;

class Promo {
 
  public static function buscaPromos() {
	$app = App::getSingleton();
    $conn = $app->conexionBd();
    $uPromos = array();
    $query = sprintf("SELECT * FROM promociones ORDER BY id_promo");
    $rs = $conn->query($query);
    while ($fila = $rs->fetch_assoc()) {
      $uPromos[] = new Promo($fila['id_promo'], $fila['imagen'],$fila['pdf']); 
    }
    $rs->free();
    return $uPromos;
  }
  
   public static function insertaPromo($promo) {
	$app = App::getSingleton();
    	$conn = $app->conexionBd();
		$query = sprintf("INSERT INTO `promociones` (`id_promo`, `imagen`, `pdf`) VALUES (NULL, '%s', '%s')",
		  $conn->real_escape_string($promo->getImagen()),
		  $conn->real_escape_string($promo->getPDF()));
		$rs = $conn->query($query);
		if($rs)
			return true;
		return false;
  }
  
  public static function eliminarPromo($idPromo){
    $app = App::getSingleton();
    $conn = $app->conexionBd();
    $query = sprintf("DELETE FROM promociones WHERE id_promo = '%d'",
      $conn->real_escape_string($idPromo));
    $rs = $conn->query($query);
  }

  private $id;
  private $imagen;
  private $pdf;
 


  public function __construct($ident, $img, $doc) {
    $this->id = $ident;
	$this->imagen = $img;
	$this->pdf = $doc;
  }

   public function getId() {
    return $this->id;
  }
  
  public function getImagen() {
    return $this->imagen;
  }
  
  public function getPDF() {
    return $this->pdf;
  }

}
?>