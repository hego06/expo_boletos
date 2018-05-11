<?php
	include('conexion.php');
	include($_SERVER['DOCUMENT_ROOT'].'/php/fecha.php');
	include($_SERVER['DOCUMENT_ROOT'].'/php/cifraget.php');
	include($_SERVER['DOCUMENT_ROOT'].'/objeto/templeado.php');	

	$fecha1 	= $_GET['f1'];
	$fecha2 	= $_GET['f2'];
	$folio 		= $_GET['folio'];
	$expediente = $_GET['expe'];
	$cliente 	= $_GET['cliente'];
	$tipo 		= $_GET['tipo'];
	$fhoy 		= date('Y-m-d');

	switch($tipo){
		case 'todos':
			$extra 	= "WHERE";
		break;
		case 'pendiente':
			$extra  = "WHERE status = 'E'";
		break;
		case 'hoy':
			$extra 	= "WHERE status = 'P' AND tproceso = '$fhoy'";
		break;
		case 'liga':
			$extra 	= "WHERE status = 'L' AND  ";
		break;
		case 'coti':
			$extra 	= "WHERE status = 'X' AND  ";
		break;
	}
	
	if($tipo == ''){
		$consulta 	= "SELECT * FROM expo_mov WHERE fecha BETWEEN  '$fecha1' AND '$fecha2' AND folexpo LIKE '$folio%' AND cid_expedi LIKE '$expediente%' AND cnombre LIKE '$cliente%'";
	}else{
		$consulta 	= "SELECT * FROM expo_mov $extra fecha BETWEEN  '$fecha1' AND '$fecha2' ";
	}
	$res 		= mysqli_query($conx, $consulta);
	if(mysqli_num_rows($res)>0){
$html = "
					<table class='table table-striped table-hover' id='example'>
						<thead>
							<tr>
								<th width='5%' style='text-align:center;'>FOLIO</th>
								<th width='5%' style='text-align:center;'>EXPEDIENTE</th>
								<th width='12%' style='text-align:center;'>EJECUTIVO</th>
								<th width='5%' style='text-align:center;'>F.REGISTRO</th>
								<th width='5%' style='text-align:center;'>MONEDA<br>PAGO</th>
								<th width='6%' style='text-align:center;'>ESTATUS</th>
								<th width='12%' style='text-align:center;'>CLIENTE</th>
								<th width='12%' style='text-align:center;'>DESTINO</th>
								<th width='3%' style='text-align:center;'>PROCESAR</th>
							</tr>
						</thead>
						<tbody>";
		while($row = mysqli_fetch_assoc($res)){
			$folio 		= trim($row['folexpo']);
			$expediente = trim($row['cid_expedi']);
			$ejecutivo 	= trim($row['nvendedor']);
			$fregistro 	= ddmmmaaaa(trim($row['fecha']));
			$monedap 	= trim($row['monedap']);
			$estatus 	= trim($row['status']);
			$cliente 	= trim($row['cnombre']).' '.trim($row['capellidop']).' '.trim($row['capellidom']);
			$destino 	= trim($row['destino']);
			$moneda		= $row['moneda'];
			$numpax		= $row['numpax'];
			$totpaquete	= $row['totpaquete'];

			$ligaF	 	= encode_this("folio=".$folio);
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
					<td style='text-align:center;cursor:pointer;font-size: 22px; font-weight: bolder;'>
						<a href='https://".$_SERVER['SERVER_NAME']."/expo2017/procesa_pago.php?$ligaF'>
							<i data-toggle='tooltip' data-placement='left' title='PROCESAR PAGO' class='fa fa-suitcase' aria-hidden='true'></i>
						</a>
					</td>
			</tr>";
		}

		$html .= "</tbody>
		</table>";

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
<script>
       $(document).ready(function() {
           $('#example').DataTable();
       });
</script>