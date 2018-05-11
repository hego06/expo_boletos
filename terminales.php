<?php 
	include($_SERVER['DOCUMENT_ROOT'].'/php/session2.php');
  include('php/conexion.php');

  $sql  = "SELECT * FROM terminalpv WHERE activo = '0'";
  $res  = mysqli_query($conx, $sql);
  $opt  = "<option value='' selected>SELECCIONE TERMINAL</option>";
  while($row = mysqli_fetch_assoc($res)){
    $cid_tpv    = $row['cid_tpv'];
    $terminalpv = $row['terminalpv'];
    $opt.= "<option value='$cid_tpv'>$cid_tpv → $terminalpv</option>";
  }
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
                  <div class="tit_caja1"><i class="fa fa-home icon-home-route"></i>Inicio <i class="fa fa-angle-right icon-arrow-route"></i>ACTIVAR TERMINALES
                  </div>
                  <div class="work-area-box"><br>
                     <div class="col-md-12">
                        <form method="post" action="php/activa_terminal.php">
                            <div class="col-md-4"></div>
                            <div class="col-md-4">
                              <div class="row">
                                <div class="col-md-12 subtitulo-azul">SELECCIONE LA TERMINAL QUE DESEA ACTIVAR</div>
                                <div class="col-md-12">&nbsp;</div>
                                <div class="col-md-12">
                                    <label for="activaTPV">TERMINAL</label>
                                     <select name="activaTPV" class="form-control input-sm ">
                                        <?php echo $opt; ?>
                                     </select> 
                                </div>
                                <div class="col-md-12">&nbsp;</div>
                                <div class="col-md-12" style="text-align: center;">
                                    <button type="submit" class="btn btn-success">ACTIVAR</button><br><br>
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

