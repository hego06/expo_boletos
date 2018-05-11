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

		//$tc 		= trim($row['tc']);

		$impteapag 	= number_format(trim($row['impteapag']),2);

		$letras 	= trim($row['letras']);

		$detalle 	= '';

        $fecha    = date('Y-m-d');
        $select   = "SELECT (`tcambio`) FROM tcambio WHERE fecha='$fecha'";
        $result   = mysqli_query($conx, $select);
        if (mysqli_num_rows($result)>0) {
            $row  = mysqli_fetch_assoc($result);
            $tc_b = number_format($row['tcambio'],2);
        }
    }
?>

<html>
    <head>
        <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0" />
        <?php include ($_SERVER["DOCUMENT_ROOT"].'/php/head.php');?>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <link rel="stylesheet" type="text/css" href="css/estilo.css">
        <script src="js/funciones.js"></script>
    </head>
    <style type="text/css">
        input[type=number]::-webkit-outer-spin-button,
        input[type=number]::-webkit-inner-spin-button
        {
            -webkit-appearance: none;
            margin: 0;
        }
        input[type=number] {
            -moz-appearance:textfield;
        }
    </style>
<body>

	<div class="full-height header-background-main">

		<?php include ($_SERVER["DOCUMENT_ROOT"].'/php/topmenu.php');?>

		<?php include ($_SERVER["DOCUMENT_ROOT"].'/php/barralateral.php');?>

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

		<script src="js/funciones.js"></script>

		<link rel="stylesheet" type="text/css" href="css/estilo.css">

		<main class="dashboard-full-size" onclick="openNav('')">

			<div class="row">

                <div class="col-md-12 work-container">

                    <div class="tit_caja1"><i class="fa fa-home icon-home-route"></i>Inicio <i class="fa fa-angle-right icon-arrow-route"></i>PROCESAR PAGO CON TARJETA BANCARIA</div>

					<div class="work-area-box"><br>
                    
<form method="POST" action="php/guarda_tarjeta.php">
<input type="hidden" name="elaboro" id="elaboro" value="<?php echo $id; ?>">
<input type="hidden" name="folexpo" id="folexpo" value="<?php echo $folexpo; ?>">
<input type="hidden" name="expediente" id="expediente" value="<?php echo $expediente; ?>">

                        <div class="col-md-12 subtitulo-azul">PROCESAR PAGO CON TARJETA BANCARIA</div>

                        <div class="col-md-5">
<?php 
        $terminal       =   trim(strchr("TPV1|10","|",true));
        echo $terminal;
