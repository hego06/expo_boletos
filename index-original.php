<?php 
  date_default_timezone_set('America/Mexico_city');
	include($_SERVER['DOCUMENT_ROOT'].'/php/session2.php');
  include('php/conexion.php');
$ideje      = $_SESSION['id'];
$nombreje   = strtoupper($_SESSION['usu']);
$mailejec   = strtoupper($_SESSION['mail']);
$iniciales  = strtoupper($_SESSION['iniusu']);
  $fecha    = date('Y-m-d');
  $select   = "SELECT (`tcambio`) FROM tcambio WHERE fecha='$fecha'";
  $result   = mysqli_query($conx, $select);
  if (mysqli_num_rows($result)>0) {
    $row  = mysqli_fetch_assoc($result);
    $tc   = $row['tcambio'];
  }
  else{ $tc = '00.00'; }

  
  if($_GET){
    decode_get2($_SERVER["REQUEST_URI"]); 
    $folexpo    = $_GET['folio'];
    $ver        = $_GET['v'];
    $consulta   = "SELECT * FROM expo_mov WHERE folexpo = '$folexpo'";
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
    $ciniciales = $col["ciniciales"];
    $nvendedor  = $col["nvendedor"];
    $cid_cotiza = $col["cid_cotiza"];
    $cid_expedi = $col["cid_expedi"];
    $hora       = $col["hora"];
    if($col['monedap'] == 'MXN'){
        $monedaA = 'PESOS - MXN';
    }else{
        $monedaA = 'DÓLARES - USD';
    }
    $moeda_A    = "<option selected value='".$col['monedap']."'>$monedaA</option>";
    $dest_cve   = $destino." § ".trim($cid_destin);
    if($col['status']=='X'){
        $status = 'checked';
    }else{
        $status = '';
    }

    if($ver != '1'){
        $boton  = '<button type="submit" id="grabar" data-toggle="tooltip" data-placement="bottom" title="GUARDAR CAMBIOS" name="grabar" value="editar" class="btn btn-primary">GUARDAR CAMBIOS</button>';
        $read   = '';
    }else{
        $boton  = '';
        $read   = 'disabled';
    }
    $funcion    = ' onload="monedaP()"';
  }else{
    $folexpo    = '';
   // $tc         = '';
    $cnombre    = '';
    $capellidop = '';
    $clada      = '';
    $ctelefono  = '';
    $cext       = '';
    $ctipotel   = "<option selected value=''></option>";
    $capellidom = '';
    $cmail      = '';
    $destino    = '';
    $cid_destin = '';
    $totpaquete = '';
    $minpaq     = '1';      
    $moneda     = '';
    $fsalida    = date('Y-m-d');
    $numpax     = '';
    $monedap    = '';
    $impteapag  = '';
    $letras     = '';
    $observa    = '';
    $dest_cve   = '';
    $selected   = 'selected';   
    $status     = "checked";
    $boton  = '<button type="submit" id="grabar" data-toggle="tooltip" data-placement="bottom" title="GRABAR REGISTRO" name="grabar" value="grabar" class="btn btn-primary">Grabar</button>';
    $funcion    = '';
  }

?>
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
<html>
	<head>
      <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0" />
		<?php include ($_SERVER["DOCUMENT_ROOT"].'/php/head.php');?>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script src="js/funciones.js"></script>
        <link rel="stylesheet" type="text/css" href="css/estilo.css">
	</head>
	<body <?php echo $funcion; ?>>
        <div class="full-height header-background-main">
			<?php include ($_SERVER["DOCUMENT_ROOT"].'/php/topmenu.php');?>
            <?php include ($_SERVER["DOCUMENT_ROOT"].'/php/barralateral.php');?>
            
			<main class="dashboard-full-size" onclick="openNav('')">
			<div class="row">
                <div class="col-md-12 work-container">
                    <div class="tit_caja1"><i class="fa fa-home icon-home-route"></i>Inicio <i class="fa fa-angle-right icon-arrow-route"></i> CAPTURA DE DATOS
                    </div>
                <div class="work-area-box"><br>
                    <form method="post" action="php/guardar.php" onKeyPress="if(event.keyCode == 13) event.returnValue = false;" onsubmit="return guardaCotiza()"> 
