<?php
  include('conexion.php');
  include($_SERVER['DOCUMENT_ROOT'].'/php/fecha.php');

    $numint		= trim(strchr($_GET['terminal'],"|"),"|");
	$busqueda 	= "SELECT * FROM bancos WHERE numint = $numint";
	$res		= mysqli_query($conx, $busqueda);
	$row 		= mysqli_fetch_assoc($res);
	$titular 	= $row['titular'];
	$moneda 	= $row['moneda'];
	$numbanco 	= $row['numbanco'];
	if($moneda == 'MXN'){
		$moneda_ = 'PESOS - MXN';
	}else{
		$moneda_ = 'DÓLARES - USD';
	}
	$fechaop 	= ddmmmaaaa22(trim(date('Y-m-d')));
	$n_cuenta 	= $row['numcuenta'];


	$bancoN		= "SELECT * FROM ckbancos WHERE numbanco = $numbanco";
	$res		= mysqli_query($conx, $bancoN);
	$row 		= mysqli_fetch_assoc($res);
	$nbanco 	= $row['nombre'];


    echo "<td colspan='4'>
    			<table class='table'>
		    		<tr>
			            <th>Titular:</th>
			            <td>
			                <input class='form-control input-sm' id='titular' name='titular' type='text' readonly value='$titular'>
			                <input class='form-control input-sm' id='nbanco' name='nbanco' type='hidden' readonly value='$nbanco'>
			            </td>
			            <th>Moneda:</th>
			            <td>
			            	<input class='form-control input-sm' id='moneda_cuenta' name='moneda_cuenta' type='hidden' readonly value='$moneda'>
			                <input class='form-control input-sm' id='moneda_c' name='moneda_c' type='text' readonly value='$moneda_'>
			            </td>
			        </tr>
			        <tr height='41px'>
			            <th>Fecha Op.</th>
			            <td >
			                <input class='form-control input-sm' id='fechaop' name='fechaop' type='text' value='$fechaop' readonly>
			            </td>
			            <th>No. de Cuenta</th>
			            <td>
			                <input class='form-control input-sm' id='n_cuenta' name='n_cuenta' type='text' readonly value='$n_cuenta'>
			            </td>
			        </tr>
			    </table>
			</td>";
?>