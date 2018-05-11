$(document).ready(function() {
	//SOLO NÚMEROS
    $('[data-toggle="tooltip"]').tooltip(); 


//SOLO NÚMEROS
	$(".soloN").keydown(function (e)  { //OBJETOS CON CLASE soloN
		if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 || (e.keyCode == 65 && e.ctrlKey === true) ||(e.keyCode >= 35 && e.keyCode <= 39)) {
		 		return;
			}
		if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
		    e.preventDefault();
		}
	});

//VALIDA EMAIL
$(".mail").blur(function (e)  { //Objetos con clase mail
	var email 	= $(this).val();
	if(email.length > 0){
	    expr = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	    if (!expr.test(email) ){
			this.setCustomValidity("INGRESE UNA DIRECCIÓN DE CORREO CORRECTA");
			return false;
		}
	}
});

/***
- Solo se puede hacer una liga por expediente, la cual se envía al correo que proporcionó el cliente al inicio del registro.
- Expediente: Puede hacer pagos en expo.
- Liga Bancaria: No se pueden hacer pagos en expo.
***/


//GENERA EXPEDIENTE
	$(".g_expe").click(function (e) { //Objeto con clase g_expe
		var folio 	= $("#folexpo").text(); //Obtenemos folio de expo
		//Preguntamos si desea generar expediente
		var confirma = confirm("SE GENERARÁ EXPEDIENTE \n¿DESEA CONTINUAR? *ESTE PROCESO NO PODRÁ SER REVERTIDO*");
		if(confirma){ //acepta
			//envía datos
			$.ajax({
				type: "GET", //método GET
				url: "php/expediente.php",//Archivo que recibe los datos
				data: "folio="+folio, //Datos enviados (folexpo)
				dataType: "html", 
				success: function(data){
					if(data == 'HECHO'){ //SI GENERÓ EXPEDIENTE
						alert('EXPEDIENTE GENERADO'); //MENSAJE
						location.reload(); //RECARGA LA PÁGINA
					}else{ //ERROR AL GENERAR EXPEDIENTE
						alert('ERROR AL GENERAR EXPEDIENTE, PONGASE EN CONTACTO CON EL ADMINISTRADOR DEL SISTEMA.');
						//MUESTRA ERROR EN CONSOLA
						console.log(data);
					}
				}	
			});
		}else{ //No acepta
			return;
		}
	});

//Genera Liga Bancaria
	$(".g_liga").click(function (e) {//Objeto con clase g_liga
		var folio 	= $("#folexpo").text(); //Obtenemos folexpo
		var email_	= $("#email_").text(); //Obtenemos email
		//MENSAJE PARA CONFIRMAR
		var confirma = confirm("SE ENVIARÁ LIGA DE PAGO BANCARIA AL CORREO "+email_+"\n¿DESEA CONTINUAR?");
		if(confirma){
			$.ajax({
				type: "GET",
				url: "php/ligaB.php",
				data: "folio="+folio,
				dataType: "html",
				success: function(data){
					if(data == 'HECHO'){
						alert('LIGA BANCARIA ENVÍADA');
						location.reload();
					}else{
						alert('ERROR AL ENVIAR LIGA BANCARIA, PONGASE EN CONTACTO CON EL ADMINISTRADOR DEL SISTEMA.');
						console.log(data);
					}
				}	
			});
		}else{
			return;
		}
	});

//MUESTRA CONVERSIÓN DE IMPORTE A PAGAR (EFECTIVO)

/* La conversión solo es MXN → USD */
	$("#moneda_e").change(function (e){
		var m_efectivo 	= $("#moneda_e").val(); //Moneda del pago
		if(m_efectivo == 'MXN'){ //PESOS
			$("#importeUSD").attr("hidden", false); //MUESTRA INPUT PARA CONVERSIÓN
		}
		if(m_efectivo == 'USD' || m_efectivo == ''){ //DÓLARES O VACÍO
			$("#importeUSD").attr("hidden", true); 	//OCULTA INPUT PARA CONVERSIÓN
		}
	});

