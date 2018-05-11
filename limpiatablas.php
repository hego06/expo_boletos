<?php 
	include($_SERVER['DOCUMENT_ROOT'].'/php/session2.php');
?>
<html>
	<head>
        <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0" />    
		<?php include ($_SERVER["DOCUMENT_ROOT"].'/php/head.php');?>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script src="js/funciones.js"></script>
	</head>
	<body>
      <div class="full-height header-background-main">
		<?php include ($_SERVER["DOCUMENT_ROOT"].'/php/topmenu.php');?>
      <?php include ($_SERVER["DOCUMENT_ROOT"].'/php/barralateral.php');?>      
         <main class="dashboard-full-size" onclick="openNav('')">
            <div class="row">
               <div class="col-md-12 work-container">
                  <div class="tit_caja1"><i class="fa fa-home icon-home-route"></i>Inicio <i class="fa fa-angle-right icon-arrow-route"></i>LIMPIAR TABLAS
                  </div>
                  <div class="work-area-box"><br>
                     <div class="col-md-12">
                        <form method="post" action="php/limpia_confirmar.php">
                            <div class="col-md-4"></div>
                            <div class="col-md-4">
                              <div class="row">
                                <div class="col-md-12 subtitulo-azul">ACCESO</div>
                                <div class="col-md-12">&nbsp;</div>
                                <div class="col-md-6">
                                    <label for="tipoC">CONTRASEÑA</label>
                                </div>
                                <div class="col-md-6">
                                    <input type="password" autofocus required autocomplete="off" class="form-control input-sm " id="clave" name="clave" placeholder="CONTRASEÑA"><br>
                                </div>
                                <div class="col-md-12">&nbsp;</div>
                                <div class="col-md-12" style="text-align: center;">
                                    <button type="submit" class="btn btn-success">INGRESAR</button><br><br>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-4"></div>  
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

