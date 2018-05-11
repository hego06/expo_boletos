<?php 

	include($_SERVER['DOCUMENT_ROOT'].'/php/session2.php');
	include($_SERVER['DOCUMENT_ROOT'].'/objeto/templeado.php');

	$hoy = date('Y-m-d');
	$ejecutivo	= imprimeEmp($_SESSION['id']);
	$id			= $_SESSION['id'];

?>

<html>
	<head>
		<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0" />
		<?php include ($_SERVER["DOCUMENT_ROOT"].'/php/head.php');?>
	</head>
    <body onLoad="reportePqts()">
        <div class="full-height header-background-main">
            <?php include ($_SERVER["DOCUMENT_ROOT"].'/php/topmenu.php');?>
            <?php include ($_SERVER["DOCUMENT_ROOT"].'/php/barralateral.php');?>
    
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
            <script src="js/funciones2.js"></script>
    
            <main class="dashboard-full-size" onclick="openNav('')">
                <div class="row">
                    <div class="col-md-12 work-container">
                        <div class="tit_caja1"><i class="fa fa-home icon-home-route"></i>Inicio <i class="fa fa-angle-right icon-arrow-route"></i> REPORTE DE VENTAS</div>
                        <div class="work-area-box"><br>
                        	<div class="col-md-12 subtitulo-azul">REPORTE DE VENTAS</div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-12 subtitulo-azul">
                                        RANGO DE FECHAS
                                    </div>
                                    <div class="col-md-12">
                                        <div class="col-md-2 subtitulo-rosa">
                                            DEL
                                        </div>
                                        <div class="col-md-4">
                                            <input type="date" name="fecha1" id="fecha1" class="input-work filtra" onChange="reportePqts()" value="<?php echo $hoy; ?>">
                                        </div>
                                        <div class="col-md-2 subtitulo-rosa">
                                            AL
                                        </div>
                                        <div class="col-md-4">
                                            <input type="date" name="fecha2" id="fecha2" class="input-work filtra" onChange="reportePqts()" value="<?php echo $hoy; ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
    
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-10 subtitulo-azul">
                                        EJECUTIVO
                                    </div>
                                    <div class="col-md-10" >
                                    <!-- POR USUARIO / TODOS -->
    <?php 
            if($_SESSION['dep']!=13 && $_SESSION['dep']!=10 && $_SESSION['id'] != '00106' && $_SESSION['id'] != '00814' && $_SESSION['dep']!=19 ){
                echo '<input name="ejecutivo" type="text" id="ejecutivo" value="'.$id.'" hidden readonly class="input-work filtra">
                                <input name="n_ejecutivo" type="text" id="n_ejecutivo" value="'.$ejecutivo.'" readonly class="input-work filtra">';
            }else{
                echo '<select name="ejecutivo" id="ejecutivo" onchange="reportePqts()" class="input-work filtra">';
                        opcionesEmp("x");
                echo '</select>';
            }
    ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <!-- RESPUESTA DE CONSULTA -->
                                <div class="row right-15" style="overflow:auto;height: 720px;" id="registrosPqts"></div>
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

