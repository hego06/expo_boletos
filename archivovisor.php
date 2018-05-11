<?php 
	date_default_timezone_set('America/Mexico_City');
	include($_SERVER['DOCUMENT_ROOT'].'/php/session.php');
	include('php/conexion.php');
	include($_SERVER['DOCUMENT_ROOT'].'/php/cifraget.php');	
	
	if($_GET){
		decode_get2($_SERVER["REQUEST_URI"]);  
		$folexpo	= $_GET['folio'];
 	}
?>
<html>
<head>
	<meta http-equiv="pragma" content="no-cache">
	<meta http-equiv="cache-control" content="no-cache">
	<script src="js/visor.js"></script>
    
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <script src="https://<?php echo $_SERVER['SERVER_NAME']?>/js/funciones.js"></script>
    
    <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0" />
	<?php include ($_SERVER["DOCUMENT_ROOT"].'/php/head.php');?>
			
<title>.::. Archivos .::.</title>
</head>

<body>

	<div class="full-height header-background-main">
		
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

		<script src="js/funciones.js"></script>
        
        <main class="dashboard-full-size" onclick="openNav('')">

        <div class="row">

            <div class="col-md-6 work-container">

                <div class="tit_caja1"><i class="fa fa-home icon-home-route"></i>Inicio <i class="fa fa-angle-right icon-arrow-route"></i> DOCUMENTOS</div>

                <div class="work-area-box"><br>
                	
                    <div class="row">
                        <div class="panel panel-danger class">
                            <div class="panel-heading subtitulo"><strong>Solo archivos PDF</strong></div>
                            <div class="panel-body">
                                <form action="archivo_sube.php" method="post" enctype="multipart/form-data">
                                    <table width="100%">
                                        <tr>
                                            <td valign="top" width="50%">
                                                <input type="file" name="archivo[]" id="archivo[]" class="btn btn-warning"><br><br>
                                    			<?php 
													if($_SESSION['dep'] == 14 || $_SESSION['dep'] == 13){
														echo "<input type='checkbox' name='pago' id='pago' > Comprobante de pago.";
													}
                                    			?>
                                                <input type="hidden" name="folexpo" id="folexpo" value="<?php echo $folexpo ?>" >
                                            </td>
                                            <td valign="top" align="center" width="50%">
                                                <input type="submit" value="Guardar Archivo" class="btn btn-primary" >
                                            </td>
                                        </tr>
                                    </table>
                                </form> 
                            </div>
                        </div>    
                        <div class="panel panel-info class">    
                            <div class="panel-heading subtitulo"><strong>Dar clic en el nombre del archivo para visualizarlo.</strong></div>
                                <table class="table" width="100%">
                                    <tr>
                                        <td valign="top" width="20%">
                                            <table width="100%" cellpadding="5" id="files">
                                                <tr>
                                                    <th>
                                                        Archivos 
                                                    </th>
                                                </tr>
                                                    <?php 
                                                    $x	= 1;
                                                    $z	= 0;
                                                        while($z == 0){
                                                            $file	= $folexpo."_0".$x.".pdf";
                                                            $file2	= $folexpo."_0".$x."_pago.pdf";
                                                            if(file_exists("pdfs/".$file)){
                                                                echo "<tr><td><a href='javascript:visor(\"$file\")'>".$file."</a></td></tr>";
                                                                $x++;
                                                            }
                                                            elseif(file_exists("pdfs/".$file2)){
                                                                echo "<tr><td><a href='javascript:visor(\"$file2\")'>".$file2."</a></td></tr>";
                                                                $x++;
                                                            }
                                                            else{
                                                                $z = 1;
                                                            }
                                                        }		
                                
                                                    ?>
                                            </table>			
                                        </td>
                                        <td width="15%">&nbsp;</td>
                                        <td width="65%">
                                            <div id="vista" style="width:100%">
                                
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
						</div> 
                	</div> 
				</div>
			</div>
		</div>
	</div>
	<footer class="closed">
    
			<?php include($_SERVER['DOCUMENT_ROOT'].'/php/footer2.php') ?>
            
	</footer>
</body>
</html>