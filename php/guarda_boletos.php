<?php 

    require_once('conexion.php');
    
    $cid_expedi = $_POST['cid_expedi'];
    $paquete = explode('|',$_POST['paquete']);
    $numpax = $_POST['numpax'];
    $fsalida = $_POST['fsalida'];
    $nombres = $_POST['nombresPasajeros'];
    $obser_la = $_POST['obser_la'];
    $la = $_POST['la'];
    $radioGlobal = $_POST['radioGlobal'];
    $global = $_POST['global']; //variable para wspan, sabre y amadeus.
    $notas = $_POST['notas'];
    
    $ttotb = $_POST['ttotb'];
    $cid_emplea = $_POST['cid_emplea'];
    $tipotarifa = $_POST['tipotarifa'];

    $wspan = "";
    $sabre = "";
    $amadeus = "";

    switch ($radioGlobal) {
        case '1':
            $wspan = $global;
            break;
        case '2':
            $sabre = $global;
            break;
        case '3':
            $amadeus = $global;
            break;
    }
    $fechaHoraCaptura = date('Y-m-d H:i:s');
    for($i=0; $i< $numpax; $i++)
    {
        $num = $i+1;
        $insert 	= "INSERT INTO sboletos (numfolio, cid_expedi, paquete, fechasal, nombrepax, 
                        obser_la, la, wspan, sabre, amadeus, notas, ttotb, fhcaptura, statusaut, nopasaj, cid_emplea, tipotarifa) 
                        VALUES ('BLE','$cid_expedi', '$paquete[0]', '$fsalida','$nombres[$i]', '$obser_la', '$la', 
                        '$wspan', '$sabre', '$amadeus', '$notas', '$ttotb','$fechaHoraCaptura','0', '$num', '$cid_emplea', '$tipotarifa')";
        mysqli_query($conx,$insert) or die (mysqli_error($conx));

        $num =+1;
        $last_id = mysqli_insert_id($conx);
        $num_folio = str_pad($last_id, 4, "0", STR_PAD_LEFT);
        $update_folio = "UPDATE sboletos SET numfolio='BLE$num_folio' WHERE id ='$last_id'";

        mysqli_query($conx, $update_folio) or die ("no se pudo realizar el registro");
    }

     echo "<script>
                alert('REGISTROS INSERTADOS CORRECTAMENTE');
                window.location= '../index.php'
            </script>";

?>