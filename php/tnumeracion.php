<?php
	function numeracion($concepto){
		include('conexion.php');
	
		$sql	= "SELECT * FROM tnumeracion WHERE cconcepto='$concepto'";
		$result = mysqli_query($conx, $sql);
		$row 	= mysqli_fetch_assoc($result);

		$UltimoNumero	= trim($row['nnumero']) + 1;
		$_letra			= trim($row['calfabeto']);
		$suma			= "UPDATE tnumeracion SET nnumero = $UltimoNumero WHERE cconcepto = '$concepto'";
		mysqli_query($conx,$suma) or die ("¡Ha ocurrido un error en la numeración!".mysqli_errno($conx).$suma);

		if($concepto == 'EXPEDIENTE'){
			$respuesta = 'OUT17'.str_pad($UltimoNumero, 5, "0", STR_PAD_LEFT);
		}
		if($concepto == 'RECIBO'){
			$respuesta = 'EXP17'.str_pad($UltimoNumero, 4, "0", STR_PAD_LEFT);
		}
		if($concepto == 'SOLICITUD'){
			$respuesta = 'SCE7'.str_pad($UltimoNumero, 5, "0", STR_PAD_LEFT);
		}
		if($concepto == 'CLIENTE'){
			$respuesta = 'MCE7'.str_pad($UltimoNumero, 3, "0", STR_PAD_LEFT);
		}
		if($concepto == 'FUNCIONARIO'){
			$respuesta = 'FNE7'.str_pad($UltimoNumero, 3, "0", STR_PAD_LEFT);
		}
		if($concepto == 'FOLIO'){
			$respuesta = str_pad($UltimoNumero, 4, "0", STR_PAD_LEFT);
		}
		return $respuesta;
	}


function encrip($moneda, $dfecha, $folio, $cant, $tc, $ftc, $dtosf){

	$cdig	= '';

	//Campo 3 - PARTE NUMERICA DEL FOLIO - +6
	$fn		= trim(substr($folio,3,(strlen($folio)-3)));
	$cdig	= $cdig.$fn;
	//echo $fn."-";
	//}

	//CAMPO 5 - FECHA DE EXPEDICIÓN - +6
	$fech	= $dfecha;
	$fex	= substr($fech,8,2).substr($fech,5,2).substr($fech,2,2);
	$cdig	= $cdig.$fex;
	//echo $fex."-";

	//CAMPO 6 - FECHA DE TIPO DE CAMBIO +6
	$fechat	= $ftc;
	$fes	= substr($fechat,8,2).substr($fechat,5,2).substr($fechat,2,2);
	$cdig	= $cdig.$fes;
	//echo $fes."-";

	//CAMPO 7 - TIPO DE CAMBIO +6
	$ce		= (int)($tc);
	$cdd	= (($tc-$ce)*10000);
	$ces	= trim(substr($ce,0,2));
	$cds	= trim(substr($cdd,0,4));

		if (strlen($cds)<4){
			$cds	= '0'+$cds;
		}
	$tcs	= $ces.$cds;
	//echo $tcs."-";
	$cdig	= $cdig.$tcs;
	//CAMPO 8 - MONTO - CANTIDAD TOTAL DEL RECIBO +9
	$ce		= (int)($cant);
	$cdd	= ($cant - $ce)*100;

	//PASAR LOS DECIMALES A STRING Y SI ES MENOR A 10 CENTAVOS AGREGARLE UN CERO
		if ($cdd < 10){
			$cds	= '0'.(substr($cdd,0,1));
		}
		else{
			$cds	= substr($cdd,0,2);
		}
	$ces	= trim(substr($ce,0,10));

	$cants	= $ces.$cds;
	/*echo $cds."<br>"; 	
	echo $cants."<br>";*/
		if(strlen($cants) < 10){
			$cants	= str_repeat("0",(10-strlen($cants))).$cants;
		}

	$cdig	= $cdig.$cants;
	//echo $cants."-  <BR>";

	//$cadena	= '';
	//$cdig	= 'EXPMXN1600081603161003161898000000164525';

	//CAMBIAR A LETRAS
				function decifra($cadena){
				$cad = str_split(strtoupper($cadena)); 
				$texto = '';
				$x = 0;
				while($x < strlen($cadena)){
					switch ($cad[$x]){
						case '1':
							$letra = 'S';
							break;
						case '2':
							$letra = 'O';
							break;
						case '3':
							$letra = 'Y';
							break;
						case '4':
							$letra = 'T';
							break;
						case '5':
							$letra = 'U';
							break;
						case '6':
							$letra = 'P';
							break;
						case '7':
							$letra = 'A';
							break;
						case '8':
							$letra = 'D';
							break;
						case '9':
							$letra = 'R';
							break;
						case '0':
							$letra = 'E';
							break;
					}
					$texto .= $letra;
					$x++;
				}
				return $texto;
			}
			
	$cadena		= decifra($cdig);		
	//CAMBIAR LA CADENA A MAYUSCULAS MINUSCULAS 
	$cadena		= (substr($folio,0,3).$moneda).(substr($cadena,0,34));
	//echo $cadena."<br>";
	$cadenae	= '@';
		for($x = 0 ; $x<=strlen($cadena) ; $x++){
			$r1	= $x/2;
			$r2	= $r1-(int)($r1);
				if ($r2>0){
					$cadenae	= $cadenae.substr($cadena,$x,1);
				}
				else{
					$cadenae	= $cadenae.strtolower(substr($cadena,$x,1));
				}
			}	
	$cadenae	= trim($cadenae.$dtosf.'@');
	$total		= strlen($cadenae);
	return ($cadenae);	
	//echo "160008-160316-100316-189800-0000164525- <BR>";

	//echo $cadenae." ".$total;
	}	
?>
