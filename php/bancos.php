<?php
 include 'conexion.php';
	$busqueda 	= "SELECT *  FROM ckbancos";
	$res		= mysqli_query($conx, $busqueda);
	echo "<option value=''></option>";
	if (mysqli_num_rows($res) > 0){	
		while($row = mysqli_fetch_assoc($res)){
			$nombre = $row['nombre']." - ".$row['numbanco'];
			$cuenta = $row['numbanco'];
			echo "<option value='$cuenta'>$nombre</option>";
		}
	}else{
		echo "<option selected='selected'>SIN BANCOS</option>";
	}
?>
