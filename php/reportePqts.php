<?php

	include('conexion.php');
	include($_SERVER['DOCUMENT_ROOT'].'/php/session2.php');
	include($_SERVER['DOCUMENT_ROOT'].'/objeto/templeado.php');
	date_default_timezone_set('America/Mexico_city');

	if($_GET['tipo']=='N'){	
		$fecha1			= $_GET['f1'];
		$fecha2			= $_GET['f2'];	

		if($_GET['ejec']!=''){
			$extra	= " AND cid_emplea=".$_GET['ejec'];
		}else {
			$extra 	= '';	
		}
		
		$consulta	= "SELECT folexpo,cid_expedi,ciniciales,fecha,numpax,cnombre,capellidop,capellidom,destino,fsalida,totpaquete, 
						moneda FROM expo_mov WHERE fecha BETWEEN '".$fecha1."' AND '".$fecha2."' AND status='P'".$extra." 
						ORDER BY cid_expedi";
		//echo $consulta;
		$result 	= mysqli_query($conx, $consulta);
		if ($result){	
			$html = "<table class='table'>
					<thead>
						<tr>
							<th width='5%' style='text-align:center;'>FECHA</th>
							<th width='4%' style='text-align:center;'>FOLIO</th>
							<th width='3%' style='text-align:center;'>EXPEDIENTE</th>
							<th width='4%' style='text-align:center;'>VTAS.</th>
							<th width='4%' style='text-align:center;'>PAX</th>
							<th width='20%' style='text-align:center;'>CLIENTE</th>
							<th width='22%' style='text-align:center;'>DESTINO</th>
							<th width='7%' style='text-align:center;'>SALIDA</th>
							<th width='7%' style='text-align:center;'>PAQUETE</th>
							<th width='5%' style='text-align:center;'>MONEDA</th>
							<th width='7%' style='text-align:center;'>METODO DE PAGO</th>
							<th width='7%' style='text-align:center;'>IMPORTE</th>
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
								<col width='4%'>
								<col width='4%'>
								<col width='20%'>
								<col width='20%'>
								<col width='7%'>
								<col width='7%'>
								<col width='5%'>
								<col width='7%'>
								<col width='7%'>
								<col width='5%'>";
								
								$totalpax			= 0;
								$totalPqtsUSD		= 0;
								$totalPqtsMXN		= 0;
								$totalVtasUSD		= 0;
								$totalVtasMXN		= 0;
								$totalvtas 			= mysqli_num_rows($result);	
								//$rowinicial			= mysqli_fetch_assoc($result);
								//$expact				= $rowinicial['cid_expedi'];
										
								while($row = mysqli_fetch_assoc($result)) {
									$fecha 			= $row['fecha']; 
									$folio 			= $row['folexpo'];
									$expediente		= $row['cid_expedi'];
									$ejecutivopqt	= $row['ciniciales'];
									$npax			= $row['numpax'];
									$cliente 		= trim($row['cnombre']).' '.trim($row['capellidop']).' '.trim($row['capellidom']);	
									$destino 		= $row['destino'];
									$salida 		= $row['fsalida'];
									$totpaqt		= $row['totpaquete'];
									$monedapqt		= $row['moneda'];

									//$importe		= $row['importe'];
									//$monedapago		= $row['monedap'];
									
									$html.= "<tr class='info'>
										<td align='center'>".ddmmmaaaa(trim(substr($fecha,0,10)))."</td>
										<td align='center'>".$folio."</td>
										<td align='center'>".$expediente."</td>
										<td align='center'>".$ejecutivopqt."</td>
										<td align='center'>".$npax."</td>
										<td align='left'>".$cliente."</td>
										<td align='left'>".$destino."</td>
										<td align='center'>".ddmmmaaaa(trim(substr($salida,0,10)))."</td>
										<td align='center'>".number_format($totpaqt,2)."</td>
										<td align='center'>".$monedapqt."</td>
										<td>&nbsp;</td>
										<td>&nbsp;</td>
										<td>&nbsp;</td>";						
									//echo $monedapqt;
									$totalPax		= $totalPax + $npax;
									if ($row['moneda'] == 'USD'){
										//echo 'x';
										$totalPqtsUSD	= $totalPqtsUSD + $totpaqt;
										$totalVtasUSD	= $totalVtasUSD;
									}else {
										$totalPqtsMXN	= $totalPqtsMXN + $totpaqt;
										$totalVtasMXN	= $totalVtasMXN;
									}
									
									$consultaPagos = "SELECT concepto,monto,moneda FROM recibodig WHERE cid_expediente = '".$expediente."' AND cancelado = '0'" ;
									$result2 	= mysqli_query($conx, $consultaPagos);
									while($row2 = mysqli_fetch_assoc($result2)) {
										
										$concepto		= $row2['concepto'];
										$monto			= $row2['monto'];
										$monedapago		= $row2['moneda'];
									
										$html.= "<tr>
											<td colspan='10'>&nbsp;</td>
											<td align='center'>".$concepto."</td>
											<td align='center'>".number_format($monto,2)."</td>
											<td align='center'>".$monedapago."</td>
										</tr>";
										
										if ($row2['moneda'] == 'USD'){
											//echo 'x';
											$totalVtasUSD	= $totalVtasUSD+$monto;
										}else {
											$totalVtasMXN	= $totalVtasMXN+$monto;
										}
									}
									$html.="<tr class='Success'><td colspan='13'></td></tr>";
								}
				$html.="</tbody> </table></div>";
			
			if(mysqli_num_rows($result)>0){
				
				$html.= "<table class='table'>
						<thead>
							<tr>
								<th width='12%' style='text-align:center;'>Total de Ventas</th>
								<th width='13%' style='text-align:center;'>Total Pasajeros</th>
								<th width='13%' style='text-align:center;'>Total USD Ventas</th>
								<th width='13%' style='text-align:center;'>Total MXN Ventas</th>
								<th width='13%' style='text-align:center;'>Total USD Ingresos</th>
								<th width='13%' style='text-align:center;'>Total MXN Ingresos</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td width='12%' align='center'>".$totalvtas."</td>
								<td width='12%' align='center'>".$totalPax."</td>
								<td width='13%' align='center'> $ ".number_format($totalPqtsUSD)."</td>
								<td width='13%' align='center'> $ ".number_format($totalPqtsMXN)."</td>
								<td width='13%' align='center'> $ ".number_format($totalVtasUSD)."</td>
								<td width='13%' align='center'> $ ".number_format($totalVtasMXN)."</td>
							</tr>
						</tbody>
					</table>
					<div class='col-md-2'>
						<div class='row'>
							<div class='panel panel-primary' style='text-align:center;' >
								<div class='panel-heading'>EXPORTAR</div>
									<table class='table'>
										<tr>
											<td style='text-align:center;cursor:pointer;'  data-toggle='tooltip' data-placement='bottom' title='REPORTE EXCEL' onClick=exportaPqts(\"E\")><img width='32px' src='https://".$_SERVER['SERVER_NAME']."/img/excel.gif'></td>
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
			$extra 			= " AND cid_emplea='".$ejecutivo."'";
			$tipoReporte 	= "<td colspan='15' align='center'>Ejecutivo: <strong> "  .InicialesEmp($ejecutivo)."</strong> ".imprimeEmp($id)."</td>";
		}
		else{
			$tipoReporte	= "<td colspan='15' align='center'><strong>REPORTE GENERAL</strong></td>";
		}
	
		$cb 		= "";
		$consultaE  = "SELECT folexpo,cid_expedi,ciniciales,fecha,numpax,cnombre,capellidop,capellidom,destino,fsalida,totpaquete, 
						moneda FROM expo_mov WHERE fecha BETWEEN '".$fecha1."' AND '".$fecha2."' AND status='P'".$extra." 
						ORDER BY cid_expedi";
		$resExcel 	= mysqli_query($conx, $consultaE);
	
		header('Content-Type: text/html; charset=utf-8');
		header('Content-type: application/vnd.ms-excel;charset=utf-8');
		header("Content-Disposition: attachment; filename=reporte ".$_GET['f1']."-".$_GET['f2'].".xls");
		header("Pragma: no-cache");
		header("Expires: 0");
	
		echo "<meta charset='utf-8'>";
				$html = "<table width='100%' border='0' align='center' cellpadding='0' cellspacing='0' id='demoTable'>	
						<tr>
							<td colspan='4' valign='top'>
								<img src='https://lax.megatravel.com.mx/expo/img/logo_mt_.png' width='200' height='63'>
								<img src='https://lax.megatravel.com.mx/expo/img/reportes.png' width='60' height='80'>
							</td>
						</tr>
						
						<tr>	
							<td colspan='15' align='center' style='font-size:18px; font-weight:bolder;'>
								Reporte de Ventas
							</td>	
						</tr>
						<tr>
							<td colspan='15' valign='top' align='center'>".$rango."</td>			
						</tr>
						<tr>
							<td colspan='15'>&nbsp;</td>		
						</tr>
						<tr style='font-size:14px;>
							<td colspan='15'>$tipoReporte</td>
						</tr>
						<tr>
							<td colspan='15'>&nbsp;</td>		
						</tr>
			
						<tr bgcolor='#00264d' style='color:#FFF;'>
							<th width='5%' style='text-align:center;'>FECHA</th>
							<th width='4%' style='text-align:center;'>FOLIO</th>
							<th width='3%' style='text-align:center;'>EXPEDIENTE</th>
							<th width='4%' style='text-align:center;'>VTAS.</th>
							<th width='4%' style='text-align:center;'>PAX</th>
							<th width='20%' style='text-align:center;'>CLIENTE</th>
							<th width='22%' style='text-align:center;'>DESTINO</th>
							<th width='7%' style='text-align:center;'>SALIDA</th>
							<th width='7%' style='text-align:center;'>PAQUETE</th>
							<th width='5%' style='text-align:center;'>MONEDA</th>
							<th width='7%' style='text-align:center;'>METODO DE PAGO</th>
							<th width='7%' style='text-align:center;'>IMPORTE</th>
							<th width='5%' style='text-align:center;'>MONEDA</th>
						</tr>
				</table>";
				
			$html.= "<table>
						<col width='5%'>
						<col width='5%'>
						<col width='5%'>
						<col width='4%'>
						<col width='4%'>
						<col width='20%'>
						<col width='20%'>
						<col width='7%'>
						<col width='7%'>
						<col width='5%'>
						<col width='7%'>
						<col width='7%'>
						<col width='5%'>";
						
						$totalpax			= 0;
						$totalPqtsUSD		= 0;
						$totalPqtsMXN		= 0;
						$totalVtasUSD		= 0;
						$totalVtasMXN		= 0;
						$totalvtas 			= mysqli_num_rows($resExcel);	
						//$rowinicial			= mysqli_fetch_assoc($result);
						//$expact				= $rowinicial['cid_expedi'];
								
						while($row = mysqli_fetch_assoc($resExcel)) {
							$fecha 			= $row['fecha']; 
							$folio 			= $row['folexpo'];
							$expediente		= $row['cid_expedi'];
							$ejecutivopqt	= $row['ciniciales'];
							$npax			= $row['numpax'];
							$cliente 		= trim($row['cnombre']).' '.trim($row['capellidop']).' '.trim($row['capellidom']);	
							$destino 		= $row['destino'];
							$salida 		= $row['fsalida'];
							$totpaqt		= $row['totpaquete'];
							$monedapqt		= $row['moneda'];

							//$importe		= $row['importe'];
							//$monedapago		= $row['monedap'];
							
							$html.= "<tr class='info'>
								<td align='center'>".ddmmmaaaa(trim(substr($fecha,0,10)))."</td>
								<td align='center'>".$folio."</td>
								<td align='center'>".$expediente."</td>
								<td align='center'>".$ejecutivopqt."</td>
								<td align='center'>".$npax."</td>
								<td align='left'>".$cliente."</td>
								<td align='left'>".$destino."</td>
								<td align='center'>".ddmmmaaaa(trim(substr($salida,0,10)))."</td>
								<td align='center'>".number_format($totpaqt,2)."</td>
								<td align='center'>".$monedapqt."</td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>";						
							//echo $monedapqt;
							$totalPax		= $totalPax + $npax;
							if ($row['moneda'] == 'USD'){
								//echo 'x';
								$totalPqtsUSD	= $totalPqtsUSD + $totpaqt;
								$totalVtasUSD	= $totalVtasUSD;
							}else {
								$totalPqtsMXN	= $totalPqtsMXN + $totpaqt;
								$totalVtasMXN	= $totalVtasMXN;
							}
							
							$consultaPagos = "SELECT concepto,monto,moneda FROM recibodig WHERE cid_expediente = '".$expediente."' AND cancelado = '0'" ;
							$result2 	= mysqli_query($conx, $consultaPagos);
							while($row2 = mysqli_fetch_assoc($result2)) {
								
								$concepto		= $row2['concepto'];
								$monto			= $row2['monto'];
								$monedapago		= $row2['moneda'];
							
								$html.= "<tr>
									<td colspan='10'>&nbsp;</td>
									<td align='center'>".$concepto."</td>
									<td align='center'>".number_format($monto,2)."</td>
									<td align='center'>".$monedapago."</td>
								</tr>";
								
								if ($row2['moneda'] == 'USD'){
									//echo 'x';
									$totalVtasUSD	= $totalVtasUSD+$monto;
								}else{
									$totalVtasMXN	= $totalVtasMXN+$monto;
								}
							}
							$html.="<tr bgcolor='#CCCCCC' style='color:#FFF;'><td colspan='13'></td></tr>";
						}
						$html.="</table>";
	
						if(mysqli_num_rows($resExcel)>0){
							
							$html.= "<table width='100%' border='0' align='center' cellpadding='0' cellspacing='0' id='demoTable'>	
									<tr bgcolor='#00264d' style='color:#FFF;'>
										<th width='12%' style='text-align:center;'>Total de Ventas</th>
										<th width='13%' style='text-align:center;'>Total Pasajeros</th>
										<th width='13%' style='text-align:center;'>Total USD Ventas</th>
										<th width='13%' style='text-align:center;'>Total MXN Ventas</th>
										<th width='13%' style='text-align:center;'>Total USD Ingresos</th>
										<th width='13%' style='text-align:center;'>Total MXN Ingresos</th>
									</tr>
									<tr>
										<td width='12%' align='center'>".$totalvtas."</td>
										<td width='12%' align='center'>".$totalPax."</td>
										<td width='13%' align='center'> $ ".number_format($totalPqtsUSD)."</td>
										<td width='13%' align='center'> $ ".number_format($totalPqtsMXN)."</td>
										<td width='13%' align='center'> $ ".number_format($totalVtasUSD)."</td>
										<td width='13%' align='center'> $ ".number_format($totalVtasMXN)."</td>
									</tr>
									<tr>
										<td colspan='13' valign='top' align='right'>Elaboró: ".$usuario."</td>
									</tr>
									<tr>
										<td colspan='13' valign='top' align='right'> ".$hoy."</td>
									</tr>
								</table>";
						}else{
							$html= "<span class='item-canceled'>NO SE ENCONTRARON RESULTADOS</span>";
						}
						echo $html;
	}
?>

<script>

$(document).ready(function(){

    $('[data-toggle="tooltip"]').tooltip(); 

});

</script>