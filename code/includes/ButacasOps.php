<?php

namespace es\ucm\fdi\aw;

class ButacasOps {

  public function __construct() {}
  
  public static function generaButacas($id_horario) {
	$horario = Horario::getHorarioById($id_horario);
	$nSala = $horario->getSala();
	echo  '<h2>Sala '.$nSala.'</h2>';
	$app = Aplicacion::getSingleton();
	$butaca = array();
	$butaca = Butaca::butacasSala($nSala);
	$butacasOcupadas = array();
	$butacasOcupadas = Butaca::butacasOcupadasEnSala($id_horario, $nSala);
	
	foreach($butacasOcupadas as &$bo)
		foreach($butaca as &$butacas)
			if($butacas->getFila() == $bo->getFila() && $butacas->getColumna() == $bo->getColumna())
				$butacas->setTipo('OCUPADA');
	
	$max = sizeof($butaca);
	$i = 0;
	
	if(!is_null($butaca)){
		$fila = $butaca[0]->getFila(); 
		echo '<p><span class="numFila">'.$butaca[0]->getFila().'     </span>';
	}
	while($i < $max){
		if($fila != $butaca[$i]->getFila()){
			$fila = $butaca[$i]->getFila();
			echo '</p>';
			echo '<p><span class="numFila">'.$butaca[$i]->getFila().'     </span>';
		}
		$tipo = $butaca[$i]->getTipo();
		if($tipo == 'NORMAL'){
			$rutaImg = $app->resuelve('/img/butaca.png');
			echo'<img class="img_butaca" src="'.$rutaImg.'" value="'.$butaca[$i]->getFila().'_'.$butaca[$i]->getColumna().'">';
		}else
			if($tipo == 'VIP'){
				$rutaImg = $app->resuelve('/img/especial.png');
				echo'<img class="img_butaca" src="'.$rutaImg.'" value="'.$butaca[$i]->getFila().'_'.$butaca[$i]->getColumna().'">';
			}else
				if($tipo == 'OCUPADA'){
					$rutaImg = $app->resuelve('/img/ocupado.png');
					echo'<img class="img_butaca_ocupada" src="'.$rutaImg.'" value="'.$butaca[$i]->getFila().'_'.$butaca[$i]->getColumna().'">';
				}else 
					if($tipo == 'MINUSVALIDOS'){
						$rutaImg = $app->resuelve('/img/minus.png');
						echo'<img class="img_butaca" src="'.$rutaImg.'" value="'.$butaca[$i]->getFila().'_'.$butaca[$i]->getColumna().'">';
					}
		$i++;
	}
  }
  
  public static function generaCampoCompraButacas($butacas, $date, $codigoPromo, $tipoDescuento){
		$app = Aplicacion::getSingleton();
		$sala = Butaca::getSalaEnHorario($date);
		$horario = Horario::getHorarioById($date);
		$filas = Butaca::getFilasSala($sala);
		$columnas = Butaca::getColumnasSala($sala);
		$butacas = explode(',',$butacas);
		$numButacas = sizeof($butacas);
		$ok = true;
		$i = 0;
		while($ok && $i<$numButacas){
			$b = $butacas[$i];
			$b = explode('_',$b);
			$f = $b[0];
			$c = $b[1];
			$ocupada = Butaca::estaOcupada($date, $f, $c);
			if($f<1 || $f>$filas || $c<1 || $c>$columnas){
				$ok=false;
			}else{
				if($ocupada){
					$ok=false;
				}else{
					$i++;
				}
			}
		}
		if($i<=$numButacas-1){
				echo '<h1>Se han introducido algunos datos erróneos</h1>';
				echo '<a href="butacas.php?date='.$date.'">Volver a selección de butacas</a>';
		}else{
			echo '<tr>'.
			'<th>Tipo Entrada</th>'.
			'<th>Precio</th>'.
			'</tr>';
			$i = 0;
			$precioTotal=0;
			while($i<$numButacas){
				$b = $butacas[$i];
				$b = explode('_',$b);
				$f = $b[0];
				$c = $b[1];
				$butaca = Butaca::buscaButacaSalaCompra($sala, $f, $c);
				echo '<tr>';
				echo '<td class="columnaTablaContactos">'.$butaca->getTipo().'</td>';
				$precio = Butaca::devuelvePrecio($butaca->getTipo());
				
				if($horario->getTD())
					$precio += Butaca::devuelvePrecio("3D");
				
				$precioTotal+=$precio;
					echo '<td class="columnaTablaContactos" id="precio_'.$i.'">'.$precio.' €</td>';
				echo '</tr>';
				$i++;
			}
			
			//Comprobar si hay que aplicar algún tipo de descuento
			echo '<tr >';
			echo '<td class="separador columnaTablaContactos">Total</td>';
			
			if($tipoDescuento != "sin_descuento")
			{
				if($tipoDescuento != "cod_promo")
				{
					$type = "SIN_DESCUENTO";
					
					switch($tipoDescuento)
					{
						case "sin_descuento":
							$type = "SIN_DESCUENTO";
							break;
						case "packmayor5":
							$type = "PACK_MAYOR_5";
							break;
						case "pack4o5":
							$type = "PACK_4o5";
							break;
						default:
							$type = "SIN_DESCUENTO";
					}
					
					$porcentajeDesc = Butaca::buscaPorcentajeDescuento($type);
					
					if($tipoDescuento == "packmayor5" || $tipoDescuento == "pack4o5")
					{
						$precioTotal = number_format($precioTotal, 2);
						$precioTotalAux = $precioTotal * ((100 - $porcentajeDesc) / 100);
						$precioTotalAux = number_format($precioTotalAux, 2);
						
						echo '<td class="separador columnaTablaContactos" id="precioTotal"> <strike>'.$precioTotal.' €</strike> '.$precioTotalAux.' €</td>';
					}
				}
				else
				{
					$codigo = CodigoPromo::getCodigoPromo($codigoPromo);
					
					if($codigo != null)
					{
						if($codigo->getEstado() == 1)
						{
							$precioTotal = number_format($precioTotal, 2);
							$precioTotalAux = $precioTotal * ((100 - $codigo->getPorcentajeDescuento()) / 100);
							$precioTotalAux = number_format($precioTotalAux, 2);
						
							echo '<td class="separador columnaTablaContactos" id="precioTotal"> <strike>'.$precioTotal.' €</strike> '.$precioTotalAux.' €</td>';
						}
						else
							echo '<td class="separador columnaTablaContactos" id="precioTotal">'.$precioTotal.'€ <p class="negrita">(Código desactivado)</p></td>';
					}
					else
						echo '<td class="separador columnaTablaContactos" id="precioTotal">'.$precioTotal.'€ <p class="negrita">(Código inválido)</p></td>';
				}
			}
			else
				echo '<td class="separador columnaTablaContactos" id="precioTotal">'.$precioTotal.' €</td>';
			
			
			echo '</tr>';
		}
	}
}
?>