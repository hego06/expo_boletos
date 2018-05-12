<?php 

    include ('conexion.php');
    
    $cid_expedi = $_POST['cid_expedi'];
    $paquete = $_POST['paquete'];
    $fechasal = $_POST['fechasal'];
    $nombresPasajeros = $_POST['nombresPasajeros'];
    $obser_la = $_POST['obser_la'];
    $la = $_POST['la'];
    $global = $_POST['global']; //variable para wspan, sabre y amadeus.
    $notos = $_POST['notas'];
    $ttob = $_POST['ttob'];
    $cid_emplea = $_POST['cid_emplea'];
    $tipotarifa = $_POST['tipotarifa'];
    
	$insert 	= "INSERT INTO sboletos VALUES ()";

	mysqli_query($conx,$insert) or die ("ERROR AL GUARDAR");


?>