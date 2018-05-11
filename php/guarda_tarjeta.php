<?php
	include('conexion.php');
	include('funciones.php');
	include($_SERVER['DOCUMENT_ROOT'].'/php/session2.php');
	
	date_default_timezone_set('America/Mexico_city');
		//$id 			= $_SESSION['id'];
		$elaboro		= $_POST['elaboro'];
		$folexpo		= $_POST['folexpo'];		
		$expediente		= $_POST['expediente'];
		$nrecibo		= numeracion('RECIBO');
		$cid_solicitud	= numeracion('SOLICITUD');

		$consulta 		= "SELECT * FROM expo_mov WHERE cid_expedi = '$expediente'";
		$res 			= mysqli_query($conx, $consulta);
		$row 			= mysqli_fetch_assoc($res);
		$pasajero		= $row['cnombre'].' '.$row['capellidop'].' '.$row['capellidom'].' X '.$row['numpax'];				
		$ciniciales		= $row['ciniciales'];
		$cid_emplea 	= $row['cid_emplea'];
		$id 			= $cid_emplea;
		$nvendedor 		= $row['nvendedor'];
		$cliente 		= strtoupper($_POST['nombre_t']);
		$moneda_t 		= $_POST['moneda'];
		$destino		= $row['destino'];
		$ndestino   	= strtoupper(trim($row['destino']));
		$fsalida		= $row['fsalida'];
		$telefono		= '('.$row['clada'].') '.$row['ctelefono'].' '.$row['cext'];

		$instrumento	= $_POST['instrumento'];
		$codigo_t		= $_POST['codigo'];
		$ftc_t 			= date('Y-m-d');
		$chora 			= date('H:i:s');
		$dfecha			= $ftc_t;
		$fechaop		= $ftc_t;
		$tarjeta_t 		= $_POST['tarjeta'];
		$autoriza_t		= $_POST['autorizacion'];
		$tc_t			= $_POST['tc_b'];
		$tipo_t			= $_POST['tipotarjeta'];
		$valida_t		= $_POST['valido'];
		$importe_t		= $_POST['importe_t'];
		$letras_t		= $_POST['impteletra'];
		$procede_t		= $_POST['procedencia'];
		$mov_t			= $_POST['movimiento'];
		$titular 		= $_POST['titular'];
		$moneda_c 		= $_POST['moneda_cuenta'];
		$n_cuenta		= $_POST['n_cuenta'];
		$bancop 		= $_POST['procedencia'];
		//$auttarj 		= $_POST['autorizacion';]		

		$terminal_t		= explode("|",$_POST['terminal_t']);
		$terminal 		= trim($terminal_t[0]); //TPVx

		$banco_t		= explode("-",$_POST['bancoaplic']);
		$banco 			= trim($banco_t[0]); //NUMINT
		$nbanco 		= trim($_POST['nbanco']); //NOMBRE BANCO
		$cargos_t 		= explode("-",$_POST['cargos']);
		$cargo 			= $cargos_t[0];
		$nid_cargo		= $cargos_t[2];
		$pcargoad 		= $cargos_t[4];
		$pcombanc 		= $cargos_t[5];
		$cargoad		= (($pcargoad * $importe_t) / 100);
		$combanc		= $importe_t * ($pcombanc / 100);
		$importevta 	= ($importe_t - $cargoad);
		if($pcombanc != ''){
			$piva = 16;
		}else{
			$piva = 1;
		}
		$iva  		= ($combanc * $piva) / 100;


		if($moneda_t == 'MXN'){
			$impteUSD = round(($importevta / $tc_t),2);
		}else{
			$impteUSD = $importevta;
		}
		$importebanc = ($importe_t) - ($combanc + $iva);
		$encrip		 = encrip($moneda_t, $dfecha, $nrecibo, $importe_t, $tc_t, $ftc_t, '0');	

		//CARGOS ADMINISTRATIVOS A SERVICIOS - PCARGOAD	
		$enterop 	= '';
		$decimales	= '';
		$porcenta 	= '';
		$cconcepto 	= '';
		if ($pcargoad > 0){	
			$enterop 	= (integer)$pcargoad;
			$decimales	= (($pcargoad)-($enterop))*100;
			$porcenta 	= trim($pcargoad).'.'.trim($decimales);
			$cconcepto 	= 'Com. Tarj. Bancaria '.$porcenta.' %';
		}
		//VERIFICAR QUE NO EXISTA EL MOVIMIENTO
		if ($moneda=='USD'){
			$cantidad = round(($cargoad)/($tc_t),2);
		}
		else{
			$cantidad = $cargoad;
		}


	$insertsolicitud	= "INSERT INTO `solicitudes`(`cid_solicitud`,`cid_expediente`,`dfecha`,`chora`,`tipo`,`documento`,
					`fechaemitido`,`horaemitido`,`estatus`,`folio`,`moneda`,`importe`) VALUES ('$cid_solicitud','$expediente','$dfecha','$chora','RE','TB','$dfecha','$chora','EM', '$nrecibo', '$moneda_t', $importe_t)";
	mysqli_query($conx,$insertsolicitud) or die ("<h2> SOLICITUD NO REGISTRADA </h2>".mysqli_errno($conx).$insertsolicitud);

	$insertdtarjetab	= "INSERT INTO `dtarjetab`(`cid_solicitud`, `numint`, `moneda`, `terminal`, `instrumento`, `tarjeta`,
				`tipo`, `bancop`, `titular`, `notarjeta`, `cuenta`, `codigo`,`valido`,`movimiento`, `importe`, `pcargoad`, `cargoad`, `importeventa`,`importeusd`, `pcombanc`, `combanc`, `piva`, `iva`, `importebanc`, `dfecha`,
				`hora`, `fechatc`, `fechaop`, `nid_cargo`,`auttarj`,`cid_expediente`) VALUES ('$cid_solicitud','$banco','$moneda_t','$terminal', '$instrumento','$tarjeta_t','$tipo_t','$procede_t','****','****','$n_cuenta','$codigo_t','$valida_t','$mov_t', $importe_t,$pcargoad,$cargoad, $importevta, $impteUSD,$pcombanc,$combanc,$piva,$iva,$importebanc,'$fechaop','$chora','$ftc_t','$fechaop','$nid_cargo','$autoriza_t','$expediente')";	 
	mysqli_query($conx,$insertdtarjetab) or die ("<h2> TARJETA NO REGISTRADA </h2>".mysqli_errno($conx).$insertdtarjetab); 

