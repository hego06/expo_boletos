<?php 
include('conexion.php');
	for ($i=1; $i<=13; $i++){
		if (isset($_POST['check'.$i])){
			$truncate	= "TRUNCATE TABLE ".$_POST['check'.$i]." ";
			mysqli_query($conx,$truncate) or die  ("No ha sido limpiada la tabla ".$_POST['check'.$i]."".mysqli_errno($conx).$truncate);
			echo "La tabla ".$_POST['check'.$i]." ha sido limpiada.<br><br>";
		}
	}

	echo "<meta http-equiv='refresh' content='0; url=../borrartablas.php'>";
?>