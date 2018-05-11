<?php 
	include($_SERVER['DOCUMENT_ROOT'].'/php/session2.php');
  include('php/conexion.php');
  if($_GET){
    decode_get2($_SERVER["REQUEST_URI"]);  
    $cid_solicitud  = $_GET['id'];
    $recibo         = $_GET['reci'];

    $detalles   ="SELECT * FROM dtarjetab INNER JOIN recibodig ON dtarjetab.cid_solicitud = recibodig.cid_solici WHERE dtarjetab.cid_solicitud= '".$cid_solicitud."' AND recibodig.cancelado = '0' ";
    $result = mysqli_query($conx, $detalles);
    if (mysqli_num_rows($result) > 0 ) {
        $row = mysqli_fetch_assoc($result);
        
        $cid_expediente = $row['cid_expediente'];
        $codigo         = $row['codigo'];
        $autorizacion   = $row['auttarj'];
        $valida         = $row['valido'];
        $titular        = $row['titular'];
        $tarjeta        = $row['notarjeta'];
        $recibo         = $row['folio'];
    }
  }
  if(file_exists("doctosop/$cid_solicitud.pdf")){
      $file   = "doctosop/$cid_solicitud.pdf";
      $exist  = 'S';
  }
  else{
    $file = "doctosop/inicio_mt.pdf";
    $exist  = 'N';      
  }
?>
<html>
	<head>
        <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0" />    
		<?php include ($_SERVER["DOCUMENT_ROOT"].'/php/head.php');?>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script src="js/funciones.js"></script>
        <script>
            function reemplaza(){
                var existe  = document.getElementById('exist').value;
                    if(existe == 'S'){
                        var rem = confirm("Ya hay un documento cargado, éste será reemplazado");
                        if(rem == false){
                            return false;
                        }
                    }
            }
</script>
	</head>
	<body>
      <div class="full-height header-background-main"> 
            <div class="row">
               <div class="col-md-12 work-container">
                  <div class="tit_caja1"><i class="fa fa-home icon-home-route"></i>Inicio <i class="fa fa-angle-right icon-arrow-route"></i>DOCUMENTOS DE SOPORTE
                  </div>
                  <div class="work-area-box"><br>
                     <div class="col-md-12">
                        <form method="post" action="doctosop_sube.php" enctype="multipart/form-data" onSubmit="return reemplaza()">
                            <input type="hidden" value="<?php echo $cid_solicitud;?>" name="cid_solicitud" id="cid_solicitud">
                            <input type="hidden" value="<?php echo $recibo;?>" name="recibo" id="recibo">
                            <input type="hidden" value="<?php echo $exist;?>" name="exist" id="exist">                        
                            <div class="col-md-12">
                                <div class="row">
                                    <table class="table table-condensed">
                                        <tr>
                                            <th>Expediente</th>
                                            <th>Recibo</th>
                                        </tr>
                                        <tr>
                                            <td><?php echo $cid_expediente?></td>
                                            <td><?php echo $recibo?></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" class="text-danger" style="font-weight: bolder;">Solo se permiten archivos con extensión .PDF</td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <input type="file" class="form-control input-sm" name="archivo[]" id="archivo[]">
                                            </td>
                                            <td>
                                                <button type="submit" data-toggle='tooltip' data-placement='bottom' title='CARGAR VOUCHER'  name="action" id="action" class="btn btn-success">Cargar Voucher</button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">
                                                <iframe id='visualizar' name='visualizar' scrolling='auto' frameborder='2' style='width:100%' src='<?php echo $file;?>' height='380'></iframe>       
                                            </td>
                                        </tr>   
                                    </table>          
                                </div>
                            </div>    
                        </form>
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