$buscasoli 	= "SELECT cid_solicitud FROM ventas WHERE cid_solicitud='$cid_solicitud'";
$found 		= mysqli_query($conx,$buscasoli);
if (mysqli_num_rows($found)==0){
	$insertventas 	= "INSERT INTO ventas (`servicio`,`concepto`,`texto`,`cid_solicitud`,`individual`,`pax`,`subtotal`,`comisionable`,`serie`,`fecha`,`id_serv`,`id_cons`,`num`) VALUES ('Otros Servicios','$cconcepto','Pago a Meses','$cid_solicitud',$cantidad,1,$cantidad,'0','1','$dfecha','4','43','0')";
	$cantidad_d		= 0;
}
else{
	$cantidad_o 	= $cantidad;
	$insertventas	="UPDATE ventas SET 
				servicio		=	'Otros Servicios',
				concepto		=	'',
				texto			=	'Pago a Meses',
				cid_solicitud	=	'$cid_solicitud',
				individual		=	'',
				pax				=	'1',
				subtotal		=	'',
				comisionable	=	'1',
				serie			=	'1',
				fecha			=	'$dfecha',
				id_serv			=	'4',
				id_cons			=	'43',
				num				=	'0' 
				WHERE
				cid_solicitud	=	'$cid_solicitud'";
	$cantidad_d	= $cantidad_o - $cantidad;
}
mysqli_query($conx,$insertventas) or die ("<h2> VENTA NO REGISTRADA </h2>".mysqli_errno($conx).$insertventas);

//VERIFICAR QUE NO EXISTA EL MOVIMIENTO
$buscavtasop	= "SELECT cid_solicitud FROM vtasoperador WHERE cid_solicitud='$cid_solicitud'";
		$found	= mysqli_query($conx,$buscasoli);
if (!$found){
	//DAR DE ALTA EN OPERADORES  EL MOVIMIENTO
	$insertvtasop 	= "INSERT INTO vtasoperador (`tipo`,`operador`,`descriserv`,`importe`,`moneda`,	`importeusd`,`fecha`,`cid_expediente`,`cid_operador`,`idexpe`,`fill`,`cid_solcitud`) VALUES ('T','$banco','$cconcepto',$cantidad,'$moneda',$cantidad,'$dfecha','$expediente','BCO','000000000000000','B','$cid_solicitud')";
	$cantidad_d 	= 0;
}
else{
	$insertvtasop 	= "UPDATE vtasoperador SET 
				tipo			=	'T',
				operador		=	'$banco',
				descriserv		=	'',
				importe			=	'',
				moneda			=	'$moneda',
				importeusd		=	'',
				fecha			=	'$dfecha',
				cid_expediente	=	'$expediente',
				cid_operador	=	'BCO',
				idexpe			=	'000000000000000',
				fill			=	'B',
				cid_solicitud	=	'$cid_solicitud' 
				WHERE 
				cid_solicitud	=	'$cid_solicitud'";
	$cantidad_d 	= $cantidad_o - $cantidad ;
}
mysqli_query($conx,$insertvtasop) or die ("<h2> VENTA NO REGISTRADA </h2>".mysqli_errno($conx).$insertvtasop);

	$insertrecibo	= "INSERT INTO `recibodig`(`folio`, `nombre`, `telefono`, `pasajero`, `destino`,`cid_expediente`,`fsalida`, `concepto`, `fechsaop`,`dfecha`, `fechatc`,`intercam`,`banco`, `cuenta`,`moneda`, `referencia`, `monto`,`letras`, `iniciales`, `cid_solici`, `desglosa`, `fechahoy`,`encrip`,`cid_empleado`,`cancelado`,`elaboro`) VALUES ('$nrecibo','$cliente','$telefono','$pasajero','$ndestino','$expediente','$fsalida','TARJETA BANCARIA','$dfecha','$dfecha','$ftc_t','$tc_t','$nbanco',$n_cuenta,'$moneda_t','$autoriza_t','$importe_t','$letras_t','$ciniciales','$cid_solicitud','0','$dfecha','$encrip','$id','0','$elaboro')";	
			
	mysqli_query($conx,$insertrecibo)or die ("<h2> RECIBO NO REGISTRADO </h2>".mysqli_errno($conx).$insertrecibo);

	$foliorecibo	= encode_this("folio=".$nrecibo."&folexpo=".$folexpo);

	header("Location: recibo_imprime.php?".$foliorecibo);

?>