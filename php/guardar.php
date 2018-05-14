<?php
	require_once('conexion.php');
	include('funciones.php');
	include($_SERVER['DOCUMENT_ROOT'].'/php/session2.php');
	$fecha    = date('Y-m-d');
	$select   = "SELECT (`tcambio`) FROM tcambio WHERE fecha='$fecha'";
	$result   = mysqli_query($conx, $select);
	if (mysqli_num_rows($result)>0) {
		$row  = mysqli_fetch_assoc($result);
	    $tc   = $row['tcambio'];
	}
	else{ $tc = 0; }

	date_default_timezone_set('America/Mexico_city');
	if ($_POST){		
		
		$fmov 			= date('Y-m-d H:i:s');
		$horamov		= date('H:i:s');
		$ftc			= date('Y-m-d');
		$nombre 		= strtoupper($_POST['nombre']);
		$apellidop 		= strtoupper($_POST['apellidop']);
		$apellidom 		= strtoupper($_POST['apellidom']);
		//$tc 			= $_POST['tc'];
		$lada			= $_POST['lada'];
		$telefono		= $_POST['telefono'];
		$ext			= $_POST['ext'];
		$tipotel		= $_POST['tipotel'];
		$correo 		= strtoupper($_POST['correo']);
		
		$fsalida 		= $_POST['fechas'];
		$npax			= $_POST['pax'];
		$observa		= strtoupper($_POST['comentarios']);
		$totpqt			= $_POST['imptepqt'];
		$monpqt			= $_POST['monedapqt'];
		$anticipo		= $_POST['anticipo'];
		$monpago		= $_POST['monpago'];
		$impteletra		= $_POST['impteletra'];
		$ideje			= $_POST['id'];
		$nombreje 		= strtoupper($_POST['usu']);
		$mailejec 		= strtoupper($_POST['mail']);
		$iniciales 		= strtoupper($_POST['iniusu']);

		$destino		= strtoupper($_POST['destino']);
		$cdestpack 		= explode("§", $destino);
		$cid_destpack 	= trim($cdestpack[1]);
		$nombre_dest 	= trim($cdestpack[0]);

		$busqueda 	= "SELECT * FROM tdestpack WHERE cid_destpack LIKE '$cid_destpack%'";
		$resultado  = mysqli_query($conx,$busqueda);
		$row 		= mysqli_fetch_assoc($resultado);
		$nid_area	= $row['nid_area']; 

		$sql		= "SELECT * FROM tareas WHERE nid_area = $nid_area";
		$res 		= mysqli_query($conx,$sql);
		$col 		= mysqli_fetch_assoc($res);		
		$nid_depto	= $col['nid_depto']; 
		

		if(isset($_POST['cotiza'])){
			$status = 'X';
		}else{
			$status = 'E';
		}

		if($_POST['grabar'] == 'grabar'){ //NUEVO REGISTRO
			$folio			= numeracion('FOLIO');

			$inserta = "INSERT INTO expo_mov(folexpo, fechahora, hora, ftc, cnombre, capellidop, capellidom, clada, ctelefono, cext, ctipotel, cmail, fsalida, numpax, observa, totpaquete, moneda, impteapag, monedap, cid_emplea, nvendedor, fecha, status, cid_destin, destino, nid_depto, nid_area, letras, tc, mailejec, ciniciales ) VALUES ('$folio', '$fmov', '$horamov', '$ftc', '$nombre', '$apellidop', '$apellidom', '$lada', '$telefono', '$ext', '$tipotel', '$correo', '$fsalida', $npax, '$observa', $totpqt,'$monpqt', $anticipo, '$monpago', '$ideje', '$nombreje', '$fmov', '$status', '$cid_destpack', '$nombre_dest', $nid_depto, $nid_area, '$impteletra', $tc, '$mailejec', '$iniciales')";
			mysqli_query($conx,$inserta) or die("<h2> ERROR EL INGRESAR REGISTRO </h2>".mysqli_errno($conx).$inserta);
		}elseif ($_POST['grabar']=='editar') { //ACTUALIZACIÓN 
			$folio = $_POST['folexpo'];
			# code...
			$actualiza = "UPDATE expo_mov SET fechahora = '$fmov' , hora = '$horamov' , ftc = '$ftc' , cnombre = '$nombre' , capellidop = '$apellidop' , capellidom = '$apellidom' , clada = '$lada' , ctelefono = '$telefono' , cext = '$ext' , ctipotel = '$tipotel' , cmail = '$correo' , fsalida = '$fsalida' , numpax = $npax , observa = '$observa' , totpaquete = $totpqt , moneda = '$monpqt' , impteapag = $anticipo , monedap = '$monpago' , cid_emplea = '$ideje' , nvendedor = '$nombreje' , fecha = '$fmov' , status = '$status' , cid_destin = '$cid_destpack' , destino = '$nombre_dest' , nid_depto = $nid_depto , nid_area = $nid_area , letras = '$impteletra' , tc = $tc , aplic = '' WHERE folexpo = '$folio'";
			//echo($actualiza);
			mysqli_query($conx,$actualiza) or die("<h2> ERROR EL ACTUALIZAR DATOS </h2>".mysqli_errno($conx).$actualiza);
		}
	}
		
header('Location: ../reporte_ejecutivo.php');
?>