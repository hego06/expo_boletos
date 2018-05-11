<?php
	include('php/conexion.php');
	include($_SERVER['DOCUMENT_ROOT'].'/php/cifraget.php');	
	
	$folexpo = $_POST['folexpo'];
	$sql = "select archivo from expo_mov WHERE folexpo = '".$folexpo."';";
	$result = mysqli_query($conx, $sql);
	if($result){
		$row = mysqli_fetch_assoc($result);
		$consec = $row['archivo'] + 1;
		$uploadDir = "pdfs";
		$inputFileNam = $folexpo."_".str_pad($consec,2,'0',STR_PAD_LEFT);
		if(isset($_POST['pago'])){
			$inputFileNam .= "_pago";
		}
		$id = encode_this("folio=".$folexpo);
		$pdf = include ($_SERVER['DOCUMENT_ROOT'].'/php/subepdf.php');
		if ( $pdf == 'Archivo cargado'){
			$sql = "UPDATE  expo_mov SET archivo = ".$consec." WHERE `folexpo` = '".$folexpo."';";
			mysqli_query($conx, $sql);
			header("location: archivovisor.php?$id");
		}
		else{
			echo "No se guardo el archivo". $pdf;
			echo "<meta http-equiv='refresh' content='3; url=archivovisor.php?$id'>";
		}
	}
	else{
		echo mysqli_error($conx);
		echo "<meta http-equiv='refresh' content='3; url=archivovisor.php?$id'>";
	}
?>
