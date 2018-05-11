<?php
	date_default_timezone_set('America/Mexico_city');
	include($_SERVER['DOCUMENT_ROOT'].'/php/session2.php');
	include('conexion.php');
	include('funciones.php');
	$folexpo 	= trim($_GET['folio']);

	$consulta 	= "SELECT * FROM expo_mov WHERE folexpo = '$folexpo'";
	$res 		= mysqli_query($conx, $consulta);
	$row 		= mysqli_fetch_assoc($res);

	$folexpo 	= trim($row['folexpo']);
	$cnombre 	= strtoupper(trim($row['cnombre']));
	$capellidop = strtoupper(trim($row['capellidop']));
	$capellidom = strtoupper(trim($row['capellidom']));

	$lada 		= trim($row['clada']);
	$telefono 	= trim($row['ctelefono']);
	$cext 		= trim($row['cext']);
	$tipotel 	= trim($row['ctipotel']);
	$cmail 		= trim($row['cmail']);
	$cid_destin = trim($row['cid_destin']);
	$destino 	= trim($row['destino']);
	$totalpaq 	= trim($row['totpaquete']);
	$moneda		= trim($row['moneda']);
	$nid_depto	= trim($row['nid_depto']);
	$depto 		= trim($row['nid_depto']);
	$fsalida 	= trim($row['fsalida']);
	$pax 		= trim($row['numpax']);
	$iniciales 	= trim($row['ciniciales']);
	$ejecutivo 	= trim($row['nvendedor']);
	$cid_emplea = trim($row['cid_emplea']);
	$expediente = trim($row['cid_expedi']);
	$observa 	= trim($row['observa']);
	$tc 		= trim($row['tc']);
	$impteapag 	= trim($row['impteapag']);
	$monedap 	= trim($row['monedap']);
	$letras 	= trim($row['letras']);
	$dfecha 	= date('Y-m-d');
	$chora 		= date('H:i:s');
	$f_modif 	= date('Y-m-d H:i:s');
	$cid_cliente= numeracion('CLIENTE');
	$cid_funcion= numeracion('FUNCIONARIO');

	if($expediente == ''){
		$expediente = numeracion('EXPEDIENTE');
	}

	#EXPEDIENTE
	$insertexpe	= "INSERT INTO expediente (`folexpo`,`cid_expediente`,`dfecha`,`chora`,
			`identificador`,`importe`,`comvtas`,`estatus`,`moneda`,`cid_cliente`,`iva`,
			`tipopaq`,`f_modif`,`totpaq`,`minapagar`,`fecha_apertura`,`numempleado`,`dfechasalida`,`pax`, `inicempleado`, `nomempleado`)
			VALUES ('$folexpo','$expediente','$dfecha','$chora','OUT',$totalpaq,2.00,1,'$moneda','$cid_cliente',$totalpaq,'S','$f_modif',$totalpaq,$totalpaq,'$dfecha','$cid_emplea','$fsalida',$pax, '$iniciales', '$ejecutivo')";
			mysqli_query($conx,$insertexpe) or die ("NO REGISTRADO".mysqli_errno($conx).$insertexpe);

	#CLIENTE		
	$insertcliente= "INSERT INTO tclientes (`cid_cliente`,`ctipocliente`,`cnombre`,`capellidop`,`capellidom`,`clada`,`ctelefono`,`cext`,`ctipotelefono`,`cmail`)
			VALUES ('$cid_cliente','D','$cnombre','$capellidop','$capellidom','$clada','$telefono',
			'$cext','$tipotel','$cmail')";
			mysqli_query($conx,$insertcliente) or die ("CLIENTE NO REGISTRADO".mysqli_errno($conx).$insertcliente);

	#FUNCIONARIO
	$insertfuncionario	= "INSERT INTO tfuncionario (`cid_funcionario`,`cnombre`,`capellidop`,`capellidom`,`cid_cliente`,`cmailfunc`,`cladaf`,`ctelefonof`,`cextf`,`ctipotelefonof`) VALUES ('$cid_funcion','$cnombre','$capellidop','$capellidom','$cid_cliente','$cmail','$clada','$telefono','$cext','$tipotel')";
	mysqli_query($conx,$insertfuncionario) or die ("FUNCIONARIO NO REGISTRADO".mysqli_errno($conx).$insertfuncionario);

	#PASAJERO
	$insertpas	= "INSERT INTO pasajeros (`apellidop`,`apellidom`,`nombre`,`titulo`,`principal`,`cid_expediente`) VALUES ('$capellidop','$capellidom','$cnombre','MR','1','$expediente')";
	mysqli_query($conx,$insertpas) or die ("PASAJERO NO REGISTRADO".mysqli_errno($conx).$insertpas);

	#CONFIRMACIÓN
	$insertconfir	= "INSERT INTO confirmacion (`cid_client`,`cid_emplea`,`cid_destpa`,`dfechahora`,
	`dfechasal`,`moneda`,`totpaq`,`minpag`,`tipopaq`,`f_modif`,`cid_expediente`,`mail`,`consec`)
	VALUE ('$cid_cliente','$cid_emplea','$cid_destin','$f_modif','$fsalida','$moneda','$totalpaq','$totalpaq','S','$f_modif','$expediente','$cmail','1')";
	mysqli_query($conx,$insertconfir) or die ("CONFIRMACION NO REGISTRADA".mysqli_errno($conx).$insertconfir);

	#EXPEDIENTE EN EXPO_MOV
	$insertexpo	= "UPDATE expo_mov SET 
		cid_expedi	=	'$expediente',
		status		=	'P',
		tproceso	=	'$dfecha'
		WHERE
		folexpo		=	'$folexpo'";
	mysqli_query($conx,$insertexpo) or die ("ERROR AL AGREGAR EXPEDIENTE".mysqli_errno($conx).$insertexpo);

	echo 'HECHO';
?>