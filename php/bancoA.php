<?php
  include('conexion.php');
  
  	$tpv	= trim(strchr($_GET['terminal'],"|",true));
  	$numint	= trim(strchr($_GET['terminal'],"|"),"|");
	
	$busqueda	= "SELECT * , bancos.numcuenta, bancos.uso, bancos.numint FROM ckbancos JOIN bancos ON ckbancos.numbanco= bancos.numbanco WHERE bancos.tpv='$tpv' AND bancos.numint='$numint'";
	$res 		=	mysqli_query($conx, $busqueda);
	if (mysqli_num_rows($res) > 0){	
		while($row = mysqli_fetch_assoc($res)){
			$nombre = $row['nombre']." - ".$row['numcuenta']." - ".$row['uso']." - ".$row['numint'];
			$cuenta = $row['numbanco']." - " .$row['numint'];
	        echo "<option value='$cuenta'>$nombre</option>";
		}
	} 
	else{
			echo "<option selected='selected'>SIN BANCOS</option>";
	}
?>
