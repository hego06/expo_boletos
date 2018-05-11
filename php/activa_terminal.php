<?php
	include('conexion.php');
	$tpv	= $_POST['activaTPV'];
	$sql	= "UPDATE  `terminalpv` SET  `activo` =  '1' WHERE  `terminalpv`.`cid_tpv` =  '$tpv'";
	mysqli_query($conx, $sql) or die ("Error al activar la terminal ".errno($conx));
	header('Location: ../terminales.php');
?>