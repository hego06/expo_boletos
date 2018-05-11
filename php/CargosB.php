<?php
  include('conexion.php');
  	$cid_tpv	= trim(strchr($_GET['terminal'],"|",true));
	$busqueda	= "SELECT * FROM cargos  WHERE cid_tpv='$cid_tpv' ORDER BY cid_tpv ";
	$res		= mysqli_query($conx, $busqueda);
	echo '<option value=""> SELECCIONE CARGOS </option>';
		if (mysqli_num_rows($res) > 0) {
    		while($row = mysqli_fetch_assoc($res)) {
			$nombre 	= $row['cargo']." - ".$row['mes']." - ".$row['vtas']." - ".$row['bco']." - ".$row['obs'];
			$tpv		= $row['cargo'].'-'.$row['cid_tpv'].'-'.$row['nid_cargo']."-".$row['mes']."-".$row['vtas']."-".$row['bco']." - ".$row['obs'];
    		echo "<option value='$tpv'>".$nombre."</option>";
    		}
		} 
		else {
			echo "<option selected='selected'>SIN CARGOS</option>";
		}
?>