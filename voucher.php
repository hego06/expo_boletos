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
<body onload="voucher()">
	<div class="full-height header-background-main">
		<?php include ($_SERVER["DOCUMENT_ROOT"].'/php/topmenu.php');?>
		<?php include ($_SERVER["DOCUMENT_ROOT"].'/php/barralateral.php');?>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
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
										<input type="date" name="fecha1" id="fecha1" class="form-control input-sm " onchange="voucher()" value="<?php echo $hoy; ?>">
									</div>
									<div class="col-md-1 subtitulo-azul">
										AL
									</div>
									<div class="col-md-5">
										<input type="date" name="fecha2" id="fecha2" class="form-control input-sm " onchange="voucher()" value="<?php echo $hoy; ?>">
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-2">
							<div class="row">
								<div class="col-md-4 subtitulo-azul">
									RECIBO
								</div>
								<div class="col-md-8" >
									<input type="text" class="form-control input-sm text-uppercase" id="recibo" name="recibo" placeholder="RECIBO" onkeyup="voucher()">
								</div>
							</div>
						</div>
						<div class="col-md-3">
							<div class="row">
								<div class="col-md-4 subtitulo-azul">
									EXPEDIENTE
								</div>
								<div class="col-md-8" >
									<input type="text" class="form-control input-sm  text-uppercase" id="expediente" name="expediente" placeholder="EXPEDIENTE" onkeyup="voucher()">
								</div>
							</div>
						</div>
						<div class="col-md-3">
							<div class="row">
								<div class="col-md-4 subtitulo-azul">
									SOLICITUD
								</div>
								<div class="col-md-8" >
									<input type="text" class="form-control input-sm  text-uppercase" id="solicitud" name="solicitud" placeholder="SOLICITUD" onkeyup="voucher()">
								</div>
							</div>
						</div>
						<div class="col-md-12">
							<!-- RESPUESTA DE CONSULTA -->
							<div class="row right-15" style="overflow:auto;height: 530px;" id="voucher_"></div>
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
