<?php

namespace es\ucm\fdi\aw;

use es\ucm\fdi\aw\Aplicacion as App;

class Pelicula {

	public static function getIdPorTitulo($pelicula)
	{
		$app = App::getSingleton();
		$conn = $app->conexionBd();
		$query = sprintf("SELECT id_pelicula FROM peliculas WHERE titulo = '%s'", $conn->real_escape_string($pelicula));
		$rs = $conn->query($query);
		$id = false;
		
		if($fila = $rs->fetch_assoc())
			$id = $fila['id_pelicula'];
	  
		$rs->free();
		
		return $id;
	}

	public static function buscaPeliculasCart() {
		$app = App::getSingleton();
		$conn = $app->conexionBd();
		$idpelis = array();
		$query = sprintf("SELECT DISTINCT id_pelicula FROM peliculas NATURAL JOIN horario");
		$rs = $conn->query($query);
		while ($fila = $rs->fetch_assoc()) {
		  $idpelis[] = $fila['id_pelicula']; 
		}
		$rs->free();
		return $idpelis;
	}
	
	public static function buscaPeliculas($id) {
		$app = App::getSingleton();
		$conn = $app->conexionBd();
		$query = sprintf("SELECT * FROM peliculas WHERE id_pelicula = '%d'", $conn->real_escape_string($id));
		$rs = $conn->query($query);
		if($fila = $rs->fetch_assoc()) {
		  $pelicula = new Pelicula($fila['id_pelicula'],$fila['titulo'], $fila['fecha_estreno'],$fila['genero'],$fila['duracion_min'],$fila['director'],$fila['reparto'],$fila['sinopsis'], $fila['valoracion'] ,$fila['imagen']); 		  
		}
		else 
			return false;
		$rs->free();
		return $pelicula;
	}

