<?php 

	include($_SERVER['DOCUMENT_ROOT'].'/php/session2.php');

	include($_SERVER['DOCUMENT_ROOT'].'/objeto/templeado.php');

	include($_SERVER['DOCUMENT_ROOT'].'/objeto/deptos.php');

	include('php/conexion.php');



	$hoy = date('Y-m-d');



	$ejecutivo	= imprimeEmp($_SESSION['id']);

	$id			= $_SESSION['id'];

	

	if($_GET){

		decode_get2($_SERVER["REQUEST_URI"]);

		$expediente	= $_GET['expediente'];

		$consulta 	= "SELECT * FROM expo_mov WHERE cid_expedi = '$expediente'";

		$res 		= mysqli_query($conx, $consulta);

		$row 		= mysqli_fetch_assoc($res);



		$folexpo 	= trim($row['folexpo']);

		//$folexpo 	= folios('EXPEDIENTE');

		$cliente 	= strtoupper(trim($row['cnombre']).' '.trim($row['capellidop']).' '.trim($row['capellidom']));

		$lada 		= trim($row['clada']);

		$cext 		= trim($row['cext']);

		$telefono 	= '('.$cext.')'.trim($row['ctelefono']);

		$tipotel 	= trim($row['ctipotel']);

		$cmail 		= trim($row['cmail']);

		$destino 	= strtoupper(trim($row['cid_destin']).' - '.trim($row['destino']));

		$totalpaq 	= trim($row['totpaquete']).' '.trim($row['moneda']);

		$depto 		= trim($row['nid_depto']).' - '.especificoDepto(trim($row['nid_depto']));

		$fsalida 	= ddmmmaaaa(trim($row['fsalida']));

		$pax 		= trim($row['numpax']);

		$ejecutivo 	= trim($row['ciniciales']).' - '.trim($row['nvendedor']);

		$expediente = trim($row['cid_expedi']);

		$observa 	= trim($row['observa']);

		$tc 		= trim($row['tc']);

		$impteapag 	= number_format(trim($row['impteapag']),2);

		$letras 	= trim($row['letras']);

		$detalle 	= '';

}



?>

<html>

	<head>

		<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0" />

		<?php include ($_SERVER["DOCUMENT_ROOT"].'/php/head.php');?>

	</head>