?>
                            <div class="row">

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
                                                        <td colspan="3" class="text-info">
                                                            <input class="form-control input-sm" id="nombre_t" name="nombre_t" type="text" value="<?php echo $cliente; ?>" >
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>DESTINO:</th>
                                                        <td colspan="3" class="text-info"><?php echo $destino; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>F. SALIDA:</th>
                                                        <td class="text-info"><?php echo $fsalida; ?></td>
            
                                                        <th>NO. PAX:</th>
            
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

						<div class="col-md-7">
                            
                            	<div class="row">
                                	
                                    <div class="panel panel-info">
                                    
                                    	<div class="panel-heading">DATOS BANCARIOS MEGA</div>
                                        
                                        <table class="table">
	                                        <tr>
                                                <th>Moneda</th>
                                                <td>
                                                    <select class="form-control input-sm importe_t" id="moneda" name="moneda" required autofocus>
                                                        <option value="MXN" selected="true">MXN</option>
                                                       <!-- <option value="USD">USD</option> -->
                                                    </select>
                                                </td>
                                                <th>Terminal Bancaria</th>
                                                <td>
                                                    <select class="form-control input-sm" id="terminal_t" name="terminal_t"  required onchange="CargosB(this.value)" >
                                                        <?php include('php/terminales.php'); ?>
                                                    </select>
                                                </td>
                                           </tr>
                                           <tr> 
                                                <th>Banco de Aplicación</th>
                                                <td>
                                                    <select class="form-control input-sm" id="bancoaplic" name="bancoaplic" required >
                                                    </select>
                                                </td> 
                                                <th>Cargos Administrativos y Bancarios</th>
                                                <td>
                                                    <select class="form-control input-sm" id="cargos" name="cargos" required >
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr id="datosBanco" hidden></tr>
                                        </table>
                                    </div>
                                </div>         
                            </div> 
                            <div class="col-md-12">

                            <div class="row">
    
                                <div class="panel panel-info">  
                                
                                    <div class="panel-heading">DATOS BANCARIOS CLIENTE</div>  
                                
                                	<table class="table">
                                        <tr>
                                        	<th>Instrumento</th>
                                            <td>
                                                <select class="form-control input-sm" id="instrumento" name="instrumento" required>
                                                    <option value=""></option>
                                                    <option value="DEBITO">DÉBITO</option>
                                                    <option value="CREDITO">CRÉDITO</option>
                                                </select>
                                            </td>
                                        	<th>Codigo</th>
                                            <td>
                                                <input class="form-control input-sm" id="codigo" name="codigo" type="text" value="****"  readonly></td>
                                            <th>Fecha de Tipo de Cambio</th>
                                            <td>
                                                <input class="form-control input-sm" id="ftc" name="ftc" type="text" value="<?php echo ddmmmaaaa22(trim(date('Y-m-d'))); ?>" readonly>
                                            </td>
                                            </tr>
                                        <tr>
                                        	<th>Tarjeta</th>
                                            <td>
                                                <select class="form-control input-sm" id="tarjeta" name="tarjeta" required>
                                                    <option value=""></option>
                                                    <option value="VISA">VISA</option>
                                                    <option value="MASTER CARD">MASTER CARD</option>
                                                    <option value="AMERICAN EXPRESS">AMERICAN EXPRESS</option>
                                                </select>
                                            </td>
                                        	<th>Autorización</th>
                                            <td>
                                                <input class="form-control input-sm soloN" id="autorizacion" name="autorizacion" type="text" value="" minlength="2" maxlength="6" autocomplete="off" required>
                                            </td>
                                            <th>Tipo de Cambio $</th>
                                            <td>
                                                <input class="form-control input-sm" id="tc_b" name="tc_b" type="text" value="<?php echo $tc_b; ?>" readonly>
                                            </td>
                                        </tr>
                                        <tr>
                                        	<th>Tipo</th>
                                            <td>
                                                <select class="form-control input-sm" id="tipotarjeta" name="tipotarjeta" required>
                                                    <option value=""></option>
                                                    <option value="NACIONAL">NACIONAL</option>
                                                    <option value="EXTRANJERO">EXTRANJERO</option>
                                                </select>											
                                            </td>
                                        	<th>Valida</th>
                                            <td>
                                                <input class="form-control input-sm" type="month" id="valido" name="valido" value="<?php echo date('Y-m'); ?>" required/>
                                            </td>
                                            <th align="right">Importe</th>
                                            <td>
                                                <input class="form-control input-sm importe_t" id="importe_t" name="importe_t" type="number" autocomplete="off" value="" required min="1" step="any">
                                            </td>
                                        </tr>
                                        <tr height="40px">
                                        	<th>Procedencia</th>
                                            <td>
                                                <select class="form-control input-sm" id="procedencia" name="procedencia" required>
                                                    <?php include ('php/bancos.php');?>
                                                </select>
                                            </td>
                                        	<th>Movimiento</th>
                                            <td>
                                                <input class="form-control input-sm" id="movimiento" name="movimiento" type="text" value="S.B.C." readonly />
                                            </td>
                                            <td colspan="2">
                                                <textarea readonly class="form-control input-sm" name="impteletra" id="impteletra" style="max-height:60px; max-width:100%; width:100%; height:60px;"></textarea>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12" align="center">
                                <button type="submit" class="btn btn-info" data-toggle="tooltip" data-placement="bottom" title="IMPRIMIR RECIBO" >IMPRIMIR RECIBO</button>
                                <br><br><br><br>
                        </div>    
					</div>
</form>                    
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