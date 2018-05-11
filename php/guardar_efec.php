<?php
	include('conexion.php');
	include('funciones.php');
	include($_SERVER['DOCUMENT_ROOT'].'/php/session2.php');
	
	date_default_timezone_set('America/Mexico_city');
	if ($_POST){	
		$folexpo 		= trim(strtoupper($_POST['folexpo']));
		$expediente		= trim(strtoupper($_POST['expediente']));
		$cnombre		= trim(strtoupper($_POST['nombre']));
		$moneda 		= trim(strtoupper($_POST['moneda_e']));
		$monto	 		= trim(strtoupper($_POST['imptepag_e']));
		$letras			= trim(strtoupper($_POST['letras_e']));
		$ciniciales		= trim(strtoupper($_POST['ciniciales']));
		$pasajero		= trim(strtoupper($_POST['pax_principal']));
		$idejec			= trim($_POST['cid_emplea']);
		$ctelefono 		= trim($_POST['ctelefono']);
		$destino 		= trim($_POST['destino']);
		$fsalida 		= trim($_POST['fsalida']);
		$tcambio		= trim($_POST['tipo_c']);
		$dfecha			= date('Y-m-d');
		$chora			= date('H:i:s');
		$ftc 			= date('Y-m-d');
		$f_modif		= date('Y-m-d H:i:s');
		$banco			= '';		
		$concepto		= 'EFECTIVO';
		$desglosa 		= 1;
	
		$id				= $_SESSION['id'];
		$elaboro		= $id;
		
		
		if ($moneda =='MXN'){
			$importeusd	= trim($_POST['impte_usd']);
		}
		else{
			$importeusd = $monto;
		}
			
		$nrecibo		= numeracion('RECIBO');
		$cid_solicitud	= numeracion('SOLICITUD');

		$encrip 		= encrip($moneda, $dfecha, $nrecibo, $monto, $tcambio, $ftc, '0');

		$insertsolicitud = "INSERT INTO solicitudes(cid_solicitud, cid_expediente, dfecha, chora, tipo, documento, fechaemitido, horaemitido, estatus, folio, moneda, importe) VALUES ('$cid_solicitud','$expediente','$dfecha','$chora','RE','EF','$dfecha','$chora', 'EM','$nrecibo','$moneda','$monto')";			
			mysqli_query($conx,$insertsolicitud) or die ("<h2> SOLICITUD NO REGISTRADA </h2>".mysqli_errno($conx).$insertsolicitud);
		
		$insertrecibo = "INSERT INTO recibodig(folio, nombre, telefono, pasajero, destino, cid_expediente, fsalida, concepto, fechsaop, dfecha, fechatc, intercam, banco, cuenta, moneda, referencia, monto, letras, iniciales, cid_solici, desglosa, fechahoy, encrip, legvar1, legvar2, cid_empleado, cancelado, elaboro) VALUES ('$nrecibo','$cnombre','$ctelefono','$pasajero','$destino','$expediente','$fsalida','EFECTIVO','$dfecha', '$dfecha','$ftc','$tcambio','$banco','','$moneda','','$monto','$letras','$ciniciales','$cid_solicitud','1','$dfecha','$encrip','','','$id','0','$elaboro')";
		mysqli_query($conx,$insertrecibo) or die ("<h2> RECIBO NO REGISTRADO </h2>".mysqli_errno($conx).$insertrecibo);
		//echo "<h2> RECIBO REGISTRADO </h2>"*/; 
		
	 
		$insertdefectivo = "INSERT INTO defectivo(cid_solicitud, numint, moneda, importe, importeventa, importeusd, importebanc, dfecha, hora, fechatc, fechaop, pcombanc, combanc, piva, iva, pcargoad, cargoad, referencia) VALUES ('$cid_solicitud','$banco','$moneda','$monto','$monto','$importeusd','$monto','$dfecha','$chora','$ftc','$dfecha','0','0','0','0','0','0','')";
		mysqli_query($conx,$insertdefectivo) or die ("<h2> EFECTIVO NO REGISTRADO </h2>".mysqli_errno($conx).$insertdefectivo);
		//echo "<h2> EFECTIVO REGISTRADO</h2>"*/;

	//$folexpo 		= encode_this("folio=".$folexpo);
	$foliorecibo	= encode_this("folio=".$nrecibo."&folexpo=".$folexpo);

	header("Location: recibo_imprime.php?".$foliorecibo);
	}
?>
	<script type="text/javascript">
	/*	alert('RECIBO GENERADO');
		var folexpo = document.getElementById("folexpo").value;
		var recibo 	= document.getElementById("recibo").value;
		window.open("recibo_imprime.php?"+recibo);*/
	//	window.location.assign("../procesa_pago.php?"+folexpo);
	</script>