<?php if($tc != '00.00' || empty($tc) || $tc != '0' || $ver == '1'){ ?>

                     <div class="col-md-9 subtitulo-azul" style="text-align: left;">REGISTRO DE INFORMACIÓN</div>
                        <div class="col-md-3 subtitulo-rosa">
                            <label class="switch" data-toggle='tooltip' data-placement='left' title='COTIZACIÓN'>
                                <input type="checkbox" name="cotiza" id="cotiza" <?php echo $status; ?>>
                                    <div class="slider com round"></div>
                             </label>&nbsp;GUARDAR REGISTRO COMO COTIZACIÓN</div>
                            <!-- Formulario -->
							
                                  <input type="hidden" value="<?php echo $tc;?>" name="tc" id="tc"> 
                                  <input type="hidden" value="<?php echo $folexpo;?>" name="folexpo" id="folexpo"> 
                                  <input type="hidden" value="<?php echo $ideje;?>" name="id" id="id"> 
                                  <input type="hidden" value="<?php echo $nombreje;?>" name="usu" id="usu"> 
                                  <input type="hidden" value="<?php echo $mailejec;?>" name="mail" id="mail"> 
                                  <input type="hidden" value="<?php echo $iniciales;?>" name="iniusu" id="iniusu">
                                  <div class="col-md-12" align="center">    
                                    <div class="col-md-12 subtitulo-rosa" style="text-align: center;">
                                    T.C.: $ <?php echo $tc; ?></div>
                                </div>
                                <div class="col-md-3">    
                                    <label for="nombre">Nombre(s)</label>
                                    <input class="form-control input-sm" id="nombre" name="nombre" type="text" placeholder="Introduzca el Nombre" required autocomplete="off" value="<?php echo $cnombre; ?>"  <?php echo $read; ?>>
                                </div>
                            
                                <div class="col-md-3">    
                                    <label for="apellidop">Apellido Paterno</label>
                                    <input class="form-control input-sm" id="apellidop" name="apellidop" type="text" placeholder="Introduzca el Apellido Paterno" required autocomplete="off" value="<?php echo $capellidop; ?>" <?php echo $read; ?>>
                                </div>
                                
                                <div class="col-md-3">    
                                    <label for="apellidom">Apellido Materno</label>
                                    <input class="form-control input-sm" id="apellidom" name="apellidom" type="text" placeholder="Introduzca el Apellido Materno" autocomplete="off" value="<?php echo $capellidom; ?>" <?php echo $read; ?>>
                                </div>
                                
                                <div class="col-md-3">    
                                    <label for="correo">Correo Electrónico</label>
                                    <input class="form-control input-sm" id="correo" name="correo" type="email" placeholder="Introduzca el e-mail" required autocomplete="off" value="<?php echo $cmail; ?>" <?php echo $read; ?>>
                                </div>
                                
                                <div class="col-md-2">    
                                    <label for="lada">Lada</label>
                                    <input class="form-control input-sm soloN" id="lada" name="lada" type="text" placeholder="Introduzca lada" autocomplete="off" value="<?php echo $clada; ?>" <?php echo $read; ?>>
                                </div>
                                
                                <div class="col-md-2">  
                                	<label for="telefono">Teléfono</label>
                                    <input class="form-control input-sm soloN" id="telefono" name="telefono" type="text" placeholder="Introduzca el telefono" required autocomplete="off" value="<?php echo $ctelefono; ?>" <?php echo $read; ?>>
                                </div>
                                
                                <div class="col-md-2">  
                                	<label for="ext">Ext.</label>
                                    <input class="form-control input-sm soloN" id="ext" name="ext" type="text" placeholder="Introduzca la ext." autocomplete="off" value="<?php echo $cext; ?>" <?php echo $read; ?>>
                                </div>

                                <div class="col-md-2">  
                                	<label for="tipo">Tipo</label>
                                    <select class="form-control input-sm" id="tipotel" name="tipotel" required <?php echo $read; ?>>
                                        <?php echo $ctipotel; ?>
                                        <option value="CELULAR">	CELULAR	</option>
                                        <option value="HOGAR">		HOGAR	</option>
                                        <option value="OFICINA">	OFICINA	</option>
                                        <option value="RADIO">		RADIO	</option>
                                        <option value="RECADOS">	RECADOS	</option>
                                    </select>
                                </div>

                               <div class="col-md-12">&nbsp;</div>

                               <div class="col-md-7">
                                  <div class="row">
                                		<div class="col-md-8">
                                            <label for="destino">Destino <span style="color: #F71A00;">(FAVOR DE NO MODIFICAR EL NOMBRE DEL DESTINO, NI BORRAR EL MT)</span></label>
                                            <input class="form-control input-sm" id="destino" name="destino" type="text" placeholder="Introduzca el Destino" required  list="cid_destino" onkeypress="BuscaMT(1)" autocomplete="off"  onpaste="return false;" onblur="verificaDest(this); monedaP();" value="<?php echo $dest_cve; ?>" <?php echo $read; ?>>
                                            <datalist id="cid_destino"></datalist>
                                        </div>
                                        <div class="col-md-3">    
                                             <label for="mt">Clave MT</label>
                                             <input class="form-control input-sm" id="mt" name="mt" type="text" placeholder="Introduzca el MT" autocomplete="off" <?php echo $read; ?>>
                                        </div>
                                        <div class="col-md-1"><br>
                                            <button  data-toggle='tooltip' data-placement='bottom' title='BUSCAR MT' type="button" id="buscaMT" name="buscaMT" class="btn btn-success" onclick="BuscaMT(2)" <?php echo $read; ?>>
                                              <i class="fa fa-search fa-lg" aria-hidden="true"></i>
                                            </button>
                                        </div>
                               		</div>
                                    <div class="row">
                                         <div class="col-md-3">    
                                             <label for="fsalida">Fecha de Salida</label>
                                             <input class="form-control input-sm" type="date" name="fechas" id="fechas" value="<?php echo $fsalida; ?>" min="<?php echo date('Y-m-d')?>" <?php echo $read; ?>>
                                         </div>

                                         <div class="col-md-3">    
                                             <label for="pax">No. Pasajeros</label>
                                             <input class="form-control input-sm" id="pax" name="pax" type="number" placeholder="Total pasajeros" autocomplete="off" min="1" required value="<?php echo $numpax; ?>" <?php echo $read; ?>>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label for="comentarios">Comentarios</label>
                                            <textarea <?php echo $read; ?> class="form-control input-sm" name="comentarios" id="comentarios" style="max-height:90px; max-width:80%; width:80%; height:90px;text-transform: uppercase;" ><?php echo $observa; ?></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-5">
                                    <div class="row">
                                        <div class="col-md-6">    
                                             <label for="imptevta">Importe total del paquete</label>
                                             <input class="form-control input-sm" id="imptepqt" name="imptepqt" type="number" placeholder="TOTAL PAQUETE" autocomplete="off" required value="<?php echo $totpaquete; ?>" min="1" step="any" <?php echo $read; ?>>          
                                        </div>
                                        <div class="col-md-6" id="monedaPaquete" name="monedaPaquete" <?php echo $read; ?>>    
                                            <!-- MONEDA -->
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="anticipo">Importe del Anticipo</label>
                                            <input class="form-control input-sm imptePag" id="anticipo" name="anticipo" type="number" placeholder="TOTAL Anticipo" autocomplete="off" required value="<?php echo $impteapag; ?>" min="1" step="any" <?php echo $read; ?>>
                                        </div>
                                        <div class="col-md-6">
                                            <label>Moneda del Anticipo</label>                                        
                                            <select class="form-control input-sm imptePag" id="monpago" name="monpago" required <?php echo $read; ?>>
                                                <?php echo $moeda_A; ?>
                                                <option value="MXN">PESOS - MXN</option>
                                                <option value="USD">DÓLARES - USD</option>
                                            </select>
                                        </div>
                                        <div class="col-md-12">
                                            <label for="impteletra">Importe con Letra</label>
                                            <textarea  <?php echo $read; ?> readonly class="form-control input-sm" name="impteletra" id="impteletra" style="max-height:60px; max-width:100%; width:100%; height:60px;" ><?php echo $letras; ?></textarea>
                                        </div>
                                    </div>
                                </div>
                               <div class="col-md-12" align="center">
                               		<?php echo $boton; ?>
                                  <br><br> <br><br>
                            	</div>
							</form>
					</div>
				</div>
			</div>
<?php 
    }else{
?>      <br><br>
        <div class="col-md-2">&nbsp;</div>
        <div class="alert alert-danger col-md-8">
          <strong>¡ATENCIÓN!</strong> No hay tipo de cambio cargado, comuníquese con el depto. de ingresos.
        </div>
        <div class="col-md-2">&nbsp;</div>
<?php
    }
?>		</main>
	</div>

        <footer class="closed">
    
                <?php include($_SERVER['DOCUMENT_ROOT'].'/php/footer2.php') ?>
    
        </footer>

	</body>

</html>

