<?php
date_default_timezone_set('America/Mexico_city');
	// include($_SERVER['DOCUMENT_ROOT'].'/php/session2.php');
	include('php/conexion.php');
	// $ideje      = $_SESSION['id'];
	// $nombreje   = strtoupper($_SESSION['usu']);
	// $mailejec   = strtoupper($_SESSION['mail']);
	// $iniciales  = strtoupper($_SESSION['iniusu']);
	$fecha    = date('Y-m-d');

	$cid_expedi	  = $_GET['folio'];
	$consulta   = "SELECT * FROM expo_mov WHERE cid_expedi = '$cid_expedi'";
  $resultado  = mysqli_query($conx, $consulta);
	$col        = mysqli_fetch_assoc($resultado);

	$cnombre    = $col["cnombre"];
	$capellidop = $col["capellidop"];
	$capellidom = $col["capellidom"];
	$clada      = $col["clada"];
	$ctelefono  = $col["ctelefono"];
	$cext       = $col["cext"];
	$ctipotel   = "<option selected value='".$col['ctipotel']."'>".$col['ctipotel']."</option>";
	$cmail      = $col["cmail"];
	$cid_destin = $col["cid_destin"];
	$destino    = $col["destino"];
	$nid_depto  = $col["nid_depto"];
	$nid_area   = $col["nid_area"];
	$fsalida    = $col["fsalida"];
	$numpax     = $col["numpax"];
	$observa    = $col["observa"];
	$totpaquete = $col["totpaquete"];
	$moneda     = $col["moneda"];
	$impteapag  = $col["impteapag"];
	$min        = $impteapag;
	$monedap    = $col['monedap'];
	$letras     = $col["letras"];
	//$tc         = $col["tc"];
	$cid_emplea = str_pad($col['cid_emplea'], 5, "0", STR_PAD_LEFT);
	$ciniciales = $col["ciniciales"];
	$nvendedor  = $col['nvendedor'];
	$cid_cotiza = $col["cid_cotiza"];
	$cid_expedi = $col["cid_expedi"];
	$hora       = $col["hora"];
	$consultaEmp   = "SELECT * FROM templeados WHERE cid_empleado = '$cid_emplea'";
  $res  = mysqli_query($conx, $consultaEmp);
	$empleado       = mysqli_fetch_assoc($res);

	$emp_nombre = $empleado['cnombre'];
	$emp_apellidoP = $empleado['capellidop'];
	$emp_apellidoM = $empleado['capellidom'];
	$depto_empleado = $empleado['nid_depto'];
	$cid_empleado = $empleado['cid_empleado'];


	$consultaDepto   = "SELECT * FROM tdeptos WHERE nid_depto = '$depto_empleado'";
  $res  = mysqli_query($conx, $consultaDepto);
	$dep_empleado      = mysqli_fetch_assoc($res);
	$nom_depto = $dep_empleado['cdepartamento'];


	$consultaBol="SELECT * FROM sboletos WHERE cid_expedi= '$cid_expedi' AND cancelado IS NULL";
	$resb= mysqli_query($conx, $consultaBol);
	$consultaBole="SELECT * FROM sboletos WHERE cid_expedi= '$cid_expedi'";
	$resbo= mysqli_query($conx, $consultaBole);

	$boletos= mysqli_fetch_assoc($resbo);
	$cvela=$boletos['la'];
	$confirmacion=$boletos['obser_la'];
	$notas=$boletos['notas'];
	$total=$boletos['ttotb'];
	$wspan=$boletos['wspan'];
	$sabre=$boletos['sabre'];
	$amadeus=$boletos['amadeus'];
	$globali=0;
	$cheq='';
	if($wspan != ''){
		$globali=$wspan;
		$cheq='checked';
	}
	if($sabre !=''){
		$globali=$sabre;
		$cheq='checked';
	}
	if($amadeus != ''){
		$globali=$amadeus;
		$cheq='checked';
	}


?>

