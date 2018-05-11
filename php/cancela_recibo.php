<?php
/*
Cancela recibo desde ./procesa_pago.php
*/

date_default_timezone_set('America/Mexico_City');
include($_SERVER['DOCUMENT_ROOT'].'/php/session2.php');
include('conexion.php');

$recibo 	= $_GET['recibo']; //Folio recibo
$folexpo	= $_GET['folexpo'];  //Folio expo 
$solicitud 	= $_GET['solicitud'];  //Solicitud
$motivo 	= strtoupper($_GET['motivo']); //Motivo de cancelación
$id 		= $_SESSION['id']; //id usuario
$fcancela	= date('Y-m-d H:i:s');
$fcan 		= date('Y-m-d');

$imprime	=	encode_this("folio=".$recibo."&folexpo=".$folexpo);

//Cambio de estatus de Solicitud
	$sql2	= "UPDATE solicitudes SET
				estatus			= 'CA',
				comentario		= '$motivo',
				fechacan		= '$fcan'
				WHERE
				cid_solicitud	= '$solicitud'";
				mysqli_query($conx,$sql2) or die ("ERROR AL CANCELAR SOLICITUD".mysqli_errno($conx).$sql2);				   				
//Cambio de estatus en recibodig, motivo, id, y fecha de cancelación	
	$sql = "UPDATE recibodig SET 
			cancelado		= 1,
			motivocanc		= '$motivo',
			quiencancela	= '$id',
			fcancela		= '$fcancela'
			WHERE
			folio			= '$recibo'";
	mysqli_query($conx,$sql) or die ("<script>alert('ERROR AL CANCELAR RECIBO');</script>".mysqli_errno($conx).$sql);
?>
<!-- Redirige a recibo_imprime.php, muestra recibo para imprimir-->
<meta http-equiv="refresh" content="0; url=recibo_imprime.php?<?php echo $imprime?>">