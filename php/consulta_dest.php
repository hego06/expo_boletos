<?php
	include 'conexion.php';
	$tipo 	 = $_GET['tipo'];

	if($tipo == 2){
		$id_dest  = trim($_GET['id_destino']);
		$consulta = "SELECT * FROM tdestpack WHERE cid_destpack LIKE '%$id_dest%' AND bactiva = 'S' AND cid_destpack LIKE 'MT%' AND cid_destpack NOT LIKE 'MTC%' AND cid_destpack NOT LIKE 'MD%'";
		$resultado= mysqli_query($conx,$consulta);
		if (mysqli_num_rows($resultado) > 0) {
			$row 			= mysqli_fetch_assoc($resultado);
			$cid_destpack	= strtoupper(trim($row['cid_destpack']));
			$cdestpack 		= strtoupper(trim($row['cdestpack']));
			$respuesta 		= $cdestpack.' § '.$cid_destpack;
			echo $respuesta;
		}else{
			echo 'NO';
		}
	}
	if($tipo == 1){
		$destino  = trim($_GET['destino']);
		$consulta = "SELECT * FROM tdestpack WHERE cdestpack like '%$destino%' AND cid_destpack  LIKE 'MT%' AND cid_destpack NOT LIKE 'MTC%' AND cid_destpack NOT LIKE 'MD%' AND bactiva = 'S' limit 10";
		$resultado= mysqli_query($conx,$consulta);
		if (mysqli_num_rows($resultado) > 0) {
			while($row = mysqli_fetch_assoc($resultado)){
				$cid_destpack	= strtoupper(trim($row['cid_destpack']));
				$cdestpack 		= strtoupper(trim($row['cdestpack']));
				$respuesta 		= $cdestpack.' § '.$cid_destpack;
				echo "<option value='$respuesta'>$respuesta</option>";
			}
		}
	}
?>