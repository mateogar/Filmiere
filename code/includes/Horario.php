<?php

namespace es\ucm\fdi\aw;

use es\ucm\fdi\aw\Aplicacion as App;

class Horario {
	
  
	
	public static function anyadirHorario($sala, $fecha, $pelicula, $TD)
	{
		$app = App::getSingleton();
		$conn = $app->conexionBd();
		$date = explode("T", $fecha);
		$date = $date[0] . ' ' . $date[1] . ":00";
		$idPelicula = Pelicula::getIdPorTitulo($pelicula);
		
		if($idPelicula)
		{
			$sql = sprintf("INSERT INTO horario (sala, hora, id_pelicula, 3D) VALUES ('%d', '%s', '%d', '%d');",
			$conn->real_escape_string($sala),$conn->real_escape_string($fecha),$conn->real_escape_string($idPelicula)
			,$conn->real_escape_string($TD));
			$rs = $conn->query($sql);
			
			if($rs)
				return true;
			else
				return false;			
		}
		else
			return false;
	}
	
	public static function getHorarioPelicula($id_peli)
	{
		$app = App::getSingleton();
		$conn = $app->conexionBd();
		$sql = sprintf("SELECT * FROM horario WHERE id_pelicula = '%d' AND hora > CURRENT_DATE ORDER BY hora;",
		 $conn->real_escape_string($id_peli));
		$horas = array();
		$rs = $conn->query($sql);

		while($fila = $rs->fetch_assoc())
			$horas[] = new Horario($fila['id_horario'], $fila['sala'], $fila['hora'], $fila['id_pelicula'], $fila['3D']);

		$rs->free();

		return $horas;
	}

	public static function getHorarioDia($fecha) {
		$app = App::getSingleton();
		$conn = $app->conexionBd();
		$fechaMax = date('Y-m-d', strtotime($fecha. ' + 1 days'));
		$sql = sprintf("SELECT DISTINCT horario.hora AS hora FROM horario WHERE hora >= '%s' AND hora < '%s' ORDER BY hora",
		 $conn->real_escape_string($fecha), $conn->real_escape_string($fechaMax));
		$horas = array();
		$rs = $conn->query($sql);

		while($fila = $rs->fetch_assoc())
			$horas[] = new Horario($fila[null], $fila[null], $fila['hora'], $fila[null],$fila[null]);

		$rs->free();

		return $horas;

	}
	
	public static function getHorarioById($idHorario)
	{
		$app = App::getSingleton();
		$conn = $app->conexionBd();
		$query = sprintf("SELECT * FROM horario WHERE id_horario = '%d'", $conn->real_escape_string($idHorario));
		$rs = $conn->query($query);
		$horario = null;
		
		if($fila = $rs->fetch_assoc())
		  $horario = new Horario($fila['id_horario'], $fila['sala'], $fila['hora'], $fila['id_pelicula'],$fila['3D']); 
	  
		$rs->free();
		
		return $horario;
	}
  
  public static function es3D($idHorario){
		$app = App::getSingleton();
		$conn = $app->conexionBd();
		$query = sprintf("SELECT * FROM horario WHERE id_horario = '%d' AND 3D = 1", $conn->real_escape_string($idHorario));
		$rs = $conn->query($query);
		if($fila = $rs->fetch_assoc()) {
		   return true;  
		}
		else 
			return false;
		$rs->free();
		return $horario;
	 
  }
  
  
  private $idHorario;
  private $sala;
  private $hora;
  private $pelicula;
  private $TD;


  private function __construct($id, $nsala, $date, $peli, $TD) {
  	$this->idHorario = $id;
    $this->sala = $nsala;
  	$this->hora = $date;
  	$this->pelicula = $peli;
  	$this->TD = $TD; 
  }

  public function getPelicula(){
  	return $this->pelicula;
  }

  public function getTD(){
  	return $this->TD;
  }



  public function getSala(){
  	return $this->sala;
  }

	public function getId()
	{
		return $this->idHorario;
	}
	
	public function getHora()
	{
		return $this->hora;
	}
  
	public function getIdPelicula()
	{
		return $this->pelicula;
	}
	
	public static function getDia($date)
	{
		$dia = explode(" ", $date);
		$diaS = explode("-", $dia[0]);
		$diaFinal = $diaS[2].'-'.$diaS[1].'-'.$diaS[0];
		return $diaFinal;
	}
	
	


}
?>