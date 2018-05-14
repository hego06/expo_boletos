<?php

	include('php/conexion.php');


	if('N'=='N'){

		$fecha1 	= '2017-05-01';

		$fecha2 	= '2018-06-01';

		$consulta 	= "SELECT * FROM expo_mov WHERE fecha BETWEEN '$fecha1' AND '$fecha2'";

		$res 		= mysqli_query($conx, $consulta);

		//echo $consulta;	

		if (mysqli_num_rows($res)>0){

			$html = "
				<div style='height:450px;'>
					<table class='table table-striped table-hover' id='example'>

						<thead>

							<tr>

								<th width='1%' style='text-align:center;'>FOLIO</th>

								<th width='8%' style='text-align:center;'>EXPEDIENTE</th>

								<th width='18%' style='text-align:center;'>EJECUTIVO</th>

								<th width='7%' style='text-align:center;'>F.REGISTRO</th>

								<th width='6%' style='text-align:center;'>MONEDA<br>PAGO</th>

								<th width='5%' style='text-align:center;'>ESTATUS</th>

								<th width='20%' style='text-align:center;'>CLIENTE</th>

								<th width='20%' style='text-align:center;'>DESTINO</th>

								<th width='4%' style='text-align:center;'>EDITAR</th>

								<th width='4%' style='text-align:center;'>BOLETO</th>

								<th width='4%' style='text-align:center;'>VER</th>

								<th width='4%' style='text-align:center;'>DOCTOS.</th>

							</tr>

						</thead>

							<tbody>";

			$totalmxn	= 0;

			$totalpax	= 0;

			$totalusd	= 0;

			while($row = mysqli_fetch_assoc($res)) {

				$folio 		= trim($row['folexpo']);

				$expediente = trim($row['cid_expedi']);

				$ejecutivo 	= trim($row['nvendedor']);

				$fregistro 	= trim($row['fecha']);

				$monedap 	= trim($row['monedap']);

				$estatus 	= trim($row['status']);

				$cliente 	= trim($row['cnombre']).' '.trim($row['capellidop']).' '.trim($row['capellidom']);

				$destino 	= trim($row['destino']);

				$moneda		= $row['moneda'];

				$numpax		= $row['numpax'];

				$totpaquete	= $row['totpaquete'];

				$lamm 		= $row['lamm'];

				$totalvtas	= mysqli_num_rows($res);

				if($expediente!='' || $estatus=='L'){

					if ($moneda == 'USD' && $estatus!='C'){

						$totalusd = $totalusd + $totpaquete;

					}

					elseif ($moneda == 'MXN' && $estatus!='C'){

						$totalmxn = $totalmxn + $totpaquete;

					}

					if ($estatus!='C'){

						$totalpax = $totalpax + $numpax;

					}
				}

				$consEB="SELECT * FROM sboletos WHERE cid_expedi='$expediente' and cancelado IS NULL";
				$resul=mysqli_query($conx, $consEB);
				$bol= mysqli_fetch_assoc($resul);
				$estado=trim($bol['cancelado']);
				$statusaut=trim($bol['statusaut']);

				$ligaF	= "folio=".$folio;
				$ligaB = "folio=".$expediente;
				$ligaV	= "folio=".$folio."&v=1";

				if( ($estatus == 'X' || $estatus == 'E') && $lamm != '1'){

					$editar 	= "<td style='text-align:center;cursor:pointer;font-size: 22px; font-weight: bolder;'>

									<a href='https://".$_SERVER['SERVER_NAME']."/expo2017/index.php?".$ligaF."'><i data-toggle='tooltip' data-placement='bottom' title='EDITAR' class='fa fa-pencil-square-o' aria-hidden='true'></i>editar</a>

									</td>";

					$boleto 	= "<td>&nbsp;</td>";

				}else{

					$editar 	= "<td>&nbsp;</td>";
					
						if($statusaut=='1'){
							$eb="&nbsp;";
						}else{
							$eb="<a href='"."/expo_boletos/editar_boletos.php?".$ligaB."'><i data-toggle='tooltip' data-placement='bottom' title='EDITAR BOLETO' class='fa fa-plane' aria-hidden='true'></i>EB</a>";
						}
					$boleto 	= "<td style='text-align:center;cursor:pointer;font-size: 22px; font-weight: bolder;'>

									<a href='"."/expo_boletos/boletos.php?".$ligaB."'><i data-toggle='tooltip' data-placement='bottom' title='BOLETO' class='fa fa-plane' aria-hidden='true'></i>boleto</a>&nbsp;&nbsp;".$eb."

									</td>";

					

				}

				$ver 	= "<td style='text-align:center;cursor:pointer;font-size: 22px; font-weight: bolder;'>

									<a href='https://".$_SERVER['SERVER_NAME']."/expo2017/index.php?".$ligaV."'><i data-toggle='tooltip' data-placement='bottom' title='VER' class='glyphicon glyphicon-eye-open' aria-hidden='true'></i>ver</a>

									</td>";	


				switch($estatus){

					case 'C':

						$clase 		= "class=''";

						$estatus 	= 'CANCELADO';

					break;

					case 'L':

						$clase 		= "class='danger'";

						$estatus 	= 'LIGA BANCARIA';

					break;

					case 'P':

						$clase 		= "class='success'";

						$estatus 	= 'PROCESADA';

					break;

					case 'X':

						$clase 		= "class='info'";

						$estatus 	= 'COTIZACIÓN';

					break;

					default:

						$clase 		= "class='warning'";

						$estatus 	= 'PENDIENTE';	

					break;

				}



				

				

$html .="		<tr $clase>

					<td align='center'>$folio</td>

					<td align='center'>$expediente</td>

					<td>$ejecutivo</td>				

					<td>$fregistro</td>

					<td align='center'>$monedap</td>

					<td align='center'>$estatus</td>

					<td>$cliente</td>

					<td>$destino</td>

					$editar

					$boleto

					$ver

					<td style='text-align:center;cursor:pointer;font-size: 22px; font-weight: bolder;'>

						<a href='#' onClick='abrirVentana(\"archivovisor.php?$ligaF\",\"ARCHIVOS\")'>

							<i data-toggle='tooltip' data-placement='bottom' title='DOCUMENTOS'  class='fa fa-folder-open' aria-hidden='true'></i>

						</a>	

					</td>

			</tr>";

			}

$html .= "</tbody>

		</table>
	</div>	

	<div class='col-md-4'>

		<div class='row'>

			<div class='panel panel-primary' style='text-align:center;' >

				<div class='panel-heading'>RESUMEN DE DATOS</div>

				<table class='table'>

					<tr>

						<th style='text-align:center;' >PASAJEROS</th>

						<th style='text-align:center;' >REGISTROS</th>

						<th style='text-align:center;'  colspan='2'>TOTAL VENTAS</th>

					</tr>

					<tr>

						<td style='text-align:center;' >$totalpax</td>

						<td style='text-align:center;' >$totalvtas</td>

						<th>USD</th>

						<td style='text-align:center;' >".number_format($totalusd,2)."</td>

					</tr>

					<tr>

						<td colspan='2'>&nbsp;</td>

						<th>MXN</th>

						<td style='text-align:center;' >".number_format($totalmxn,2)."</td>

					</tr>

				</table>

			</div>	

		</div>

	</div>

	<div class='col-md-2'>

		<div class='row'>

			<div class='panel panel-primary' style='text-align:center;' >

				<div class='panel-heading'>EXPORTAR</div>

				 	<table class='table'>

				 		<tr>

				 			<td style='text-align:center;cursor:pointer;'  data-toggle='tooltip' data-placement='bottom' title='REPORTE EXCEL' onClick=exporta(\"E\")><img width='32px' src='https://".$_SERVER['SERVER_NAME']."/img/excel.gif'></td>

				 			<!--<td style='text-align:center;cursor:pointer;' data-toggle='tooltip' data-placement='bottom' title='REPORTE PDF' onClick=exporta(\"P\")><img width='32px' src='https://".$_SERVER['SERVER_NAME']."/img/pdf_.gif'></td>-->

				 		</tr>

				 	</table>

				</div>

			</div>

		</div>		

	</div>

	<div class='col-md-6'>	

		<div class='row'>

			<table class='table'>	

				<tr>


					<td class='info'>&nbsp;</td>

					<th>COTIZACIÓN</th>

					<td class='success'>&nbsp;</td>

					<th>PROCESADAS</th>

					<td class='warning'>&nbsp;</td>

					<th>PENDIENTES</th>

					<td class='danger'>&nbsp;</td>

					<th>LIGA BANCARIA</th>

				</tr>

			</table>

		</div>

	</div>";	

	}else{

		$html = "<span class='item-canceled'>NO SE ENCONTRARON RESULTADOS</span>";

	}

		echo $html;

	}

//REPORTE EXCEL

	elseif($_GET['tipo']=='E'){

		$fecha1 	= $_GET['f1'];

		$fecha2 	= $_GET['f2'];

		$ejecutivo 	= $_GET['ejec'];

		$extra 		= '';

		if(!empty($ejecutivo)){

			$extra 			= "AND cid_emplea = '$ejecutivo'";

			$tipoReporte 	= "<td colspan='20' align='center'>Ejecutivo: <strong> "  .InicialesEmp($ejecutivo)."</strong> ".imprimeEmp($cid)."</td>";

		}

		else{

			$tipoReporte	= "<td colspan='20' align='center'><strong>REPORTE GENERAL</strong></td>";

		}

		$hoy		= "";	

		$cb 		= "";

		$consultaE 	= "SELECT * FROM expo_mov WHERE fecha BETWEEN '$fecha1' AND '$fecha2' $extra";

		$resExcel 	= mysqli_query($conx, $consultaE);



		header('Content-Type: text/html; charset=utf-8');

		header('Content-type: application/vnd.ms-excel;charset=utf-8');

		header("Content-Disposition: attachment; filename=reporte ".$_GET['fecha1']."-".$_GET['fecha2'].".xls");

		header("Pragma: no-cache");

		header("Expires: 0");



echo "<meta charset='utf-8'>

		<table border='0' align='center' cellpadding='0' cellspacing='0' id='demoTable'>

			<tr>

				<td colspan='4' valign='top'>

					<img src='https://lax.megatravel.com.mx/expo/img/logo_mt_.png' width='200' height='63'>

					<img src='https://lax.megatravel.com.mx/expo/img/reportes.png' width='60' height='80'>

				</td>

			</tr>

			<tr>	

				<td colspan='20' align='center' style='font-size:18px; font-weight:bolder;'>

					Reporte de Ventas ".$rango."

				</td>

			</tr>

			<tr>$tipoReporte</tr>

			<tr>

				<td colspan='20' align='center'>".$hoy."</td>

			</tr>

			<tr>

				<th rowspan='2' $cb>FOLIO</th>

				<th rowspan='2' $cb>EXPEDIENTE</th>

				<th rowspan='2' $cb>FECHA</th>

				<th colspan='8' $cb>DATOS DEL CLIENTE</th>

				<th $cb colspan='8'>DATOS DEL PAQUETE</th>

			</tr>

			<tr>

				<th $cb>NOMBRE</th>

				<th $cb>APELLIDO P.</th>

				<th $cb>APELLIDO M.</th>

				<th $cb>LADA</th>

				<th $cb>TELÉFONO</th>

				<th $cb>EXT.</th>

				<th $cb>TIPO</th>

				<th $cb>E-MAIL</th>

				<th $cb>CLAVE MT</th>

				<th $cb>DESTINO</th>

				<th $cb>DEPTO.</th>

				<th $cb>ÁREA</th>				

				<th $cb>TOTAL</th>

				<th $cb>MONEDA</th>

				<th $cb>FECHA SALIDA</th>

				<th $cb>N° PASAJEROS</th>

			</tr>";

			$totalmxn	= 0;

			$totalpax	= 0;

			$totalusd	= 0;

			while($row = mysqli_fetch_assoc($resExcel)) {

				$folexpo	= $row['folexpo'];

				$cid_expedi	= $row['cid_expedi'];

				$fecha		= trim(strchr($row['fechahora']," ",true));

				$fecha		= fechamesc(substr($fecha, 0 , 10),'-');

				$fecha		= strtoupper($fecha);

				$hora		= trim(strchr($row['fechahora']," ",false));

				$impteapag	= $row['impteapag'];

				$monedap	= $row['monedap'];

				$status		= $row['status'];

				$cnombre	= $row['cnombre'];

				$capellidop	= $row['capellidop'];

				$capellidom	= $row['capellidom'];		

				$destino	= $row['destino'];

				$cid_destin	= $row['cid_destin'];

				$fsalida	= fechamesc(substr($row['fsalida'], 0 , 10),'-');

				$fsalida	= strtoupper($fsalida);

				$totpaquete	= $row['totpaquete'];

				$moneda		= $row['moneda'];

				$clada		= $row['clada'];

				$ctelefono	= $row['ctelefono'];

				$cmail		= $row['cmail'];	

				$numpax		= $row['numpax'];

				$cext		= $row['cext'];	

				$ctipotel	= $row['ctipotel'];  

				$depto		= $row['nid_depto'];

				$area		= $row['nid_area'];	 

				$totalvtas	= mysqli_num_rows($resExcel);

			

			

				if($cid_expedi!='' || $status=='L'){

					if ($moneda == 'USD' && $status!='C'){

						$totalusd = $totalusd + $totpaquete;

					}

					elseif ($moneda == 'MXN' && $status!='C'){

						$totalmxn = $totalmxn + $totpaquete;

					}

					if ($status!='C'){

						$totalpax = $totalpax + $numpax;

					}

				}

					

			  	if ($status=='C'){ //CANCELADOS

					$bg = " bgcolor='#FF9B9B'";

				}

			  	elseif ($status=='L'){ //LIGA BANCARIA

					$bg = " bgcolor='#f2dede'";

				}

			  	elseif ($status=='P'){ //PROCESADAS

					$bg = " bgcolor='#dff0d8'";

				}elseif ($status == 'X'){

					$bg = " bgcolor = '#d9edf7'";

				}

				else{ //PENDIENTES

					$bg = " bgcolor='#fcf8e3'";

				}			



				echo	"<tr>

						  <td align='center' style='font-weight:bolder;' $bg >".$folexpo."</td>

						  <td align='center' style='font-weight:bolder;'  $bg >".$cid_expedi."</td>

						  <td $bg >".$fecha."</td>

						  <td $bg >".$cnombre."</td>

						  <td $bg >".$capellidop."</td>

						  <td $bg >".$capellidom."</td>

						  <td $bg >".$clada."</td>

						  <td $bg >".$ctelefono."</td>

						  <td $bg >".$cext."</td>

						  <td $bg >".$ctipotel."</td>

						  <td $bg >".$cmail."</td>

						  <td $bg  align='left' >".$cid_destin."</td>

						  <td $bg >".$destino."</td>

						  <td $bg   align='center' >".$depto."</td>

						  <td $bg   align='center' >".$area."</td>

						  <td $bg >".$totpaquete."</td>

						  <td $bg  align='center' >".$moneda."</td>

						  <td $bg  align='center' >".$fsalida."</td>

						  <td $bg  align='center' >".$numpax."</td>

						</tr>";

			}

echo "<tr>

			<th style='text-align:center;' >PASAJEROS</th>

			<th style='text-align:center;' >REGISTROS</th>

			<th style='text-align:center;' colspan='2'>TOTAL VENTAS</th>

		</tr>

		<tr>

			<td style='text-align:center;' >$totalpax</td>

			<td style='text-align:center;' >$totalvtas</td>

			<th>USD</th>

			<td style='text-align:center;' >".number_format($totalusd,2)."</td>

		</tr>

		<tr>

			<td colspan='2'>&nbsp;</td>

			<th>MXN</th>

			<td style='text-align:center;' >".number_format($totalmxn,2)."</td>

		</tr>

	</table>";

	}

?>



<script>

$(document).ready(function(){

    $('[data-toggle="tooltip"]').tooltip(); 
	
    $('#example').DataTable();
	
});


</script>