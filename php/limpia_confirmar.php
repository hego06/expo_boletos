<?php 
//include($_SERVER['DOCUMENT_ROOT'].'/php/session.php');
	$clave = strtoupper($_POST['clave']);
	if ($clave == 'GOMMY'){
		echo "<meta http-equiv='refresh' content='0; url=../borrartablas.php'>";
	}
	else{
		echo "<script> alert('¡Acceso denegado, contraseña incorrecta!'); </script><meta http-equiv='refresh' content='0; url=../limpiatablas.php'>";
	}
?>