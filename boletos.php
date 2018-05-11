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

			<?php// include ($_SERVER["DOCUMENT_ROOT"].'/php/barralateral.php');?>

			<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

			<script src="js/funciones.js"></script>

			<link rel="stylesheet" type="text/css" href="css/estilo.css">

			<main class="dashboard-full-size" onclick="openNav('')">
				<form>
					<div class="row">

		                <div class="col-md-12 work-container"> 
		                	<div class="tit_caja1">
		                    	<i class="fa fa-address-book"></i>
		                    	Inicio <i class="fa fa-angle-right icon-arrow-route"></i>
		                    	<h2>SOLICITUD DE BOLETOS</h2>
		                    </div>
		                	<div class="container col-md-4">
							  <div class="panel panel-primary">
							  	<div class="panel-heading">Datos del Expediente</div>
							    <div class="panel-body">
							    	<div class="form-group">
							    		<label class="col-md-5">No. Expediente:</label>
							    	<input type="text" class="form-control" name="" readonly>
							    	</div>
							    	<div class="form-group ">
							    		<label class="col-md-5">Pasajero:</label>
							    	<input type="text" class="form-control" name="" readonly>
							    	</div>
							    	<div class="form-group ">
							    		<label class="col-md-5">Paquete:</label>
							    	<input type="text" class="form-control" name="" readonly>
							    	</div>
							    	<div class="form-group ">
							    		<label class="col-md-5">Fecha de Salida:</label>
							    	<input type="text" class="form-control" name="" readonly>
							    	</div>
							    	<div class="form-group ">
							    		<label class="col-md-5">Empleado:</label>
							    	<input type="text" class="form-control" name="" readonly>
							    	</div>
							    	<div class="form-group ">
							    		<label class="col-md-5">Depto.:</label>
							    	<input type="text" class="form-control" name="" readonly>
							    	</div>
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
									    		<input type="" class="form-control" name="">
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
										    		<select class="form-control" name="">
										    			<option value=""></option>
										    		</select>
										    	</div>
										    	<div class="form-group">
											    	<label>Cve. Línea Aerea</label>
											    	<input type="text" class="form-control" name="">
											    </div>
										    </div>
										</div>
									</div>
									<div class="col-md-6">
										  <div class="panel panel-primary">
										  	<div class="panel-heading">Globalizadores</div>
										    <div class="panel-body">
										    <div class="radio">
											  <label><input type="radio" name="radio" value="">WSPAN</label>
											</div>
											<div class="radio">
											  <label><input type="radio" name="radio" value="">Sabre</label>
											</div>
											<div class="radio">
											  <label><input type="radio" name="radio"  value="">Amadeus</label>
											</div>
											<input type="text" class="form-control" name="">
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
									    	<textarea rows="4" cols="50" class="form-control"></textarea>
									    </div>
								 	 </div>
								</div>
								<div class="container col-md-12">
								  <div class="panel panel-primary">
								  	<div class="panel-heading">Notas:</div>
								    <div class="panel-body">
								    	<textarea rows="2" cols="50" class="form-control"></textarea>
								    </div>
								  </div>
								</div>
								<div class="container col-md-12">
								  <div class="panel panel-primary">
								  	<div class="panel-heading">Total:</div>
								    <div class="panel-body">
								    	<label class="col-md-2">$</label><input type="text" class="form-control col-md-10" name="" placeholder="0.00">
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