	//Ahora que muestre todas las películas de horario
	//En un rato se le pasarán dia y hora y que muestre solo esas por cada sala.
	public static function buscaPeliculasGestor($dia) {
	$app = App::getSingleton();
	$conn = $app->conexionBd();
	$uPeliculas = array();
	$i = 0;
	$query = sprintf("SELECT DISTINCT horario.sala AS sala, peliculas.titulo AS titulo FROM horario,peliculas
	WHERE horario.id_pelicula = peliculas.id_pelicula AND horario.hora ='%s'
	ORDER BY horario.sala", $conn->real_escape_string($dia));
	$rs = $conn->query($query);
	
	while ($fila = $rs->fetch_assoc()) {
	  $uPeliculas[$i] = new Pelicula(null,$fila['titulo'], null,null,null,
	  	null,null,null,null ,null);
      $uPeliculas[$i]->setSala($fila['sala']);
      $i++; 
	}
	$rs->free();
	return $uPeliculas;
	}

	public static function buscaTodasPeliculasSelector() {
	$app = App::getSingleton();
	$conn = $app->conexionBd();
	$uPeliculas = array();
	$query = sprintf("SELECT * FROM peliculas");
	$rs = $conn->query($query);
	while ($fila = $rs->fetch_assoc()) {
	  $uPeliculas[] = new Pelicula($fila['id_pelicula'],$fila['titulo'], $fila['fecha_estreno'],$fila['genero'],$fila['duracion_min'],$fila['director'],$fila['reparto'],$fila['sinopsis'], $fila['valoracion'] ,$fila['imagen']); 
	}
	$rs->free();
	return $uPeliculas;
	}
  
	public static function buscaProxPeliculas() {
		$app = App::getSingleton();
		$conn = $app->conexionBd();
		$uPeliculas = array();
		$query = sprintf("SELECT * FROM peliculas WHERE fecha_estreno > CURRENT_DATE ORDER BY fecha_estreno");
		$rs = $conn->query($query);
		while ($fila = $rs->fetch_assoc()) {
		  $uPeliculas[] = new Pelicula($fila['id_pelicula'],$fila['titulo'], $fila['fecha_estreno'],$fila['genero'],$fila['duracion_min'],$fila['director'],$fila['reparto'],$fila['sinopsis'], $fila['valoracion'] ,$fila['imagen']); 
		}
		$rs->free();
		return $uPeliculas;
	}
	
	//Para buscar y mostrar en el index la proxima pelicula
	public static function buscaProximaPeliculaIndex() {
		$app = App::getSingleton();
		$conn = $app->conexionBd();
		$query = sprintf("SELECT * FROM peliculas WHERE fecha_estreno > CURRENT_DATE ORDER BY fecha_estreno LIMIT 1");
		$rs = $conn->query($query);
		if($fila = $rs->fetch_assoc()) {
		  $pelicula = new Pelicula($fila['id_pelicula'],$fila['titulo'], $fila['fecha_estreno'],$fila['genero'],$fila['duracion_min'],$fila['director'],$fila['reparto'],$fila['sinopsis'], $fila['valoracion'] ,$fila['imagen']); 
		}
		else 
			return false;
		$rs->free();
		return $pelicula;
	}
	
	public static function updatePelicula($pelicula){
		$app = App::getSingleton();
    	$conn = $app->conexionBd();
		$query = sprintf("UPDATE `peliculas` SET `titulo` = '%s', `fecha_estreno` = '%s', `genero` = '%s', `duracion_min` = '%d', `director` = '%s', `reparto` = '%s', `sinopsis` = '%s', `valoracion` = '%d', `imagen` = '%s' WHERE `peliculas`.`id_pelicula` = '%s';",
		  $conn->real_escape_string($pelicula->getTitulo()),
		  $conn->real_escape_string($pelicula->getFecha()),
		  $conn->real_escape_string($pelicula->getGeneroEnum()),
		  $conn->real_escape_string($pelicula->getDur()),
		  $conn->real_escape_string($pelicula->getDirect()),
		  $conn->real_escape_string($pelicula->getReparto()),
		  $conn->real_escape_string($pelicula->getSinopsis()),
		  $conn->real_escape_string($pelicula->getValor()),
		  $conn->real_escape_string($pelicula->getImg()),
		  $conn->real_escape_string($pelicula->getId()));
		  
		$rs = $conn->query($query);
		if($rs)
			return true;
		return false;
	}
	
	public static function getArrayGeneros()
  {
	return array('DRAMA','COMEDIA','CIENCIA_FICCION','BELICA','HISTORICA','TERROR','TRAGICOMEDIA');
  }

	public static function cambiarPeliculaSala($sala, $pelicula, $hora, $TD){
	$app = App::getSingleton();
	$conn = $app->conexionBd();
	print_r($pelicula);
	$query = sprintf("UPDATE horario SET id_pelicula = '%s', 3D = '%d' WHERE sala = '%d' AND hora = '%s'",
	 $conn->real_escape_string($pelicula),$conn->real_escape_string($TD),
	 $conn->real_escape_string($sala), $conn->real_escape_string($hora));
	$rs = $conn->query($query);
	if($rs)
		return true;

	return false;
	}
	
	public static function buscarPeliculaEnSala($sala)
	{
		$app = App::getSingleton();
		$conn = $app->conexionBd();
		$query = sprintf("SELECT * FROM horario NATURAL JOIN peliculas WHERE horario.sala= '%d'", $conn->real_escape_string($sala));
		$rs = $conn->query($query);
		$fila = $rs->fetch_assoc();
		$pelicula = new Pelicula($fila['id_pelicula'], $fila['titulo'], $fila['fecha_estreno'],$fila['genero'],$fila['duracion_min'],$fila['director'],$fila['reparto'],$fila['sinopsis'], $fila['valoracion'] ,$fila['imagen']);
		$rs->free();
		
		return $pelicula;
	}
	
	public static function eliminarPelicula($idPelicula){
		$app = App::getSingleton();
		$conn = $app->conexionBd();
		$query = sprintf("DELETE FROM peliculas WHERE id_pelicula = '%d'",
		  $conn->real_escape_string($idPelicula));
		$rs = $conn->query($query);
	}


	public static function insertaPelicula($pelicula){
		$app = App::getSingleton();
    	$conn = $app->conexionBd();
		$query = sprintf("INSERT INTO `peliculas`(`titulo`, `fecha_estreno`, `genero`,
		 `duracion_min`, `director`, `reparto`, `sinopsis`, `valoracion`, `imagen`)
		  VALUES('%s', '%s', '%s', '%d','%s','%s','%s','%d','%s')",
		  $conn->real_escape_string($pelicula->getTitulo()),
		  $conn->real_escape_string($pelicula->getFecha()),
		  $conn->real_escape_string($pelicula->getGeneroEnum()),
		  $conn->real_escape_string($pelicula->getDur()),
		  $conn->real_escape_string($pelicula->getDirect()),$conn->real_escape_string($pelicula->getReparto()),
		  $conn->real_escape_string($pelicula->getSinopsis()),$conn->real_escape_string($pelicula->getValor()),
		  $conn->real_escape_string($pelicula->getImg()));
			
		$rs = $conn->query($query);
		if($rs)
			return true;
		return false;
	}	

  
  private $id;
  private $titulo;
  private $fecha;
  private $genero;
  private $duracion;
  private $director; 
  private $reparto;
  private $sinopsis;
  private $valor;
  private $imagen;
  private $horario;
  private $sala;
 


  public function __construct($id, $title, $date, $gen, $dur, $dir, $rep, $sin, $val, $img) {
    $this->titulo = $title;
  	$this->fecha = $date;
  	$this->genero = $gen;
  	$this->duracion = $dur;
  	$this->director = $dir;
  	$this->reparto = $rep;
  	$this->sinopsis = $sin;
  	$this->valor = $val;
  	$this->imagen = $img;
    $this->id = $id;
  }


   public function getTitulo() {
    return $this->titulo;
  }
  
  public function getFecha() {
    return $this->fecha;
  }
  
  public function getGenero()
  {
	switch($this->genero)
	{
		case "DRAMA":
			return "Drama";
		case "COMEDIA":
			return "Comedia";
		case "CIENCIA_FICCION":
			return "Ciencia Ficcion";
		case "BELICA":
			return "Belica";
		case "HISTORICA":
			return "Historica";
		case "TERROR":
			return "Terror";
		case "TRAGICOMEDIA":
			return "Tragicomedia";
	}
	
	return "Indeterminado";
}
  
public function getGeneroEnum()
  {
	return $this->genero;
  }

  public function getDur() {
    return $this->duracion;
  }
  
  public function getDirect() {
    return $this->director;
  }
  
  public function getReparto() {
    return $this->reparto;
  }
  
  public function getSinopsis() {
    return $this->sinopsis;
  }
  
  public function getValor() {
    return $this->valor;
  }
  
  public function getImg() {
    return $this->imagen;
  }

  public function getId() {
    return $this->id;
  }

  public function setSala($sala) {
  	$this->sala = $sala;
  }

  public function getSala() {
  	return $this->sala;
  }
}
?>