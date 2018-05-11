<?php		
	include($_SERVER['DOCUMENT_ROOT'].'/php/cifraget.php');	
	$id				= $_POST['cid_solicitud'];
	$reci			= $_POST['recibo'];
	
	$uploadDir 		= "doctosop";
	$inputFileNam 	= $id;
	$pdf 			= include ($_SERVER['DOCUMENT_ROOT'].'/php/subepdf.php');

	$id	= encode_this('id='.$id.'&reci='.$reci);	
	if ( $pdf == 'Archivo cargado'){
		echo  "<script>alert('¡Voucher Cargado!');</script><meta http-equiv='refresh' content='0; url=doctosop.php?$id'>";
	}
	else{
		echo  "<script>alert('¡Error al cargar Voucher!');</script><meta http-equiv='refresh' content='0; url=doctosop.php?$id'>";
	}		
?>