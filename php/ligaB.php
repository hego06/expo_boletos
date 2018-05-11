<?php
	date_default_timezone_set('America/Mexico_City');

include('conexion.php');
include('funciones.php');
include($_SERVER['DOCUMENT_ROOT'].'/php/funciones.php');
include($_SERVER['DOCUMENT_ROOT'].'/php/mail.php');
include($_SERVER['DOCUMENT_ROOT'].'/php/fecha.php');
include($_SERVER['DOCUMENT_ROOT'].'/php/cifraget.php');


			$nfolio		=	$_GET['folio'];
			$fechahora	=	date('Y-m-d H:i:s');
			$hora		=	date('H:i:s');
			$ftc		=   date('Y-m-d');
			$fechaexp	= 	explode('-',$ftc);
			$hoy		= "Ciudad de México a ".$fechaexp[2] ." de ". $arrayMeses[$fechaexp[1]-1]." del ". $fechaexp[0].", ".date('H:i:s');	
			$fecha_ 	= 	$fechaexp[2] ." de ". $arrayMeses[$fechaexp[1]-1]." del ". $fechaexp[0].", ".date('H:i:s');	
						
						
						
	$nrec	= "SELECT * FROM expo_mov WHERE folexpo='$nfolio'";
			$result 	=	mysqli_query($conx, $nrec);
			$row 		=	mysqli_fetch_assoc($result);

			$folexpo	=	$row['folexpo'];

			$mailejec	=	$row['mailejec'];
			$id			=   $row['cid_emplea'];
			$iniusu		=   $row['iniusu'];
			$usu		=   $row['nvendedor'];
			
						
			$cnombre	=	$row['cnombre'];
			$capellidop	=	$row['capellidop'];
			$capellidom	=	$row['capellidom'];
			$clada		=	$row['clada'];
			$ctelefono	=	$row['ctelefono'];
			$cext		=	$row['cext'];
			$cmail		= 	$row['cmail'];
			$ndestino	=	$row['cid_destin'];
			$destino	=	$row['destino'];
			$fsalida	=	$row['fsalida'];
			$cid_expedi	=	$row['cid_expedi'];
			$fsalidaCom	= 	explode('-',$fsalida);
			$fsalidaRec	= $fsalidaCom[2] ." de ". $arrayMeses[$fsalidaCom[1]-1]."
						del ". $fsalidaCom[0].".";	
			
			$pasajeros	=	$row['numpax'];
			$importeapag=	$row['impteapag'];
			$tmoneda	=	$row['monedap'];
			$letras		=	$row['letras'];
			$ctipotel	=	$row['ctipotel'];
			$quien_soli	=	trim(trim(strchr($mailejec,"@",true)));
			$nomcte		= 	$cnombre.' '.$capellidop.' '.$capellidom;
			$comentarios= 	$row['comentarios'];

			if($tmoneda == 'MXN'){
					$importeusd	= 0.00;
					$importemxn	= $importeapag;
					$tipom		= 1;
			}
			if($tmoneda == 'USD'){
					$importemxn	= 0.00;
					$importeusd	= $importeapag;
					$tipom		= 2;

			}
			

			$nrec	= "SELECT cons_liga FROM pagosweb ORDER BY cons_liga DESC LIMIT 1";
			$result = mysqli_query($conx, $nrec);
			if (!$result) {
				$consecutivo = '001';
			}
			elseif (mysqli_num_rows($result) > 0) {
				$row = mysqli_fetch_assoc($result);
				$consecutivo = str_pad($row['cons_liga']+1, 3, '0', STR_PAD_LEFT);
			} 
			else{
				$consecutivo = '001';
			}

			$folio_c= $folexpo.'_'.$consecutivo;	
			$referencia	= "https://pay.megatravel.com.mx?ID=$folio_c&MT=$ndestino&DD=$fsalida&TP=$importeapag&MON=$tipom&M=$quien_soli";

					
	//GENERAR CLIENTE -------------
	$cid_cliente 	= numeracion('CLIENTE');
	
	$insertcliente= "INSERT INTO tclientes(`cid_cliente`,`ctipocliente`,`cnombre`,`capellidop`,`capellidom`,`clada`,`ctelefono`,`cext`,`ctipotelefono`,`cmail`)VALUES ('$cid_cliente','D','$cnombre','$capellidop','$capellidom','$clada','$ctelefono',			'$cext','$ctipotel','$cmail')";
			mysqli_query($conx,$insertcliente)or die ("CLIENTE NO REGISTRADO".mysqli_errno($conx).$insertcliente);


	
	$pagosweb	= "INSERT INTO `pagosweb`(`fechahora`, `cid_expediente`, `fechasalida`, `tchoy`, `cid_cliente`, `nomcte`, `cid_destpack`, `nomdestpack`, `cid_empleado`, `nomempleado`, `emailejec`, `nomcontacto`, `emailcontacto`, `importemxn`, `importeusd`, `referencia`,`estatus`,`monedapag`, `npax`,`cons_liga`) VALUES ('$fechahora','$folexpo','$fsalida','$tcambio','$cid_cliente','$nomcte','$ndestino','$destino','$id','$usu','$mailejec','$nomcte','$cmail','$importemxn','$importeusd','$referencia','L','$tmoneda','$pasajeros','$consecutivo')";
   		mysqli_query($conx,$pagosweb)or die ("Error al guardar Pago Web".mysqli_errno($conx).$pagosweb);
			
		
	$status	= "UPDATE expo_mov SET 
					status		= 'L',
					tproceso	= '$ftc'
					WHERE 
					folexpo		=	'$folexpo'";
   				mysqli_query($conx,$status)	or die ("Error al Actualizar Status".mysqli_errno($conx).$status);
			
			
			echo 'HECHO';
			$asunto  = "LIGA PARA PAGO";			
			include('liga_correo.php');
			correo($cmail.';'.$mailejec, $asunto, $mensaje);
?>
