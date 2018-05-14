<?php
    require_once('conexion.php');
    $folios_cancelar = $_POST['folios'];
    $cont = count($folios_cancelar);
    for($i=0; $i< $cont; $i++)
    {
        $cancerlar = "UPDATE sboletos SET cancelado='1' WHERE numfolio ='$folios_cancelar[$i]'";

        mysqli_query($conx, $cancerlar) or die ("No se pudo realizar la operación");
    }
    
    require_once('guarda_boletos.php');
?>