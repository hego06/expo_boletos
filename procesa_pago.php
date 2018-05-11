<?php 
	include($_SERVER['DOCUMENT_ROOT'].'/php/session2.php');
	include($_SERVER['DOCUMENT_ROOT'].'/objeto/templeado.php');
	include($_SERVER['DOCUMENT_ROOT'].'/objeto/deptos.php');
	include('php/conexion.php');

	$hoy = date('Y-m-d');

	$ejecutivo	= imprimeEmp($_SESSION['id']);
	$id			= $_SESSION['id'];
	
	if($_GET){
		decode_get2($_SERVER["REQUEST_URI"]);
		 $fechahora 	= date ('Y-m-d');
		 $select		= "SELECT (`tcambio`) FROM tcambio WHERE fecha='".$fechahora."'";
		 $result 	= mysqli_query($conx, $select);
		if (mysqli_num_rows($result)>0) {
			$row = mysqli_fetch_assoc($result);
			$tc	= number_format($row['tcambio'],2);
		}
		else{
			$tc	= '00.00';
		}

		$folexpo 	= $_GET['folio'];
		$consulta 	= "SELECT * FROM expo_mov WHERE folexpo = '$folexpo'";
		$res 		= mysqli_query($conx, $consulta);
		$row 		= mysqli_fetch_assoc($res);

		$folexpo 	= trim($row['folexpo']);
		$cliente 	= strtoupper(trim($row['cnombre']).' '.trim($row['capellidop']).' '.trim($row['capellidom']));
		$lada 		= trim($row['clada']);
		$telefono 	= trim($row['ctelefono']);
		$cext 		= trim($row['cext']);
		$tipotel 	= trim($row['ctipotel']);
		$cmail 		= trim($row['cmail']);
		$destino 	= strtoupper(trim($row['cid_destin']).' - '.trim($row['destino']));
		$totalpaq 	= number_format(trim($row['totpaquete']),2).' '.trim($row['moneda']);
		$depto 		= trim($row['nid_depto']).' - '.especificoDepto(trim($row['nid_depto']));
		$fsalida 	= ddmmmaaaa(trim($row['fsalida']));
		$pax 		= trim($row['numpax']);
		$ejecutivo 	= trim($row['ciniciales']).' - '.trim($row['nvendedor']);
		$expediente = trim($row['cid_expedi']);
		$observa 	= trim($row['observa']);
		//$tc 		= trim($row['tc']);
		$impteapag 	= number_format(trim($row['impteapag']),2);
		$letras 	= trim($row['letras']);
		$estatus 	= $row['status'];
		$detalle 	= '';
		$ligaE 		= encode_this("expediente=".$expediente);
		if($expediente == '' && $estatus != 'L'){
			$ligaB		= "<td><button type='button' class='btn btn-warning btn-sm g_liga' id='g_liga' name='g_liga'data-toggle='tooltip' data-placement='top' title='GENERAR LIGA BANCARIA'>GENERAR LIGA BANCARIA</button></td>";
			$btn_expe 	= "<td><button type='button' class='btn btn-success btn-sm g_expe' data-toggle='tooltip' data-placement='top' title='GENERAR EXPEDIENTE'>GENERAR EXPEDIENTE</button></td>";
			$tipo_pago	= '';
		}
		if($expediente == '' && $estatus == 'L'){
			$ligaB		= "<td><span class='text-danger'>LIGA BANCARIA</span></td>";
			$btn_expe 	= "<td></td>";
		}
		if($expediente !=''){
			$ligaB		= "<td>&nbsp;</td>";
			$btn_expe 	= "<th>EXPEDIENTE</th><td>$expediente</td>";
			$buscaMov	= "SELECT * FROM recibodig WHERE cid_expediente = '$expediente'";
			$result		= mysqli_query($conx, $buscaMov);
			if (mysqli_num_rows($result) > 0 ) {
				$importeusd	= 0;
				$importemxn	= 0;
				$detalle= "<table class='table'>
								<thead>
									<tr>
										<th width='15%'>Solicitud</th>
										<th width='12%'>Emitida</th>
										<th width='12%'>Recibo</th>
										<th width='10%'>Importe</th>
										<th width='10%'>Moneda</th>
										<th width='10%'>Descargar</th>
										<th width='10%'>Cancelar</th>
									</tr>
								</thead>
							</table>
							<div class='row row-margin botton-20' style='overflow:auto;height:150px;'>
							<table class='table table-hover table-striped table-bordered'>
								<tbody>
									<col width='10%'>
								    <col width='12%'>
								    <col width='12%'>
								    <col width='10%'>
								    <col width='10%'>
								    <col width='10%'>
								    <col width='10%'>";
				while($row = mysqli_fetch_assoc($result)) {
					$cid_solici	= $row['cid_solici'];	 
					$dfecha		= ddmmmaaaa($row['dfecha']);
					$nrecibo	= $row['folio'];
					$importe_re	= $row['monto'];
					$moneda_mov	= $row['moneda'];
					$canc		= $row['cancelado'];
					$quien		= $row['quiencancela'];
					if($canc == 0){
						$clase = "class='success'";
					}else{
						$clase = "class='danger'";
					}
					if($moneda_mov =='MXN'){
						$impusd	= 0;
						$impmxn = $importe_re;
					}
					else{
						$impusd	= $importe_re;
						$impmxn = 0;
					}
				$folioRecibo = encode_this("folio=".$nrecibo);
				$detalle	.= "<input hidden name='folioRecibo' id='folioRecibo' value='$folioRecibo'>
								<tr $clase style='cursor:pointer;'>
									<td onclick='visualiza(\"$nrecibo\")' >$cid_solici</td>
									<td onclick='visualiza(\"$nrecibo\")' >$dfecha</td>
									<td onclick='visualiza(\"$nrecibo\")'  id='folioR' name='folioR'>$nrecibo</td>
									<td onclick='visualiza(\"$nrecibo\")' >".number_format($importe_re,2)."</td>
									<td onclick='visualiza(\"$nrecibo\")'  align='center'>$moneda_mov</td>
									<td align='center'>
									<a href='recibodig/$nrecibo.pdf' download>
										<button class='btn btn-default btn-xs iconos' data-toggle='tooltip' data-placement='bottom' title='DESCARGAR RECIBO' id='' name=''>
								    		<i class='fa fa-cloud-download' aria-hidden='true'></i>
								    	</button>
								    </a>
								    </td>
									<td align='center'>";
					if($canc == 0){
						$detalle.= "<button class='btn btn-default btn-xs iconos' data-toggle='tooltip' data-placement='bottom' title='CANCELAR RECIBO' type='button' onclick='cancelaR(\"$nrecibo\",\"$folexpo\",\"$cid_solici\")'>
								    		<i class='fa fa-times-circle' aria-hidden='true'></i>
								    	</button>";
						$importeusd	+=	$impusd;
						$importemxn	+=	$impmxn;
					}else{
						$detalle.= '&nbsp;';
					}					
				$detalle	.= "    </td>
								</tr>";

				
			}
			$detalle .= "</tbody>
						</table>
					</div>";
		}

	$tipo_pago	= '<div class="row">
								<div class="panel panel-info">
							    	<div class="panel-heading">
							    		<table width="100%">
							    			<tr>
							    				<td>DETALLE DE MOVIMIENTOS:</td>
							    				<td style="text-align:right;" class="text-danger">Dar click sobre el registro para ver el recibo</td>
							    			</tr>
							    		</table>
							    	</div>
							    	'.$detalle.'
							    </div>										
								<div class="col-md-4">
									<div class="panel panel-info">
								   		<div class="panel-heading">TIPO DE PAGO:</div>
								   		<table class="table centrar">
								   			<tr>
								   				<td>
								   					<a href="./efectivo.php?'.$ligaE.'">
								   						<button class="btn btn-default btn-xs iconos" data-toggle="tooltip" data-placement="bottom" title="EFECTIVO">
								    						<i class="fa fa-money" aria-hidden="true"></i>
								    					</button>
								    				</a>	
								    			</td>
								    			<td>
								    				<a href="./tarjeta.php?'.$ligaE.'">
									    				<button class="btn btn-default btn-xs iconos" data-toggle="tooltip" data-placement="bottom" title="TARJETA">
									    					<i class="fa fa-credit-card-alt" aria-hidden="true"></i>
									    				</button>
									    			</a>	
								    			</td>
								   			</tr> 
								   		</table> 
									</div>
								</div>
								<div class="col-md-3">&nbsp;</div>
								<div class="col-md-5">
									<div class="panel panel-info">
								    	<div class="panel-heading">TOTALES:</div>
								    	<table class="table centrar">
								    		<tr>
								    			<th class="centrar">MXN</th>
								    			<td class="text-danger">'.number_format($importemxn,2).'</td>
									    		<th class="centrar">USD</th>
									    		<td class="text-danger">'.number_format($importeusd,2).'</td>
								    		</tr>
								    	</table>
								    </div>	
								</div>
							</div>';

	}
}

