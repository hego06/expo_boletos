<?php
    require_once('conexion.php');
    $folios_cancelar = $_POST['folios'];

    for($i=0; $i< $numpax; $i++)
    {
        $cancerlar = "UPDATE sboletos SET cancelado='1' WHERE numfolio ='$folios_cancelar[$i]'";

        mysqli_query($conx, $update_folio) or die ("No se pudo realizar la operación");
    }

    require_once('guarda_boletos.php');
?>