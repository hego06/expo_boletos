<?php

	include('conexion.php');
	include($_SERVER['DOCUMENT_ROOT'].'/php/session2.php');
	include($_SERVER['DOCUMENT_ROOT'].'/php/fecha.php');
	include($_SERVER['DOCUMENT_ROOT'].'/php/cifraget.php');
	include($_SERVER['DOCUMENT_ROOT'].'/objeto/templeado.php');
	date_default_timezone_set('America/Mexico_city');

	if($_GET['tipo']=='N'){	
		$fecha1			= $_GET['f1'];
		$fecha2			= $_GET['f2'];	

		if($_GET['ejec']!=''){
			$extra	= " AND cid_empleado=".$_GET['ejec'];
		}else {
			$extra 	= '';	
		}
		
		$consultaPqts	= "SELECT * FROM expo_mov WHERE status = 'P'";
		$resPqts		= mysqli_query($conx,$consultaPqts);
		if ($resPqts){
			$totalvtas 	= mysqli_num_rows($resPqts);
		}else {
			$totalvtas	= 0;
		}
		
		$consulta	= "SELECT solicitudes.folio,expo_mov.cid_expedi,expo_mov.ciniciales,expo_mov.fecha,expo_mov.numpax,
						expo_mov.cnombre,expo_mov.capellidop,expo_mov.capellidom,expo_mov.destino,expo_mov.fsalida,expo_mov.totpaquete,
						expo_mov.moneda,solicitudes.documento,solicitudes.importe,solicitudes.moneda as monedap FROM expo_mov
						RIGHT JOIN solicitudes ON expo_mov.cid_expedi = solicitudes.cid_expediente
						WHERE expo_mov.fecha BETWEEN '".$fecha1."' AND '".$fecha2."' AND solicitudes.estatus='EM'".$extra." 
						GROUP BY solicitudes.folio ORDER BY cid_expediente";
		//echo $consulta;
		$result 	= mysqli_query($conx, $consulta);
		if ($result){	
			$html = "<table class='table'>
					<thead>
						<tr>
							<th width='5%' style='text-align:center;'>FECHA</th>
							<th width='5%' style='text-align:center;'>FOLIO</th>
							<th width='5%' style='text-align:center;'>EXPEDIENTE</th>
							<th width='5%' style='text-align:center;'>EJECUTIVO</th>
							<th width='5%' style='text-align:center;'>No.PAX</th>
							<th width='20%' style='text-align:center;'>CLIENTE</th>
							<th width='25%' style='text-align:center;'>DESTINO</th>
							<th width='5%' style='text-align:center;'>SALIDA</th>
							<th width='5%' style='text-align:center;'>PAQUETE</th>
							<th width='5%' style='text-align:center;'>MONEDA</th>
							<th width='5%' style='text-align:center;'>METODO DE PAGO</th>
							<th width='5%' style='text-align:center;'>IMPORTE</th>
							<th width='5%' style='text-align:center;'>MONEDA</th>
						</tr>
					</thead>
				</table>";
				
			$html.= "<div class='row row-margin botton-20' style='overflow:auto;height:350px;'>
						<table class='table table-bordered'>
							<tbody>
								<col width='5%'>
								<col width='5%'>
								<col width='5%'>
								<col width='5%'>
								<col width='5%'>
								<col width='20%'>
								<col width='25%'>
								<col width='5%'>
								<col width='5%'>
								<col width='5%'>
								<col width='5%'>
								<col width='5%'>
								<col width='5%'>";
								
								$totalpax			= 0;
								$totalPqtsUSD		= 0;
								$totalPqtsMXN		= 0;
								$totalVtasUSD		= 0;
								$totalVtasMXN		= 0;
								$expact				= mysqli_fetch_assoc($result);
										
								while($row = mysqli_fetch_assoc($result)) {
									$fecha 			= $row['fecha']; 
									$folio 			= $row['folio'];
									$expediente		= $row['cid_expedi'];
									$ejecutivopqt	= $row['ciniciales'];
									$npax			= $row['numpax'];
									$cliente 		= trim($row['cnombre']).' '.trim($row['capellidop']).' '.trim($row['capellidom']);	
									$destino 		= $row['destino'];
									$salida 		= $row['fsalida'];
									$totpaqt		= $row['totpaquete'];
									$monedapqt		= $row['moneda'];
									if($row['documento']='EF'){
										$formapago 	= 'EFECTIVO';
									}
									else{
										$formapago 	= 'TARJETA';
									}
									$importe		= $row['importe'];
									$monedapago		= $row['monedap'];

									if($expact!=$expediente){
										$html.="<tr bgcolor='#99FFCC'><td colspan='13'></td></tr>";
										$expact = $expediente;	
										$totalPax		= $totalPax + $npax;
										if ($monedapqt='USD'){
											$totalPqtsUSD	= $totalPqtsUSD + $totpaqt;
										}else {
											$totalPqtsMXN	= $totalPqtsMXN + $totpaqt;
										}
										
										if ($monedapago='USD'){
											$totalVtasUSD	= $totalVtasUSD + $importe;
										}else {
											$totalVtasMXN	= $totalVtasMXN + $importe;
										}									
									}
										$html.= "<tr height='25'>
											<td width='5%' align='center'>".$fecha."</td>
											<td width='5%' align='center'>".$folio."</td>
											<td width='5%' align='center'>".$expediente."</td>
											<td width='5%' align='center'>".$ejecutivopqt."</td>
											<td width='5%' align='center'>".$npax."</td>
											<td width='20%' align='center'>".$cliente."</td>
											<td width='25%' align='center'>".$destino."</td>
											<td width='5%' align='center'>".$salida."</td>
											<td width='5%' align='center'>".number_format($totpaqt,2)."</td>
											<td width='5%' align='center'>".$monedapqt."</td>
											<td width='5%' align='center'>".$formapago."</td>
											<td width='5%' align='center'>".number_format($importe,2)."</td>	
											<td width='5%' align='center'>".$monedapago."</td>							
										</tr>";
								}
				$html.="</tbody> </table></div>";
			
			if(mysqli_num_rows($result)>0){
				
				$html.= "<table class='table'>
						<thead>
							<tr>
								<th width='12%' style='text-align:center;'>Total de Ventas</th>
								<th width='13%' style='text-align:center;'>Total Pasajeros</th>
								<th width='13%' style='text-align:center;'>USD</th>
								<th width='13%' style='text-align:center;'>MXN</th>
								<th width='13%' style='text-align:center;'>USD</th>
								<th width='13%' style='text-align:center;'>MXN</th>
								<th width='13%' style='text-align:center;'>USD</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td width='12%' align='center'>".$totalvtas."</td>
								<td width='12%' align='center'>".$totalPax."</td>
								<td width='13%' align='right'> $ ".number_format($totalPqtsUSD)."</td>
								<td width='13%' align='right'> $ ".number_format($totalPqtsMXN)."</td>
								<td width='13%' align='right'> $ ".number_format($totalVtasUSD)."</td>
								<td width='13%' align='right'> $ ".number_format($totalVtasMXN)."</td>
							</tr>
						</tbody>
					</table>
					<div class='col-md-2'>
						<div class='row'>
							<div class='panel panel-primary' style='text-align:center;' >
								<div class='panel-heading'>EXPORTAR</div>
									<table class='table'>
										<tr>
											<td style='text-align:center;cursor:pointer;'  data-toggle='tooltip' data-placement='bottom' title='REPORTE EXCEL' onClick=exportaVtas(\"E\")><img width='32px' src='https://".$_SERVER['SERVER_NAME']."/img/excel.gif'></td>
										</tr>
									</table>
								</div>
							</div>
						</div>		
					</div>";
			}else{
				$html= "<span class='item-canceled'>NO SE ENCONTRARON RESULTADOS</span>";
			}
			echo $html;
		}
	}

	
	//REPORTE EXCEL
	
	elseif($_GET['tipo']=='E'){
		
		$fecha1 	= $_GET['f1'];
		$fecha2 	= $_GET['f2'];
		$ejecutivo 	= $_GET['ejec'];
		$extra 		= '';
		$rango		= "Del ".ddmmmaaaa22(trim(substr($_GET['f1'],0,10)))." Al ".ddmmmaaaa22(trim(substr($_GET['f2'],0,10)));
		$hoy		= "Ciudad de México a ".ddmmmaaaa22(trim(substr(date('Y-m-d'),0,10))).", ".date('H:i:s');	
		$usuario	= imprimeEmp($_SESSION['id']);
		$id			= $_SESSION['id'];
		
	
		if(!empty($ejecutivo)){
			$extra 			= " AND cid_empleado='".$ejecutivo."'";
			$tipoReporte 	= "<td colspan='15' align='center'>Ejecutivo: <strong> "  .InicialesEmp($ejecutivo)."</strong> ".imprimeEmp($cid)."</td>";
		}
		else{
			$tipoReporte	= "<td colspan='15' align='center'><strong>REPORTE GENERAL</strong></td>";
		}
	
		$cb 		= "";
		$consultaE 	= "SELECT round(sum(if(concepto='TARJETA BANCARIA' && moneda='MXN',monto,0)),2) AS montoTarjM,
					round(sum(if(concepto='TARJETA BANCARIA' && moneda='USD',monto,0)),2) AS montoTarjU,
					round(sum(if(concepto='EFECTIVO' && moneda='MXN',monto,0)),2) AS montoEfecM,
					round(sum(if(concepto='EFECTIVO' && moneda='USD',monto,0)),2) AS montoEfecU,
					cid_expediente,folio,pasajero FROM recibodig WHERE dfecha BETWEEN '".$fecha1."' AND '".$fecha2."' AND cancelado='0'".$extra." 
					GROUP BY cid_expediente ORDER BY cid_expediente";
		$resExcel 	= mysqli_query($conx, $consultaE);
	
		header('Content-Type: text/html; charset=utf-8');
		header('Content-type: application/vnd.ms-excel;charset=utf-8');
		header("Content-Disposition: attachment; filename=reporte ".$_GET['fecha1']."-".$_GET['fecha2'].".xls");
		header("Pragma: no-cache");
		header("Expires: 0");
	
		echo "<meta charset='utf-8'>
				<table width='100%' border='0' align='center' cellpadding='0' cellspacing='0' id='demoTable'>			
					<tr>
						<td colspan='4' valign='top'>
							<img src='https://lax.megatravel.com.mx/expo/img/logo_mt_.png' width='200' height='63'>
							<img src='https://lax.megatravel.com.mx/expo/img/reportes.png' width='60' height='80'>
						</td>
					</tr>
					
					<tr>	
						<td colspan='15' align='center' style='font-size:18px; font-weight:bolder;'>
							Reporte de Recibos Provisionales de Efectivo
						</td>	
					</tr>
					<tr>
						<td colspan='15' valign='top' align='center'>".$rango."</td>			
					</tr>
					<tr>
						<td colspan='15'>&nbsp;</td>		
					</tr>
		
					<tr>$tipoReporte</tr>
		
					<tr bgcolor='#00264d' style='color:#FFF;'>
						<th colspan='3' rowspan='2' style='text-align:center;'>EXPEDIENTES</th>
						<th colspan='6' style='text-align:center;'>INGRESOS-EFECTIVO</th>
						<th colspan='2' rowspan='2' style='text-align:center;'>No. PASAJEROS</th>
					</tr>
					
					<tr bgcolor='#00264d' style='color:#FFF;'>
						<th colspan='3' style='text-align:center;'>MXN</th>
						<th colspan='3' style='text-align:center;'>USD</th>
					</tr>";

						$totalEfecMXN		= 0;
						$totalEfecUSD		= 0;
						$totalPax			= 0;
		
						while($rowE = mysqli_fetch_assoc($resExcel)) { 
							$cid_expediente	= $rowE['cid_expediente'];
							$montomxn		= 0;
							$montousd		= 0;
						
							$consExpE	= "SELECT * FROM expediente WHERE cid_expediente='".$cid_expediente."' ";		
							$resExpE 	= mysqli_query($conx, $consExpE);
							$row2e 		= mysqli_fetch_assoc($resExpE);	
							$moneda		= $row2e['moneda'];
							$importe	= $row2e['importe'];	
								
							if ($moneda=='MXN'){
								$montomxn	= $importe;
							}
							elseif($moneda=='USD'){
								$montousd	= $importe;
							}
							
							if($i==1){
								$bg = "";
								$i=2;
							}
							else{
								
								$bg = "bgcolor='#cce5ff'";
								$i=1;
							}
						
							$montoEfecM			= $rowE['montoEfecM'];	
							$montoEfecU			= $rowE['montoEfecU'];	
							$npax				= $row2e['pax'];	
							
					echo "<tr $bg>
							<td colspan='3' align='center'>".$cid_expediente."</td>				
							<td colspan='3' align='center'>".number_format($montoEfecM,2)."</td>										
							<td colspan='3' align='center'>".number_format($montoEfecU,2)."</td>	
							<td colspan='2' align='center'>".$npax."</td>													
						</tr>";
							
							$totalexp++;
							$totalEfecMXN	= $totalEfecMXN + $montoEfecM;
							$totalEfecUSD	= $totalEfecUSD + $montoEfecU;
							$totalPax		= $totalPax + $npax;
						}
					echo "
						<tr bgcolor='#00264d' style='color:#FFF;'>
							<th colspan='3' style='text-align:center;'>Expedientes</th>
							<th colspan='3' style='text-align:center;'>MXN</th>
							<th colspan='3' style='text-align:center;'>USD</th>
							<th colspan='2' style='text-align:center;'>Total Pax</th>
						</tr>
						<tr>
							<td colspan='3' align='center'>".$totalexp."</td>
							<td colspan='3' align='center'> $ ".number_format($totalEfecMXN)."</td>
							<td colspan='3' align='center'> $ ".number_format($totalEfecUSD)."</td>
							<td colspan='2' align='center'>".$totalPax."</td>
						</tr>
						<tr>
							<td colspan='15' valign='top' align='right'>Elaboró: ".$usuario."</td>
						</tr>
						<tr>
							<td colspan='15' valign='top' align='right'> ".$hoy."</td>
						</tr>
					</tbody> 
			</table>";
		
	}

?>

<script>

$(document).ready(function(){

    $('[data-toggle="tooltip"]').tooltip(); 

});

</script>