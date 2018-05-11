<?php
  include('conexion.php');
	$busqueda	= "SELECT * FROM terminalpv WHERE activo = '1' ORDER BY cid_tpv ";
	$res		= mysqli_query($conx, $busqueda);
	echo "<option value=''> SELECCIONE LA TERMINAL </option>";
	if (mysqli_num_rows($res) > 0) {
    	while($row 	= mysqli_fetch_assoc($res)) {
    		$nombre = $row['terminalpv'];
			$tpv	= $row['cid_tpv'];
			$numint	= $row['numint'];
			$valor	= $tpv.'|'.$numint;
        	echo "<option value='$valor'>$nombre</option>";
    	}
	} 
	else {
		echo "<option selected='selected'>SIN TERMINALES</option>";
	}
	
?>