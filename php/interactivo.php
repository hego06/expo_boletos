<?php
	include('conexion.php');
	$destino	= trim(strtoupper(trim($_POST['valor'])));
	$corta 		= explode("§", $destino);
	$cid_destpack= trim(trim($corta[1]));
	$cdestpack   = trim(trim($corta[0]));
    $busqueda 	= "SELECT cid_destpack, cdestpack FROM tdestpack WHERE cid_destpack = '".trim($cid_destpack)."' AND cdestpack = '$cdestpack'";
    $resultado 	= mysqli_query($conx, $busqueda);
    if($resultado){
        if(mysqli_num_rows($resultado) == 1 ){
            echo "EXISTE";
		}
        else{
            echo $busqueda;
        }
    }
    else{
        return "ERROR CONSULTA";
    }
	mysqli_close($conx);
?>