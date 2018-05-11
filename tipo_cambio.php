<?php 
	include($_SERVER['DOCUMENT_ROOT'].'/php/session2.php');
    include('php/conexion.php');
    $fechaH   = ddmmmaaaa22(date('Y-m-d'));
    $hoy      = date('Y-m-d');
    $consulta = "SELECT * FROM  `tcambio` WHERE fecha = '$hoy'";
    $res      = mysqli_query($conx, $consulta);
    $row      = mysqli_fetch_assoc($res);
    if(mysqli_num_rows($res)>0){
        $tc       = number_format($row['tcambio'],2);
    }else{
        $tc       = '0.00';
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
                  <div class="tit_caja1"><i class="fa fa-home icon-home-route"></i>Inicio <i class="fa fa-angle-right icon-arrow-route"></i>TIPO DE CAMBIO DEL DÍA
                  </div>
                  <div class="work-area-box"><br>
                     <div class="col-md-12">
                        <form method="post" action="php/guarda_tc.php">
                            <div class="col-md-4"></div>
                            <div class="col-md-4">
                              <div class="row">
                                <div class="col-md-12 subtitulo-azul">TIPO DE CAMBIO <?php echo $fechaH; ?></div>
                                <div class="col-md-12 subtitulo-rosa" style="text-align: center;">
                                    ACTUAL: $ <?php echo $tc; ?>
                                </div>
                                <div class="col-md-12">&nbsp;</div>
                                <div class="col-md-6">
                                    <label for="tipoC">INGRESE TIPO DE CAMBIO</label>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" autofocus required autocomplete="off" class="soloN form-control input-sm " id="tipoC" name="tipoC" placeholder="Ingrese TC">
                                </div>
                                <div class="col-md-12">&nbsp;</div>
                                <div class="col-md-12" style="text-align: center;">
                                    <button type="submit" class="btn btn-success">GUARDAR</button>
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

