<?php 
	include ('conexion.php');
	$tcambio		=	trim($_POST['tipoC']);
	$fechahora		=	date('Y-m-d');
		
	$insert 	= "REPLACE INTO tcambio VALUES ('$fechahora',$tcambio)";
	mysqli_query($conx,$insert) or die ("ERROR AL GUARDAR TC");

	echo "<meta http-equiv='refresh' content='0; url=https://".$_SERVER['SERVER_NAME']."/expo2017/tipo_cambio.php'>";
?>