<body>

	<div class="full-height header-background-main">

		<?php include ($_SERVER["DOCUMENT_ROOT"].'/php/topm6enu.php');?>

		<?php include ($_SERVER["DOCUMENT_ROOT"].'/php/barralateral.php');?>

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

		<script src="js/funciones.js"></script>

		<link rel="stylesheet" type="text/css" href="css/estilo.css">

		<main class="dashboard-full-size" onclick="openNav('')">

			<div class="row">

                <div class="col-md-12 work-container">

                    <div class="tit_caja1"><i class="fa fa-home icon-home-route"></i>Inicio <i class="fa fa-angle-right icon-arrow-route"></i>PROCESAR PAGO CON TARJETA BANCARIA</div>

					<div class="work-area-box"><br>

						<div class="col-md-12 subtitulo-azul">PROCESAR PAGO CON TARJETA BANCARIA</div>

						<div class="col-md-6">

							<div class="row">

								<div class="col-md-12">

									<div class="row">

										<div class="panel panel-info">

											<div class="panel-heading">DATOS DE LA VENTA</div>

												<table class="table">
                                    
                                                    <tr>
            
                                                        <th>EXPEDIENTE:</th>
            
                                                        <td colspan="3" class="text-info"><?php echo $expediente; ?></td>
            
                                                    </tr>
            
                                                    <tr>
            
                                                        <th>NOMBRE:</th>
            
                                                        <td colspan="3" class="text-info"><?php echo $cliente; ?></td>
            
                                                    </tr>
            
                                                    <tr>
            
                                                        <th>DESTINO:</th>
            
                                                        <td colspan="3" class="text-info"><?php echo $destino; ?></td>
            
                                                    </tr>
            
                                                    <tr>
            
                                                        <th>FECHA DE SALIDA:</th>
            
                                                        <td class="text-info"><?php echo $fsalida; ?></td>
            
                                                        <th>NO. DE PASAJEROS:</th>
            
                                                        <td  class="text-info"><?php echo $pax; ?></td>
            
                                                    </tr>
            
                                                    <tr>
            
                                                        <th>TELÉFONO:</th>
            
                                                        <td class="text-info"><?php echo $telefono; ?></td>
                                                        
                                                        <th>E-MAIL:</th>
            
                                                        <td class="text-info"><?php echo $cmail; ?></td>
            
                                                    </tr>
                                                    
                                                    <tr>
            
                                                        <th>EJECUTIVO(A):</th>
            
                                                        <td colspan="3" class="text-info"><?php echo $ejecutivo; ?></td>
            
                                                    </tr>
            
                                                </table>

										</div>

									</div>

								</div> 
                                
                           </div>
                           
						</div>

						<div class="col-md-6">

							<?php echo $tipo_pago; ?>
                            <div class="col-md-12">
                            
                            	<div class="row">
                                	
                                    <div class="panel panel-info">
                                    
                                    	<div class="panel-heading">DATOS BANCARIOS MEGA</div>
                                        
                                        <table class="table">
	                                        <tr height="41px">
                                                <th>Moneda</th>
                                                <td><select class="form-control input-sm" id="moneda" name="moneda" style="width:auto" required>
                                                        <option value="MXN">MXN</option>
                                                        <option value="USD">USD</option>
                                                    </select>
                                                </td>
                                                <td>&nbsp;</td>
                                                <th>Terminal Bancaria</th>
                                                <td><select class="form-control input-sm" id="tb" name"tb" style="width:auto" required>
                                                        <option value="">EXODUS TRAVEL BANCOMER</option></select>
                                                </td>
                                           </tr>
                                           <tr height="41px"> 
                                                <th>Banco de Aplicación</th>
                                                <td><select class="form-control input-sm" id="bancoaplic" name="bancoaplic" style="width:auto" required>
                                                        <option value="">SANTANDER</option></select>
                                                </td> 
                                                <td>&nbsp;</td>                                       
                                                <th>Cargos Administrativos y Bancarios</th>
                                                <td><select class="form-control input-sm" id="cargos" name="cargos" style="width:auto" required>
                                                        <option value=""> Regular </option></select>
                                                </td>
                                            </tr>
                                        </table><br>
                                        
                                        <table class="table">

                                            <tr height="41px">
                                                <th>Titular:</th>
                                                <td><?php echo 'Mega Travel Agency S.A. de C.V.';?></td>
                                                <th>Uso:</th>
                                                <td><input class="form-control input-sm" id="uso" name="uso" type="text" value="<?php echo 'Ingresos';?>" disabled></td>
                                                <th>No. de Cuenta</th>
                                                <td><input class="form-control input-sm" id="ncuenta" name="ncuenta" type="text" value="<?php echo '0171539698' ?>" disabled></td>
                                            </tr>
                                            <tr height="41px">
                                                <th>Moneda:</th>
                                                <td><input class="form-control input-sm" id="moneda" name="moneda" type="text" value="<?php echo 'USD'; ?>" disabled></td>
                                                <th>Fecha Op.</th>
                                                <td colspan="2"><input class="form-control input-sm" id="fechaop" name="fechaop" type="text" value="<?php echo ddmmmaaaa22(trim(date('Y-m-d')));?>" disabled></td>
                                                <td>&nbsp;</td>
                                                
                                            </tr>
                                        </table>
                                        
                                    </div>
                                
                                </div>
                            
                            </div>
                       
                        </div> 
                        
                        <div class="col-md-12">

                            <div class="row">
    
                                <div class="panel panel-info">  
                                
                                    <div class="panel-heading">DATOS BANCARIOS CLIENTE</div>  
                                
                                	<table class="table" width="100%">
                                    	
                                        <col width="5%">
                                        <col width="10%">
                                        <col width="5%">
                                        <col width="10%">
                                        <col width="5%">
                                        <col width="10%">
                                        <col width="20%">
                                        <col width="5%">
                                    
                                        <tr height="40px">
                                        	<th>Instrumento</th>
                                            <td><select class="form-control input-sm" id="instrumento" name="instrumento" style="width:auto" required>
                                                    <option value="DEBITO">DÉBITO</option>
                                                    <option value="CREDITO">CRÉDITO</option>
                                                </select>
                                            </td>
                                        	<th>Codigo</th>
                                            <td><input class="form-control input-sm" id="codigo" name="codigo" type="text" value="****" style="width:auto" disabled></td>
                                            <th>Fecha de Tipo de Cambio</th>
                                            <td><input class="form-control input-sm" id="ftc" name="ftc" type="text" value="<?php echo ddmmmaaaa22(trim(date('Y-m-d'))); ?>" style="width:auto" disabled></td>
                                            <td>&nbsp;</td>
                                        </tr>
                                        <tr height="40px">
                                        	<th>Tarjeta</th>
                                            <td><select class="form-control input-sm" id="tarjeta" name="tarjeta" style="width:auto" required>
                                                    <option value="VISA">VISA</option>
                                                    <option value="MASTER CARD">MASTER CARD</option>
                                                    <option value="AMERICAN EXPRESS">AMERICAN EXPRESS</option>
                                                </select>
                                            </td>
                                        	<th>Autorización</th>
                                            <td><input class="form-control input-sm" id="autorizacion" name="autorizacion" type="text" value="****" style="width:auto" disabled></td>
                                            <th>Tipo de Cambio</th>
                                            <td><input class="form-control input-sm" id="autorizacion" name="autorizacion" type="text" value="<?php echo $tc; ?>" style="width:auto" disabled></td>
                                            <td colspan="2">&nbsp;</td>
                                        </tr>
                                        <tr height="40px">
                                        	<th>Tipo</th>
                                            <td><select class="form-control input-sm" id="tipotarjeta" name="tipotarjeta" style="width:auto" required>
                                                    <option value="NACIONAL">NACIONAL</option>
                                                    <option value="EXTRANJERO">EXTRANJERO</option>
                                                </select>											
                                            </td>
                                        	<th>Valida</th>
                                            <td><input class="form-control input-sm" type="month" id="valido" name="valido" min="<?php echo date('Y-m'); ?>" value="<?php echo date('Y-m'); ?>" size="13" style="width:auto" required/></td>
                                            <td colspan="4">&nbsp;</td>
                                        </tr>
                                        <tr height="40px">
                                        	<th>Procedencia</th>
                                            <td><select class="form-control input-sm" id="tarjeta" name="tarjeta" style="width:auto" required>
                                                    <option value="VISA">VISA</option>
                                                    <option value="MASTER CARD">MASTER CARD</option>
                                                    <option value="AMERICAN EXPRESS">AMERICAN EXPRESS</option>
                                                </select>
                                            </td>
                                        	<th>Movimiento</th>
                                            <td><input class="form-control input-sm" id="movimiento" name="movimiento" type="text" value="S.B.C."  style="width:auto" disabled/></td>
                                            <th align="right">Importe</th>
                                            <td><input class="form-control input-sm soloN" id="importe" name="importe" type="text" value="<?php echo $impteapag; ?>" style="width:auto" ></td>
                                            <td><textarea readonly class="form-control input-sm" name="impteletra" id="impteletra" style="max-height:60px; max-width:100%; width:100%; height:60px;" value="<?php echo $letras ; ?>"></textarea>
                                            </td>
                                            <td>&nbsp;</td>
                                        </tr>
                                        
                                    </table>
                                    
                                </div>
                                
                            </div>
                            
                        </div>

					</div>

				</div>

			</div>
            
		</main>

	</div>

	<footer class="closed">

			<?php include($_SERVER['DOCUMENT_ROOT'].'/php/footer2.php') ?>

	</footer>

</body>

</html>

<script>

	$(document).ready(function(){

	    $('[data-toggle="tooltip"]').tooltip(); 

	});

</script>