//Hace conversión MXN → USD  en pago de EFECTIVO
	$("#imptepag_e").keyup(function (e){ 
		var m_efectivo 	= $("#moneda_e").val(); //Moneda del pago
		var monto 		= $(this).val(); //Monto a pagar
		if(monto != ''){ 
			if(m_efectivo == 'MXN'){
				var tc 		= $("#tc_e").text();
					tc 		= parseFloat(tc);
					monto 	= parseFloat(monto);
				var total	= monto/tc;
					total 	= total.toFixed(2);
				if(isNaN(monto)){
					monto 	= 0;
				}
				if(isNaN(total)){
					total = 0;
				}
				$("#impte_usd").val(total);
				//console.log(total);
			}
			$.ajax({
				type: "GET",
				url: "php/letranumeros.php",
				data: "anticipo="+monto+"&monpago="+m_efectivo,
				dataType: "html",
				success: function(data){
					$('#letras_e').text(data+' '+m_efectivo);
					//console.log(data);
				}
			});
		}else{
			$('#letras_e').text('');
			$("#impte_usd").val('0');
		}
	});

	$(".imptePag").bind('keyup keypress change',function (e) {
		var anticipo	= $("#anticipo").val();
		var destino 	= $("#destino").val();
		if(anticipo!='' || destino !=''){
			var monpago		= $("#monpago").val();
			$.ajax({
				type: "GET",
				url: "php/letranumeros.php",
				data: "anticipo="+anticipo+"&monpago="+monpago,
				dataType: "html",
				success: function(data){
					$('#impteletra').text(data+' '+monpago);
					console.log(data);
				}
			});
		}else{
			alert('PRIMERO INGRESE UN DESTINO');
			$("#destino").focus();
			$("#impteletra").text('');
			$("#anticipo").empty();
			return false;
		}
	});


	$(".importe_t").bind('keyup keypress change',function (e) {
		var importe_t	= $("#importe_t").val();
		var monpago 	= $("#moneda").val();
		$.ajax({
			type: "GET",
			url: "php/letranumeros.php",
			data: "anticipo="+importe_t+"&monpago="+monpago,
			dataType: "html",
			success: function(data){
				$('#impteletra').text(data+' '+monpago);
				console.log(data);
			}
		});
	});


	$("#imprime").click(function (e) {
		var folio 	= $("#folioRecibo").val();
		window.location = ("php/recibo.php?"+folio);
	});



});

function reporteEjec(){
	var fecha1 	= $("#fecha1").val();
	var fecha2 	= $("#fecha2").val();
	var ejec 	= $("#ejecutivo").val();
	var cadena 	= "f1="+fecha1+"&f2="+fecha2+"&ejec="+ejec+"&tipo=N";
	$.ajax({
		type: "GET",
		url: "php/reporteEjec.php",
		data: cadena,
		dataType: "html",
		success: function(data){
			$("#registrosEjec").empty();
			$("#registrosEjec").append(data);
		}
	});
}



function exporta(tipo){

	var fecha1 = $("#fecha1").val();

	var fecha2 = $("#fecha2").val();

	var ejec 	= $("#ejecutivo").val();

	var cadena 	= "f1="+fecha1+"&f2="+fecha2+"&ejec="+ejec+"&tipo="+tipo;

	window.location=('php/reporteEjec.php?'+cadena);

}

function abrirVentana(pagina,titulo){
	window.open(pagina,titulo,'width=600,height=580, menubar=no,scrollbars=no,toolbar=no,location=no,directories=no,resizable=no,top=0,left=0');
	self.focus( );
}

function solicitudes(combo){

	if(combo == ''){
		var tipo 	= '';
	}else{
		var tipo 	= $("#tipo").val();
	}
	var fecha1 	= $("#fecha1").val();

	var fecha2 	= $("#fecha2").val();

	var folio 	= $("#folio").val();

	var expe 	= $("#expediente").val();

	var cliente	= $("#cliente").val();


	var cadena 	= "f1="+fecha1+"&f2="+fecha2+"&folio="+folio+"&expe="+expe+"&cliente="+cliente+"&tipo="+tipo;

	$.ajax({

		type: "GET",

		url: "php/consulta_soli.php",

		data: cadena,

		dataType: "html",

		success: function(data){

			$("#consulta_soli").empty();

			$("#consulta_soli").append(data);

			//alert(data);

		}

	});

}

//BUSCA MT 
function BuscaMT(tipo){
	var mt;
	var destino;
	if(tipo == 2){ //BUSCA CLAVE MT
		mt = $("#mt").val();
		if(mt!=''){
			$.ajax({
				type: "GET",
				url: "php/consulta_dest.php",
				data: "id_destino="+mt+"&tipo="+tipo,
				dataType: "html",
				success: function(data){
					if(data == 'NO'){
						alert('MT NO ENCONTRADO');
						$("#destino").val('');
						$("#mt").val('');
						$("#mt").focus();
					}else{
						$("#destino").focus();
						$("#destino").val(data);
					}
						console.log(data);
				}
			});
		}else{
			alert('INGRESE CLAVE MT PARA REALIZAR LA BÚSQUEDA DEL DESTINO');
			$("#mt").focus();
		}
	}
	if(tipo == 1){ //BUSCA DESTINO INGRESADO 
		destino = $("#destino").val();
		$.ajax({
			type: "GET",
			url: "php/consulta_dest.php",
			data: "destino="+destino+"&tipo="+tipo,
			dataType: "html",
			success: function(data){
				$("#cid_destino").empty();
				$("#cid_destino").append(data);
			}
		});
	}
}

