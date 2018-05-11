<?php 
	include($_SERVER['DOCUMENT_ROOT'].'/php/session2.php');
    include('php/conexion.php');
	date_default_timezone_set('America/Mexico_city');
	if ($_GET){
		decode_get2($_SERVER['REQUEST_URI']);
		$expediente   = $_GET['expediente'];
		$consulta     = "SELECT * FROM expo_mov WHERE cid_expedi ='$expediente'";
		$result       = mysqli_query($conx,$consulta);
		$row          = mysqli_fetch_assoc($result);

        $folexpo      = $row['folexpo'];
		$nombre       = $row['cnombre'].' '.$row['capellidop'].' '.$row['capellidom'];
		$destino      = $row['cid_destin'].' '.$row['destino'];
        $ndestino     = trim(strtoupper($row['destino']));
		$fsalida      = $row['fsalida'];
		$npax         = $row['numpax'];
		$telefono     = '('.$row['clada'].') '.$row['ctelefono'];
		$email        = $row['cmail'];
        $iniciales    = $row['ciniciales'];
		$ejecutivo    = $iniciales.' - '.$row['nvendedor'];
        $letras       = $row['letras'];  
        $impteapag    = $row['impteapag'];
        //$tc           = $row['tc'];
		$pax          = $nombre.' X '.$npax;
        $cid_emplea   = $row['cid_emplea'];
        $fecha    = date('Y-m-d');
        $select   = "SELECT (`tcambio`) FROM tcambio WHERE fecha='$fecha'";
        $result   = mysqli_query($conx, $select);
        $col      = mysqli_fetch_assoc($result);
        $tc       = $col['tcambio'];
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
	<body>
        <div class="full-height header-background-main">
            <?php include ($_SERVER["DOCUMENT_ROOT"].'/php/topmenu.php');?>
            <?php include ($_SERVER["DOCUMENT_ROOT"].'/php/barralateral.php');?>
            <main class="dashboard-full-size" onclick="openNav('')">
            <div class="row">
                <div class="col-md-12 work-container">
                    <div class="tit_caja1"><i class="fa fa-home icon-home-route"></i>Inicio <i class="fa fa-angle-right icon-arrow-route"></i> Recibo de Efectivo</div>
                    <div class="work-area-box">
                        <form method="post" action="php/guardar_efec.php">    
                        <input type="hidden" name="folexpo" id="folexpo" value="<?php echo $folexpo; ?>">
                        <input type="hidden" name="pax_principal" id="pax_principal" value="<?php echo $pax; ?>">
                        <input type="hidden" name="expediente" id="expediente" value="<?php echo $expediente; ?>">
                        <input type="hidden" name="cid_emplea" id="cid_emplea" value="<?php echo $cid_emplea; ?>">
                        <input type="hidden" name="ctelefono" id="ctelefono" value="<?php echo $telefono; ?>">
                        <input type="hidden" name="destino" id="destino" value="<?php echo $ndestino; ?>">
                        <input type="hidden" name="fsalida" id="fsalida" value="<?php echo $fsalida; ?>">
                        <input type="hidden" name="tipo_c" id="tipo_c" value="<?php echo $tc; ?>">
                        <input type="hidden" name="ciniciales" id="ciniciales" value="<?php echo $iniciales; ?>">
                        <div class="col-md-12 subtitulo-azul"> Recibo de Efectivo </div><br><br><br> 
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="panel panel-success">
                                        <div class="panel-heading subtitulo">Datos Generales</div>
                                        <div class="panel-body">
                                            <div class="col-md-3"> <strong> Expediente :</strong> <span class="text-danger"><?php echo $expediente; ?></span> </div>
                                            <div class="col-md-3"> <strong> Fecha/Hora: </strong> <?php echo ddmmmaaaa22(date('Y-m-d')).', '.date('H:i:s');?> hrs </div>
                                            <div class="col-md-3"> <strong> Tipo : </strong> RECIBO </div>
                                            <div class="col-md-3"> <strong> Documento de Soporte : </strong> EFECTIVO </div>
                                        </div>
                                    </div>
                                </div>
                            </div>    
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="panel panel-success">
                                        <div class="panel-heading subtitulo">Información General de la Venta</div>
                                        <div class="panel-body">
                                            <table class="table">
                                                <tr>
                                                    <th><label for="nombre">Nombre</label></th>
                                                    <td colspan="3"><input class="form-control input-sm" type="text" id="nombre" name="nombre" value="<?php echo $nombre; ?>" autocomplete="off" required></td>
                                                </tr>
                                                <tr>
                                                    <th>Destino</th>
                                                    <td colspan="3"><?php echo $destino; ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Fecha de Salida</th>
                                                    <td> <?php echo ddmmmaaaa22(trim($fsalida)); ?></td>
                                                    <th>Pasajeros</th>
                                                    <td><?php echo $npax; ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Teléfono</th>
                                                    <td colspan="3"><?php echo $telefono; ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Correo Electrónico</th>
                                                    <td colspan="3"><?php echo $email; ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Ejecutivo</th>
                                                    <td colspan="3"><?php echo $ejecutivo;?></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="panel panel-success">
                                        <div class="panel-heading subtitulo">Datos Complementarios</div>
                                        <div class="panel-body">
                                            <table class="table">
                                                <tr>
                                                    <th>Seleccionar Moneda</th>
                                                    <td colspan="2">
                                                        <select class="form-control input-sm" id="moneda_e" name="moneda_e" required>
                                                            <option value=""></option>
                                                            <option value="MXN">PESOS - MXN</option>
                                                            <option value="USD">DÓLARES - USD</option>
                                                        </select>
                                                    </td>
                                                    <td colspan="3">&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <th>Fecha de Operación</th>
                                                    <td colspan="5"><?php echo ddmmmaaaa22(trim(date('Y-m-d'))); ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Fecha de Tipo de Cambio</th>
                                                    <td colspan="2"><?php echo ddmmmaaaa22(trim(date('Y-m-d'))); ?></td>
                                                    <th colspan="2">Tipo de Cambio</th>
                                                    <td id="tc_e" name="tc_e"><?php echo $tc; ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Importe a Pagar</th>
                                                    <td><input class="form-control input-sm soloN" type="text" name="imptepag_e" id="imptepag_e" required value="" autocomplete="off"></td>
                                                    <td colspan="4">&nbsp;</td>
                                                </tr>
                                                <tr hidden="true" class="importeUSD" id="importeUSD" name="importeUSD">
                                                    <th>Importe USD</th>
                                                    <td><input class="form-control input-sm soloN" type="text" name="impte_usd" id="impte_usd" value="" readonly></td>
                                                    <td colspan="4">&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6"><textarea name="letras_e" id="letras_e" readonly class="form-control input-sm"></textarea></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12" align="center">
                                <button type="submit" class="btn btn-success" data-toggle="tooltip" data-placement="bottom" title="IMPRIMIR RECIBO" >IMPRIMIR RECIBO</button>
                                <br><br><br><br>
                            </div>    
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <footer class="closed">
            <?php include($_SERVER['DOCUMENT_ROOT'].'/php/footer2.php') ?>
        </footer>
    </body>
</html>