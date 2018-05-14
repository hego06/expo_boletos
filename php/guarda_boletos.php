<?php 

    include ('conexion.php');
    
    $cid_expedi = $_POST['cid_expedi'];
    //echo $paquete = $_POST['paquete'];
    $paquete = 'paquete';
    $fsalida = $_POST['fsalida'];
    var_dump($_POST['nombresPasajeros']);
    $obser_la = $_POST['obser_la'];
    // echo $la = $_POST['la'];
    $la = 'linea aerea';
    $global = $_POST['global']; //variable para wspan, sabre y amadeus.
    $notas = $_POST['notas'];
    
    $ttotb = $_POST['ttotb'];
    $cid_emplea = $_POST['cid_emplea'];
    $tipotarifa = $_POST['tipotarifa'];
    
    echo $last_id = mysqli_insert_id($conx);
	$insert 	= "INSERT INTO sboletos (numfolio, cid_expedi, paquete, fechasal, nombrepax, 
                    obser_la, la, wspan, sabre, amadeus, notas, ttotb, tipotarifa) 
                    VALUES ('BLE', '$cid_expedi',  '$paquete', '$fsalida','nomnbre pasajero', '$obser_la', '$la', '$global', '$global', '$global', '$notas',
                    '$ttotb', '$tipotarifa')";
    mysqli_query($conx,$insert) or die (mysqli_error($conx));

    $last_id = mysqli_insert_id($conx);

    $update_folio = "UPDATE num_folio";


?>