<?php

	$servidor	= "localhost";

	$uss		= "laxmegatravel"; //laxmegatravel

	$patsss		= "";//m75clK*vrnpC //"V?#uFcXzGRBc"; 12-04-18 //Vow*iREO9xO_"; // 16-08-17

	$nbd 		= "laxmegat_expo";



	$conx = mysqli_connect($servidor,$uss ,$patsss ,$nbd);

	if(!$conx){

		die('Error de conexion: '. mysqli_connect_errno());

	}
?>