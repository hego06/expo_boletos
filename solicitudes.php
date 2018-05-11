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
<body onload="solicitudes('T')">
	<div class="full-height header-background-main">
		<?php include ($_SERVER["DOCUMENT_ROOT"].'/php/topmenu.php');?>
		<?php include ($_SERVER["DOCUMENT_ROOT"].'/php/barralateral.php');?>
		<script src="js/funciones.js"></script>
		<main class="dashboard-full-size" onclick="openNav('')">
			<div class="row">
                <div class="col-md-12 work-container">
                    <div class="tit_caja1"><i class="fa fa-home icon-home-route"></i>Inicio <i class="fa fa-angle-right icon-arrow-route"></i>SOLICITUDES</div>
					<div class="work-area-box"><br>
						<div class="col-md-4">
							<div class="row">
								<div class="col-md-12">
									<div class="col-md-1 subtitulo-azul">
										DEL
									</div>
									<div class="col-md-5">
										<input type="date" name="fecha1" id="fecha1" class="form-control input-sm " onchange="solicitudes('')" value="<?php echo $hoy; ?>">
									</div>
									<div class="col-md-1 subtitulo-azul">
										AL
									</div>
									<div class="col-md-5">
										<input type="date" name="fecha2" id="fecha2" class="form-control input-sm " onchange="solicitudes('')" value="<?php echo $hoy; ?>">
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-2">
							<div class="row">
								<div class="col-md-3 subtitulo-azul">
									FOLIO
								</div>
								<div class="col-md-9" >
									<input type="text" class="form-control input-sm soloN" id="folio" name="folio" placeholder="FOLIO REGISTRO" onchange="solicitudes('')">
								</div>
							</div>
						</div>
						<div class="col-md-3">
							<div class="row">
								<div class="col-md-4 subtitulo-azul">
									EXPEDIENTE
								</div>
								<div class="col-md-8" >
									<input type="text" class="form-control input-sm " id="expediente" name="expediente" placeholder="EXPEDIENTE" onchange="solicitudes('')">
								</div>
							</div>
						</div>
						<div class="col-md-3">
							<div class="row">
								<div class="col-md-3 subtitulo-azul">
									CLIENTE
								</div>
								<div class="col-md-9" >
									<input type="text" class="form-control input-sm " id="cliente" name="cliente" placeholder="CLIENTE" onchange="solicitudes('')">
								</div>
							</div>
						</div>
						<div class="col-md-12">
							<!-- RESPUESTA DE CONSULTA -->
							<div class="row right-15" style="overflow:auto;height: 600px;" id="consulta_soli"></div>
						</div>
						<div class='col-md-12'>	
							<div class='row'>
								<table class='table'>	
									<tr>
										<td class='warning'>&nbsp;</td>
										<th>PENDIENTES</th>
										<td class='info'>&nbsp;</td>
										<th>COTIZACIÓN</th>
										<td class='success'>&nbsp;</td>
										<th>PROCESADAS</th>
										<td class='danger'>&nbsp;</td>
										<th>LIGA BANCARIA</th>
									</tr>
								</table>
							</div>
						</div>
						<div class="col-md-4">
							<select name="tipo" id="tipo" onchange="solicitudes('T')" class="form-control input-sm " >
								<option value="todos">TODAS</option>
								<option value="pendiente">PENDIENTES</option>
								<option value="hoy">PROCESADAS DE HOY</option>
								<option value="liga">LIGA BANCARIA</option>			
								<option value="coti"> COTIZACIONES</option>
							</select><br><br>
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