//MONEDA DEL PAQUETE
function monedaP(){
	var destino 	= $('#destino').val();
	if(destino != '' && destino.indexOf('§') != -1){ //BUSCA § EN CADENA
		var cortar 		= destino.split('§');
		var cdestpack 	= cortar[0].trim();
		var cid 		= cortar[1].trim();
		var cid_destino	= cid.substring(2,7);
		console.log(cid_destino);
		$("#monedaPaquete").empty();

		if(cid_destino >= 60000 && cid_destino <= 62999){
			$("#monedaPaquete").append("<label>Moneda del paquete</label><select class='form-control input-sm'  name='monedapqt' id='monedapqt' required><option value='USD'>DÓLARES - USD</option><option value='MXN'>PESOS - MXN</option></select>");
			console.log('cruc');
		}
		else if(cid_destino <= 40499 && cid_destino >= 40000){ //RANGO MT PESOS
			$("#monedaPaquete").append("<label>Moneda del paquete</label><input  class='form-control input-sm' type='hidden' id='monedapqt' name='monedapqt' READONLY value='MXN'><input  class='form-control input-sm' type='text' id='monedapqt2' name='monedapqt2' READONLY value='PESOS - MXN'>");
			console.log('mex');
		}
		else{
			$("#monedaPaquete").append("<label>Moneda del paquete</label><input class='form-control input-sm'  type='text' id='monedapqt2' name='monedapqt2' READONLY value='DÓLARES - USD'><input  class='form-control input-sm' type='hidden' id='monedapqt' name='monedapqt' READONLY value='USD'>");
			console.log('other');

		}
	}
}


function CargosB(terminal){
	$.ajax({
		type: "GET",
		url: "php/CargosB.php",
		data: "terminal="+terminal,
		dataType: "html",
		success: function(data){
			$("#cargos").empty();
			$("#cargos").append(data);
			bancoA(terminal);
			datosB(terminal);
		}
	});
}

function bancoA(terminal){
	$.ajax({
		type: "GET",
		url: "php/bancoA.php",
		data: "terminal="+terminal,
		dataType: "html",
		success: function(data){
			$("#bancoaplic").empty();
			$("#bancoaplic").append(data);
		}
	});
}
//MUESTRA DATOS BANCARIOS
function datosB(terminal){
	$.ajax({
		type: "GET",
		url: "php/datosB.php",
		data: "terminal="+terminal,
		dataType: "html",
		success: function(data){
			$("#datosBanco").empty();
			$("#datosBanco").append(data);
			$("#datosBanco").show('slow');
		}
	});
}

function voucher(){
	var recibo		= $('#recibo').val();
	var expe		= $('#expediente').val();
	var solicitud	= $('#solicitud').val();
	var fecha1		= $('#fecha1').val();
	var fecha2		= $('#fecha2').val();
	var enviar 		= "expe="+expe+"&recibo="+recibo+"&solicitud="+solicitud+"&fecha1="+fecha1+"&fecha2="+fecha2;
	$.ajax({
		type: "GET",
		url: "php/consultav.php",
		data: enviar,
		dataType: "html",
		success: function(data){
			$("#voucher_").empty();
			$("#voucher_").append(data);
		}
	});
}

//GUARDA COMO COTIZACIÓN
function guardaCotiza(){
	if(document.getElementById('cotiza').checked == true){
		var confirma = confirm('Este registro será guardado como cotización, ¿desea continuar?');
		if(confirma == false){
			document.getElementById('cotiza').checked = false;
			return false;
		}
	}
}

//CANCELA RECIBOS
function cancelaR(recibo,folexpo,solicitud){
	var answer = confirm("Se cancelará el recibo con\n»No. Folio:  "+recibo+"\n\n×Este proceso no se puede revertir.×\n¿Desea continuar?")
	if (answer){
		var motivo	= prompt("Motivo de cancelación(Obligatorio): ");
		if(motivo!=undefined && motivo){
			var datos = "folexpo="+folexpo+"&recibo="+recibo+"&motivo="+motivo+"&solicitud="+solicitud;
			window.location=('php/cancela_recibo.php?'+datos);
		}
	}
}


//MUESTRA UN PDF
function visualiza(recibo){
	$('#modalArchivo .modal-body').empty();
	$('#modalArchivo .modal-body').append('<iframe frameborder="1" transparency="transparency"  width="100%" style="height: 480px;" src="recibodig/'+recibo+'.pdf">');
	$('#modalArchivo').modal('show');
}


function verificaDest(input){
	var destino 	= (input.value).toUpperCase();
		xmlhttp 	= new XMLHttpRequest();
	if(destino != '' && destino.indexOf('§') != -1){ //BUSCA § EN CADENA
		var cortar 		= destino.split('§');
		var cid 		= cortar[1].trim();
		if(cid.length >= 7){
		    xmlhttp.onreadystatechange=function() {
			    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
			        if(xmlhttp.responseText==="EXISTE"){
			            input.setCustomValidity('');
			        }
			        else{
			        	console.log(xmlhttp.responseText);
			            input.setCustomValidity("EL DESTINO "+destino+" NO EXISTE.");
			        }
			    }
		    }
		    xmlhttp.open("POST", "php/interactivo.php", true);
		    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		    xmlhttp.send("valor="+destino);
		}else{
	        input.setCustomValidity("INGRESE UN DESTINO VÁLIDO");
		}
	}else{
		 input.setCustomValidity("INGRESE UN DESTINO VÁLIDO");
    }
}