?>
<html>
	<head>
		<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0" />
		<?php include ($_SERVER["DOCUMENT_ROOT"].'/php/head.php');?>
	</head>
<body>
	<div class="full-height header-background-main">
		<?php include ($_SERVER["DOCUMENT_ROOT"].'/php/topmenu.php');?>
		<?php include ($_SERVER["DOCUMENT_ROOT"].'/php/barralateral.php');?>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
		<script src="js/funciones.js"></script>
		<link rel="stylesheet" type="text/css" href="css/estilo.css">
		<main class="dashboard-full-size" onclick="openNav('')">
			<div class="row">
                <div class="col-md-12 work-container">
                    <div class="tit_caja1"><i class="fa fa-home icon-home-route"></i>Inicio <i class="fa fa-angle-right icon-arrow-route"></i>PROCESAR RECIBOS DE PAGO</div>
					<div class="work-area-box"><br>
						<div class="col-md-12 subtitulo-azul">PROCESAR RECIBOS DE PAGO</div>
						<div class="col-md-6">
							<div class="row">
								<div class="panel panel-info">
									<div class="panel-heading">DATOS DEL CLIENTE</div>
									<table class="table">
										<tr>
											<th>NOMBRE:</th>
											<td colspan="4" class="text-info"><?php echo $cliente; ?></td>
										</tr>
										<tr>
											<th rowspan="2" style="vertical-align: middle;">TELÉFONO:</th>
											<th>LADA</th>
											<th>NÚMERO</th>
											<th>EXT.</th>
											<th>TIPO</th>
										</tr>
										<tr>
											<td class="text-info"><?php echo $clada; ?></td>
											<td class="text-info"><?php echo $telefono; ?></td>
											<td class="text-info"><?php echo $cext; ?></td>
											<td class="text-info"><?php echo $tipotel; ?></td>
										</tr>
										<tr>
											<th>E-MAIL:</th>
											<td colspan="4" class="text-info" id='email_'><?php echo $cmail; ?></td>
										</tr>
									</table>
								</div>
							</div>
							<div class="row">
								<div class="panel panel-info">
									<div class="panel-heading">DATOS DEL PAQUETE</div>
									<table class="table">
										<tr>
											<th>DESTINO:</th>
											<td colspan="4" class="text-info"><?php echo $destino; ?></td>
											<!--<td>
												<button class="btn btn-default btn-xs iconos" data-toggle="tooltip" data-placement="left" title="EDITAR">
									    			<i class="fa fa-pencil-square-o" aria-hidden="true"></i>
									    		</button>
											</td>-->
										</tr>
										<tr>
											<th>TOTAL DEL PAQUETE:</th>
											<td colspan="2" class="text-info"><?php echo $totalpaq; ?></td>
											<th>DEPTO:</th>
											<td colspan="2" class="text-info"><?php echo $depto; ?></td>
										</tr>
										<tr>
											<th>FECHA DE SALIDA:</th>
											<td colspan="3" class="text-info"><?php echo $fsalida; ?></td>
											<th>NO. DE PASAJEROS:</th>
											<td  class="text-info"><?php echo $pax; ?></td>
										</tr>
										<tr>
											<th>EJECUTIVO(A):</th>
											<td colspan="5" class="text-info"><?php echo $ejecutivo; ?></td>
										</tr>
									</table>
								</div>
							</div>
							<div class="row">
								<div class="panel panel-info">
									<div class="panel-heading">COMENTARIOS</div>
									<div class="comentarios" style="height: 70px;max-height: 70px;"><?php echo $observa; ?></div>
								</div>
							</div>
						</div>


						<div class="col-md-6">
							<div class="row">
								<div class="panel panel-info">
									<div class="panel-heading">A PAGAR</div>
									<table class="table">
										<tr>
											<?php echo $ligaB; ?>
											<th>FOLIO</th>
											<td class="text-info" id='folexpo'><?php echo $folexpo; ?></td>
											<?php echo $btn_expe; ?>
										</tr>
										<tr>
											<th>TIPO DE CAMBIO:</th>
											<td class="text-info"><?php echo number_format($tc,2); ?></td>
											<th>IMPORTE A PAGAR:</th>
											<td colspan="2" class="text-info"><?php echo $impteapag; ?></td>
										</tr>
										<tr>
											<th>CANTIDAD CON LETRA:</th>
											<td colspan="4" class="text-info"><?php echo $letras; ?></td>
										</tr>
									</table>
								</div>
							</div>
							<?php echo $tipo_pago; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</main>
</div>
<!--MODAL QUE CARGA ARCHIVO -->
<div id="modalArchivo" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg">
	<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header" style="background-color: #1F3A93; color: #FFF;">
				<button type="button" class="close" data-dismiss="modal"><i class="cerrar fa fa-window-close" aria-hidden="true"></i></button>
				<h4 class="modal-title">RECIBO DE PAGO</h4>
			</div>
			<div class="modal-body" style="height: 500px;">
				<!-- LA FUNCIÓN DE JS QUE LO MUESTRA, CREA EL IFRAME -->
			</div>
		</div>
	</div>
</div>
<footer class="closed">
			<?php include($_SERVER['DOCUMENT_ROOT'].'/php/footer2.php') ?>
	</footer>
</body>
</html>
<script>
	$(document).ready(function(){
	    $('[data-toggle="tooltip"]').tooltip(); 
	});
</script>