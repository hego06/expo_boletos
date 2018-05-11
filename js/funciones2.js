$(document).ready(function() {
	//SOLO NÚMEROS
    $('[data-toggle="tooltip"]').tooltip(); 

	$(".soloN").keydown(function (e)  {

		if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 || (e.keyCode == 65 && e.ctrlKey === true) ||(e.keyCode >= 35 && e.keyCode <= 39)) {

		 		return;

			}

		if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {

		    e.preventDefault();

		}

	});

	$(".g_expe").click(function (e) {
		var folio 	= $("#folexpo").text();
		$.ajax({
			type: "GET",
			url: "php/expediente.php",
			data: "folio="+folio,
			dataType: "html",
			success: function(data){
				if(data == 'HECHO'){
					alert('EXPEDIENTE GENERADO');
					location.reload();
				}else{
					alert('ERROR AL GENERAR EXPEDIENTE, PONGASE EN CONTACTO CON EL ADMINISTRADOR DEL SISTEMA.');
					console.log(data);
				}
			}	
		});
	});

	$("#moneda_e").change(function (e){
		var m_efectivo 	= $("#moneda_e").val();
		if(m_efectivo == 'MXN'){
			$("#importeUSD").attr("hidden", false); 			
		}
		if(m_efectivo == 'USD' || m_efectivo == ''){
			$("#importeUSD").attr("hidden", true); 			
		}
	});


	$("#imptepag_e").keyup(function (e){
		var m_efectivo 	= $("#moneda_e").val();
		var monto 		= $(this).val();
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


	$("#imprime").click(function (e) {
		var folio 	= $("#folioRecibo").val();
		window.location = ("php/recibo.php?"+folio);
	});



});

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

function monedaP(){
	var destino 	= $('#destino').val();
	if(destino != ''){
		var cortar 		= destino.split('§');
		var cdestpack 	= cortar[0].trim();
		var cid 		= cortar[1].trim();
		var cid_destino	= cid.substring(2,9);
		console.log(cid_destino);
		$("#monedaPaquete").empty();

		if(cid_destino >= 60000 && cid_destino <= 62999){
			$("#monedaPaquete").append("<label>Moneda del paquete</label><select class='form-control input-sm'  name='monedapqt' id='monedapqt' required><option value='USD'>DÓLARES - USD</option><option value='MXN'>PESOS - MXN</option></select>");
			console.log('cruc');
		}
		else if(cid_destino < 40100 && cid_destino >= 40000){
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
function verificaLista(input, campo, iddata ){
	var valor = input.value;
	if(valor.length == 0){
		input.setCustomValidity('Ingrese ' + campo);
	}
	else{
		iddata = '#' + iddata + ' .' + iddata;
		//Si el campo no está vacío, procedemos a validar la información
		//Guardamos el valor de todos los datos presentes en el datalist en un arreglo temporal
		var cis = document.querySelectorAll(iddata);
		//Leemos cuantos elementos incluye el arreglo cis
		var n = cis.length;
		//Esta es una variable temporal que se usará en el análisis del arreglo cis
		var valorT;
		//Es una variable bandera que indicará si el datos suministrado está en la lista
		var bandera = 0;
		//Recorremos cis
		for(var i = 0; i < n; i++){
		//Guardamos el iésimo valor de cis en la variable temporal valorT
			valorT = cis[i].value;
			//Comparamos el valor suministrado con valorT
			if(valor == valorT){
				bandera=1;
				i = n;
				break;
			}      
		}
		if(bandera==1){
			input.setCustomValidity('');
		}
		else{
			input.setCustomValidity(campo + ' ' + valor + ' no existe.');
		}
	}	
}


function reporteVtas(){
	var fecha1 	= $("#fecha1").val();
	var fecha2 	= $("#fecha2").val();
	var ejec 	= $("#ejecutivo").val();
	var cadena 	= "f1="+fecha1+"&f2="+fecha2+"&ejec="+ejec+"&tipo=N";
	//alert(cadena);
	$.ajax({
		type: "GET",
		url: "php/reporteVtas.php",
		data: cadena,
		dataType: "html",
		success: function(data){
			$("#registrosVtas").empty();
			$("#registrosVtas").append(data);
		}
	});
}

function exportaVtas(tipo){

	var fecha1 = $("#fecha1").val();

	var fecha2 = $("#fecha2").val();

	var ejec 	= $("#ejecutivo").val();

	var cadena 	= "f1="+fecha1+"&f2="+fecha2+"&ejec="+ejec+"&tipo="+tipo;

	window.location=('php/reporteVtas.php?'+cadena);

}

function reportePqts(){
	var fecha1 	= $("#fecha1").val();
	var fecha2 	= $("#fecha2").val();
	var ejec 	= $("#ejecutivo").val();
	var cadena 	= "f1="+fecha1+"&f2="+fecha2+"&ejec="+ejec+"&tipo=N";
	//alert(cadena);
	$.ajax({
		type: "GET",
		url: "php/reportePqts.php",
		data: cadena,
		dataType: "html",
		success: function(data){
			$("#registrosPqts").empty();
			$("#registrosPqts").append(data);
		}
	});
}

function exportaPqts(tipo){

	var fecha1 = $("#fecha1").val();

	var fecha2 = $("#fecha2").val();

	var ejec 	= $("#ejecutivo").val();

	var cadena 	= "f1="+fecha1+"&f2="+fecha2+"&ejec="+ejec+"&tipo="+tipo;

	window.location=('php/reportePqts.php?'+cadena);

}