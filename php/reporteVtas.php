<?php

	include('conexion.php');
	include($_SERVER['DOCUMENT_ROOT'].'/php/session2.php');
	//include($_SERVER['DOCUMENT_ROOT'].'/php/fecha.php');
	//include($_SERVER['DOCUMENT_ROOT'].'/php/cifraget.php');
	include($_SERVER['DOCUMENT_ROOT'].'/objeto/templeado.php');
	date_default_timezone_set('America/Mexico_city');
	
	if($_GET['tipo']=='N'){	
		$fecha1			= $_GET['f1'];
		$fecha2			= $_GET['f2'];	

		if($_GET['ejec']!=''){
			$inieje = InicialesEmp($_GET['ejec']);
			$extra	= " AND iniciales='".$inieje."'";
		}else {
			$extra 	= '';	
		}
		$consulta	= "SELECT round(sum(if(concepto='TARJETA BANCARIA' && moneda='MXN',monto,0)),2) AS montoTarjM,
						round(sum(if(concepto='TARJETA BANCARIA' && moneda='USD',monto,0)),2) AS montoTarjU,
						round(sum(if(concepto='EFECTIVO' && moneda='MXN',monto,0)),2) AS montoEfecM,
						round(sum(if(concepto='EFECTIVO' && moneda='USD',monto,0)),2) AS montoEfecU,
						cid_expediente,folio,pasajero FROM recibodig WHERE dfecha BETWEEN '".$fecha1."' AND '".$fecha2."' 
						AND cancelado='0' ".$extra." 
						GROUP BY cid_expediente ORDER BY cid_expediente";

		$result 	= mysqli_query($conx, $consulta);
		if ($result){	
			$html = "<table class='table table-striped' id='example'>
					<thead>
						<tr>
							<th colspan='3' style='text-align:center;'>EXPEDIENTES	</th>
							<th colspan='2' style='text-align:center;'>INGRESOS-TARJETA B.</th>
							<th colspan='2' style='text-align:center;'>INGRESOS-EFECTIVO</th>
							<th>&nbsp;</th>
						</tr>
						<tr>
							<th width='12%' style='text-align:center;'>N° Expediente</th>
							<th width='13%' style='text-align:center;'>MXN</th>
							<th width='13%' style='text-align:center;'>USD</th>
							<th width='13%' style='text-align:center;'>MXN</th>
							<th width='13%' style='text-align:center;'>USD</th>
							<th width='13%' style='text-align:center;'>MXN</th>
							<th width='13%' style='text-align:center;'>USD</th>
							<th width='10%' style='text-align:center;'>N° Pax</th>
						</tr>
					</thead>";
				
			$html.= "<tbody>";
						
						$totalexp			= 0;
						$totalExpMXN		= 0;
						$totalExpUSD		= 0;
						$totalTarjMXN		= 0;
						$totalTarjUSD		= 0;
						$totalEfecMXN		= 0;
						$totalEfecUSD		= 0;
						$totalPax			= 0;

						while($row = mysqli_fetch_assoc($result)) { 
							$cid_expediente	= $row['cid_expediente'];
							$montomxn		= 0;
							$montousd		= 0;
						
							$consExp	= "SELECT * FROM expediente WHERE cid_expediente='".$cid_expediente."' ";		
							$resExp 	= mysqli_query($conx, $consExp);
							$row2 		= mysqli_fetch_assoc($resExp);	
							$moneda		= $row2['moneda'];
							$importe	= $row2['importe'];	
								
							if ($moneda=='MXN'){
								$montomxn	= $importe;
							}
							elseif($moneda=='USD'){
								$montousd	= $importe;
							}
						
							$montoTarjM			= $row['montoTarjM'];
							$montoEfecM			= $row['montoEfecM'];	
							$montoTarjU			= $row['montoTarjU'];
							$montoEfecU			= $row['montoEfecU'];	
							$npax				= $row2['pax'];	
							
							$html.= "<tr height='25'>
								<td width='13%' align='center'>".$cid_expediente."</td>
								<td width='11%' align='right'>".number_format($montomxn,2)."</td>
								<td width='11%' align='right'>".number_format($montousd,2)."</td>
								<td width='11%' align='right'>".number_format($montoTarjM,2)."</td>
								<td width='11%' align='right'>".number_format($montoTarjU,2)."</td>					
								<td width='11%' align='right'>".number_format($montoEfecM,2)."</td>										
								<td width='11%' align='right'>".number_format($montoEfecU,2)."</td>	
								<td width='11%' align='center'>".$npax."</td>													
							</tr>";
							
							$totalexp++;
							$totalExpMXN	= $totalExpMXN + $montomxn;
							$totalExpUSD	= $totalExpUSD + $montousd;
							$totalTarjMXN	= $totalTarjMXN + $montoTarjM;
							$totalTarjUSD	= $totalTarjUSD + $montoTarjU;
							$totalEfecMXN	= $totalEfecMXN + $montoEfecM;
							$totalEfecUSD	= $totalEfecUSD + $montoEfecU;
							$totalPax		= $totalPax + $npax;
						}
				$html.="</tbody> </div>";
			
			if(mysqli_num_rows($result)>0){
				
				$html.= "<table class='table'>
						<thead>
							<tr>
								<th width='12%' style='text-align:center;'>Expedientes</th>
								<th width='13%' style='text-align:center;'>MXN</th>
								<th width='13%' style='text-align:center;'>USD</th>
								<th width='13%' style='text-align:center;'>MXN</th>
								<th width='13%' style='text-align:center;'>USD</th>
								<th width='13%' style='text-align:center;'>MXN</th>
								<th width='13%' style='text-align:center;'>USD</th>
								<th width='10%' style='text-align:center;'>Total Pax</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td width='12%' align='center'>".$totalexp."</td>
								<td width='13%' align='right'> $ ".number_format($totalExpMXN)."</td>
								<td width='13%' align='right'> $ ".number_format($totalExpUSD)."</td>
								<td width='13%' align='right'> $ ".number_format($totalTarjMXN)."</td>
								<td width='13%' align='right'> $ ".number_format($totalTarjUSD)."</td>
								<td width='13%' align='right'> $ ".number_format($totalEfecMXN)."</td>
								<td width='13%' align='right'> $ ".number_format($totalEfecUSD)."</td>
								<td width='13%' align='center'>".$totalPax."</td>
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
			$inieje = InicialesEmp($_GET['ejec']);
			$extra	= " AND iniciales='".$inieje."'";
			$tipoReporte 	= "<td colspan='15' align='center'>Ejecutivo: <strong> "  .InicialesEmp($ejecutivo)."</strong> ".imprimeEmp($id)."</td>";
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
						<td colspan='6' valign='top'>
							<img src='https://lax.megatravel.com.mx/expo/img/logo_mt_.png' width='200' height='63'>
							<img src='https://lax.megatravel.com.mx/expo/img/reportes.png' width='60' height='80'>
						</td>
					</tr>
					
					<tr>	
						<td colspan='15' align='center' style='font-size:18px; font-weight:bolder;'>
							Reporte de Recibos Provisionales
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
						<th colspan='5' style='text-align:center;'>EXPEDIENTES</th>
						<th colspan='4' style='text-align:center;'>INGRESOS-EFECTIVO</th>
						<th colspan='4' style='text-align:center;'>INGRESOS-TARJETA</th>
						<th rowspan='2' rowspan='2' style='text-align:center;'>No. PASAJEROS</th>
					</tr>
					
					<tr bgcolor='#00264d' style='color:#FFF;'>
						<th>&nbsp;</th>
						<th colspan='2' style='text-align:center;'>MXN</th>
						<th colspan='2' style='text-align:center;'>USD</th>
						<th colspan='2' style='text-align:center;'>MXN</th>
						<th colspan='2' style='text-align:center;'>USD</th>
						<th colspan='2' style='text-align:center;'>MXN</th>
						<th colspan='2' style='text-align:center;'>USD</th>
					</tr>";

						$totalEfecMXN		= 0;
						$totalEfecUSD		= 0;
						$totalTarjMXN		= 0;
						$totalTarjUSD		= 0;
						$totalExpMXN		= 0;
						$totalExpUSD		= 0;
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

							$totalExpMXN		= $totalExpMXN + $montomxn;
							$totalExpUSD		= $totalExpUSD + $montousd;
							$montoEfecM			= $rowE['montoEfecM'];	
							$montoEfecU			= $rowE['montoEfecU'];	
							$montoTarjU			= $rowE['montoTarjU'];
							$montoTarjM			= $rowE['montoTarjM'];
							$npax				= $row2e['pax'];	
							
					echo "<tr $bg>
							<td colspan='1' align='center'>".$cid_expediente."</td>		

							<td colspan='2' align='right'>".number_format($montomxn,2)."</td>
							<td colspan='2' align='right'>".number_format($montousd,2)."</td>

							<td colspan='2' align='right'>".number_format($montoEfecM,2)."</td>									
							<td colspan='2' align='right'>".number_format($montoEfecU,2)."</td>

							<td colspan='2' align='right'>".number_format($montoTarjM,2)."</td>									
							<td colspan='2' align='right'>".number_format($montoTarjU,2)."</td>
							<td colspan='1' align='center'>".$npax."</td>													
						</tr>";
							
							$totalexp++;
							$totalEfecMXN	= $totalEfecMXN + $montoEfecM;
							$totalEfecUSD	= $totalEfecUSD + $montoEfecU;

							$totalTarjMXN	= $totalTarjMXN + $montoTarjM;
							$totalTarjUSD	= $totalTarjUSD + $montoTarjU;
							$totalPax		= $totalPax + $npax;
						}
					echo "
						<tr bgcolor='#00264d' style='color:#FFF;'>
							<th colspan='1' rowspan='2' style='text-align:center;'>Total Ventas</th>
							<th colspan='4' style='text-align:center;'>Expedientes</th>
							<th colspan='4' style='text-align:center;'>INGRESOS-EFECTIVO</th>
							<th colspan='4' style='text-align:center;'>INGRESOS-TARJETA</th>
							<th colspan='1' rowspan='2' style='text-align:center;'>Total Pax</th>
						</tr>
						<tr bgcolor='#00264d' style='color:#FFF;'>
							<th colspan='2' style='text-align:center;'>MXN</th>
							<th colspan='2' style='text-align:center;'>USD</th>
							<th colspan='2' style='text-align:center;'>MXN</th>
							<th colspan='2' style='text-align:center;'>USD</th>
							<th colspan='2' style='text-align:center;'>MXN</th>
							<th colspan='2' style='text-align:center;'>USD</th>

						</tr>
						<tr>
							<td colspan='1' align='center'>".$totalexp."</td>
							
							<td colspan='2' align='right'> $ ".number_format($totalExpMXN)."</td>
							<td colspan='2'  align='right'> $ ".number_format($totalExpUSD)."</td>

							<td colspan='2' align='center'> $ ".number_format($totalEfecMXN)."</td>
							<td colspan='2' align='center'> $ ".number_format($totalEfecUSD)."</td>

							<td colspan='2' align='center'> $ ".number_format($totalTarjMXN)."</td>
							<td colspan='2' align='center'> $ ".number_format($totalTarjUSD)."</td> 

							<td colspan='1' align='center'>".$totalPax."</td>
						</tr>
						<tr>
							<td colspan='14' valign='top' align='right'>Elaboró: ".$usuario."</td>
						</tr>
						<tr>
							<td colspan='14' valign='top' align='right'> ".$hoy."</td>
						</tr>
					</tbody> 
			</table>";
		
	}

?>

<script>

$(document).ready(function(){

    $('[data-toggle="tooltip"]').tooltip(); 
	$('#example').DataTable();
	
});

</script>