<html>

	<head>

		<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0" />

		<?php //include ($_SERVER["DOCUMENT_ROOT"].'/php/head.php');?>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
		 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		 <style type="text/css">
		        #div1 {
		            overflow:scroll;
		            height:150px;
		        }
		    </style>

		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
		 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
 		 <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>


	</head>

	<body>

		<div class="full-height header-background-main">

			<?php //include ($_SERVER["DOCUMENT_ROOT"].'/php/topmenu.php');?>

			<?php //include ($_SERVER["DOCUMENT_ROOT"].'/php/barralateral.php');?>

			<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

			<script src="js/funciones.js"></script>

			<link rel="stylesheet" type="text/css" href="css/estilo.css">

			<main class="dashboard-full-size" onclick="openNav('')">
				<form method="post" action="php/actualizar_boletos.php">
					<div class="row">

		                <div class="col-md-12 work-container"> 
		                	<div class="tit_caja1">
		                    	<i class="fa fa-address-book"></i>
		                    	Inicio <i class="fa fa-angle-right icon-arrow-route"></i>
		                    	<h2>EDITAR BOLETOS</h2>
		                    </div>
		                    <input type="hidden" name="editar" value="1">
		                	<div class="container col-md-4">
							  <div class="panel panel-primary">
							  	<div class="panel-heading">Datos del Expediente</div>
							    	<div class="form-group">
							    		<label class="col-md-5">No. Expediente:</label>
							    	<input type="text" class="form-control" name="cid_expedi" value="<?php echo $cid_expedi ?>"readonly>
							    	</div>
							    	<div class="form-group ">
							    		<label class="col-md-5">Pasajero:</label>
							    	<input type="text" class="form-control" name="" value="<?php echo $cnombre." ".$capellidop." ".$capellidom." X ".$numpax?>" readonly>
									<input type="hidden" name="numpax" value="<?php echo $numpax?>">
									</div>
							    	<div class="form-group ">
							    		<label class="col-md-5">Paquete:</label>
							    	<input type="text" class="form-control" name="paquete" value="<?php echo $cid_destin."|".$destino?>" readonly>
							    	</div>
							    	<div class="form-group ">
							    		<label class="col-md-5">Fecha de Salida:</label>
							    	<input type="text" class="form-control" name="fsalida" value="<?php echo $fsalida?>" readonly>
							    	</div>
							    	<div class="form-group ">
							    		<label class="col-md-5">Empleado:</label>
							    	<input type="text" class="form-control" name="" value="<?php echo $emp_nombre." ".$emp_apellidoP." ".$emp_apellidoM?>"readonly>
							    	<input type="hidden" name="cid_emplea" value="<?php echo $cid_empleado ?>">
										</div>
							    	<div class="form-group ">
							    		<label class="col-md-5">Depto.:</label>
							    	<input type="text" class="form-control" name="" value="<?php echo $nom_depto ?>" readonly>

							    	</div>
							    </div>
							</div>
							<div class="container col-md-4">
								<div class="col-md-12">
									<div class="panel panel-primary">
										<div class="panel-heading">Pasajeros en el Expediente</div>
									    <div class="panel-body">
									    	<label>Nombre del Pasajero</label>
									    	<div class="container col-md-12" id="div1">
													<?php
													$i=1;
													while ($pax = $resb->fetch_assoc()) {
														echo "<div class='input-group'>
																	<span class='input-group-addon'>P.$i</span>
																	<input type='text' name='nombresPasajeros[]' class='form-control' value='".$pax['nombrepax']."'>
																	<input type='hidden' name='folios[]' value='".$pax['numfolio']."'>
																	</div>";
														$i=$i+1;
													}
													?>
									    	</div>
									    </div>
									</div>
								</div>
								<div class="col-md-12">
									<div class="col-md-6">
										<div class="panel panel-primary">
										  	<div class="panel-heading">Tarifa</div>
										    <div class="panel-body">
										    	<div class="form-group">
										    		<label>Tipo de Tarifa</label>
										    		<select class="form-control" name="tipotarifa">
										    			<option value="tarifa 1">tarifa 1</option>
										    		</select>
										    	</div>
										    	<div class="form-group">
											    	<label>Cve. Línea Aerea</label>
											    	<input type="text" class="form-control" name="la" value="<?=$cvela?>">
											    </div>
										    </div>
										</div>
									</div>
									<div class="col-md-6">
										  <div class="panel panel-primary">
										  	<div class="panel-heading">Globalizadores</div>
										    <div class="panel-body">
										    <div class="radio">
											  <label><input type="radio" name="radioGlobal" checked="<?=$cheq?>" value="1">WSPAN</label>
											</div>
											<div class="radio">
											  <label><input type="radio" name="radioGlobal" value="2" checked="<?=$cheq?>">Sabre</label>
											</div>
											<div class="radio">
											  <label><input type="radio" name="radioGlobal"  value="3" checked="<?=$cheq?>">Amadeus</label>
											</div>
											<input type="text" class="form-control" name="global" value="<?=$globali?>" required="required">
										    </div>
										  </div>
									</div>
								</div>
							</div>
							
							<div class="container col-md-4">
								<div class="container col-md-12">
								  	<div class="panel panel-primary">
									  	<div class="panel-heading">Confirmación de Aerolinea</div>
									    <div class="panel-body">
									    	<textarea rows="4" cols="50" class="form-control" name="obser_la" required="required"><?=$confirmacion?></textarea>
									    </div>
								 	 </div>
								</div>
								<div class="container col-md-12">
								  <div class="panel panel-primary">
								  	<div class="panel-heading">Notas:</div>
								    <div class="panel-body">
								    	<textarea rows="2" cols="50" class="form-control" name="notas"><?=$notas?></textarea>
								    </div>
								  </div>
								</div>
								<div class="container col-md-12">
								  <div class="panel panel-primary">
								  	<div class="panel-heading">Total:</div>
								    <div class="panel-body">
								    	<label class="col-md-2">$</label><input type="text" class="form-control col-md-10" name="ttotb" placeholder="0.00" value="<?=$total?>">
								    </div>
								  </div>
								</div>
							</div>
		                </div>

		            </div>
		            			<center><button class="btn btn-primary">Guardar</button></center>

	           </form>
	        </main>
	    </div>
	</body>
</html>

