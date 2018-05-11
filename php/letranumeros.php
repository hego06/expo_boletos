<?php 
require "c_letranumeros.php";
$anticipo = $_GET['anticipo'];
$monpago  = $_GET['monpago'];
	switch ($monpago){ //TIPO DE MONEDA RECIBIDA
		case 'MXN':
			$monpago=' MXN';
			$monpago	= 'PESOS';
			break;
		case 'USD':
			$monpago=' USD';
			$monpago	= 'DÓLARES';
			break;
	}
 	$resultado = convertir($anticipo,$monpago);
	echo $resultado;
?>
