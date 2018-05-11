<?php

	include('conexion.php');

	include($_SERVER['DOCUMENT_ROOT'].'/php/fecha.php');

	include($_SERVER['DOCUMENT_ROOT'].'/php/cifraget.php');

	include($_SERVER['DOCUMENT_ROOT'].'/objeto/templeado.php');

 $fechah 	= date('Y-m-d');
 $expe		= strtoupper($_GET['expe']);
 $solicitud	= strtoupper($_GET['solicitud']);
 $recibo	= strtoupper($_GET['recibo']);
 $fecha1	= $_GET['fecha1'];
 $fecha2	= $_GET['fecha2'];

	$sql		= "SELECT * FROM dtarjetab INNER JOIN recibodig ON dtarjetab.cid_solicitud = recibodig.cid_solici WHERE recibodig.cancelado = '0' AND dtarjetab.cid_expediente LIKE '$expe%' AND dtarjetab.cid_solicitud LIKE '$solicitud%' AND recibodig.folio LIKE '".$recibo."%' AND recibodig.fechahoy BETWEEN '$fecha1' AND '$fecha2' ORDER BY recibodig.folio ASC";
	
	$res 		= mysqli_query($conx, $sql);

		if (mysqli_num_rows($res)>0){

			$html = "

					<table class='table' >

						<thead>

							<tr>

								<th width='8%' style='text-align:center;'>RECIBO</th>

								<th width='8%' style='text-align:center;'>EXPEDIENTE</th>

								<th width='8%' style='text-align:center;'>SOLICITUD</th>

								<th width='7%' style='text-align:center;'>FECHA</th>

								<th width='6%' style='text-align:center;'>IMPORTE</th>

								<th width='6%' style='text-align:center;'>MONEDA</th>

								<th width='20%' style='text-align:center;'>CLIENTE</th>

								<th width='8%' style='text-align:center;'>DOCTO.</th>

							</tr>

						</thead>

					</table>

					<div class='row row-margin botton-20' style='overflow:auto;height:350px;'>

						<table class='table table-hover table-striped table-bordered'>

							<tbody>

								<col width='8%'>

							    <col width='8%'>

							    <col width='8%'>

							    <col width='5%'>

							    <col width='8%'>

							    <col width='5%'>

							    <col width='20%'>

							    <col width='8%'>";

			while($row = mysqli_fetch_assoc($res)) {

				$recibo			= $row['folio'];
				$cid_expedi		= $row['cid_expediente'];
				$cid_solicitud	= $row['cid_solicitud'];
				$fechahoy		= $row['fechahoy'];
				$fecha			= fechamesc(substr($fechahoy, 0 , 10),'-');
				$impte			= $row['monto'];
				$moneda			= $row['moneda'];
				$cliente		= $row['nombre'];
				$ligaF 			= encode_this("id=".$cid_solicitud."&reci=".$recibo);				

			

$html .="		<tr>

					<td align='center'>$recibo</td>

					<td align='center'>$cid_expedi</td>

					<td>$cid_solicitud</td>				

					<td>$fecha</td>

					<td align='center'>".number_format($impte,2)."</td>

					<td align='center'>$moneda</td>

					<td>$cliente</td>

					<td style='text-align:center;cursor:pointer;font-size: 22px; font-weight: bolder;'>

						<a href='#' onClick='abrirVentana(\"doctosop.php?$ligaF\",\"DOCUMENTO SOPORTE\")'>

							<i data-toggle='tooltip' data-placement='bottom' title='DOCUMENTO SOPORTE'  class='fa fa-folder-open' aria-hidden='true'></i>

						</a>	

					</td>

			</tr>";

			}

	$html .= "</tbody>
			</table>
		</div>
	</div>	";

	}else{

		$html = "<span class='item-canceled'>NO SE ENCONTRARON RESULTADOS</span>";

	}

		echo $html;
?>
<script>

$(document).ready(function(){

    $('[data-toggle="tooltip"]').tooltip(); 

});

</script>