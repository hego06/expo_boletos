<?php 
	include($_SERVER['DOCUMENT_ROOT'].'/php/session2.php');
?>
<html>
	<head>
        <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0" />    
		<?php include ($_SERVER["DOCUMENT_ROOT"].'/php/head.php');?>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script src="js/funciones.js"></script>
        <script>
        function Todas(){
            if (document.getElementById('todas').checked==true){
                for (i=1; i<=13; i++){
                    document.getElementById('check'+i).checked=true;
                }
            }else{
                for (i=1; i<=13; i++){
                    document.getElementById('check'+i).checked=false;
                }
            }
        }

        function eliminar(){
            var elimina = confirm("Al limpiar la(s) tabla(s) seleccionada(s) se perderá todo su contenido. \n ¿Desea continuar?");
            if (elimina){}
            else{
                event.returnValue=false;
            }
        }
</script>
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
                        <form method="post" action="php/limpia_borra.php" onSubmit="javascript:eliminar()">
                            <div class="col-md-4"></div>
                            <div class="col-md-4">
                              <div class="row">
                                <div class="col-md-12 subtitulo-azul">LIMPIAR TABLAS</div>
                                <div class="col-md-12">&nbsp;</div>
                                <div class="col-md-12 subtitulo-rosa">Seleccione la(s) tabla(s) que desea limpiar.</div>
                                <div class="col-md-12">&nbsp;</div>
                                <div class="col-md-12">
                                    <table class="table table-striped">
                                        <tr>
                                            <td>
                                                <input type="checkbox" name="todas" id="todas" onChange="Todas()" >
                                            </td>
                                            <th>TODAS LAS TABLAS</th>
                                        </tr>
                                        <tr>
                                            <td>
                                                <input type="checkbox" name="check1" value="confirmacion" id="check1">
                                            </td>
                                            <td>CONFIRMACIÓN</td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <input type="checkbox"  value="defectivo" name="check2" id="check2">
                                            </td>
                                            <td>DEFECTIVO</td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <input type="checkbox" value="dtarjetab" name="check3" id="check3">
                                            </td>
                                            <td>DTARJETAB</td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <input type="checkbox"  value="expediente" name="check4" id="check4">
                                            </td>
                                            <td>EXPEDIENTE</td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <input type="checkbox" name="check5" value="expo_mov" id="check5">
                                            </td>
                                            <td>EXPO_MOV</td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <input type="checkbox" name="check6" value="pasajeros" id="check6">
                                            </td>
                                            <td>PASAJEROS</td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <input type="checkbox" name="check7" value="recibodig" id="check7">
                                            </td>
                                            <td>RECIBODIG</td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <input type="checkbox" name="check8" value="solicitudes" id="check8">
                                            </td>
                                            <td>SOLICITUDES</td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <input type="checkbox" name="check9" value="tcambio" id="check9">
                                            </td>
                                            <td>TCAMBIO</td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <input type="checkbox" name="check10" value="tclientes" id="check10">
                                            </td>
                                            <td>TCLIENTES</td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <input type="checkbox" name="check11" value="tfuncionario" id="check11">
                                            </td>
                                            <td>TFUNCIONARIO</td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <input type="checkbox" name="check12"  value="ventas" id="check12">
                                            </td>
                                            <td>VENTAS</td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <input type="checkbox" name="check13" value="vtasoperador" id="check13">
                                            </td>
                                            <td>VTASOPERADOR</td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-12" style="text-align: center;">
                                    <button type="submit" class="btn btn-success">LIMPIAR</button>
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

