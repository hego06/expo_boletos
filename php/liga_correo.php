<?php
	$mensaje = "<html>
	<head>
		<meta charset='UTF-8'>
		<title>Documento sin título</title>
	</head>
	<body>
		<table width='100%' border='0' cellpadding='10' cellspacing='10' bgcolor='#E4F4FA'>
			<tbody>
				<tr>
					<td>	  
						<table width='790' border='0' align='center' cellpadding='5' cellspacing='2' style='background:#FFF'>
							<tbody>
								<tr>
									<td width='322'>
										<img src='https://cafe.megatravel.com.mx/src/logo.png' alt='Mega Travel' width='280'>
									</td>
									<td width='210'>&nbsp;</td>
									<td width='233' align='right' style='font-family:Helvetica Neue,Helvetica,Arial,sans-serif;font-size:11px;color:#333'>Av. Chapultepec No. 536, Piso 7 <br>Col. Roma Norte. Del. Cuauhtémoc
										<br>C.P. 06700 Ciudad de México. México.
										<br><br><strong>$fecha_</strong>
									</td>
								</tr>
								<tr>
									<td colspan='3' align='center' style='font-family:Helvetica Neue,Helvetica,Arial,sans-serif;font-size:14px;color:#555;line-height:150%'><H1> PAGO	EN LÍNEA</H1></td>
								</tr>
								<tr>
									<td colspan='3'>
										<p style='font-family:Helvetica Neue,Helvetica,Arial,sans-serif;font-size:16px;color:#222;line-height:150%'>
											<strong> Estimado Cliente: $nomcte</strong>
											<br>
											<img src='https://img1.mtmedia.com.mx/mensajes/visa-master-card.png' style='float: left; margin: 5px;'>A continuación encontrará el Link para pago con tarjeta bancaria a una sola exhibición en Moneda Nacional - Excepto Tarjetas American Express
											<br>
											<strong>Referencia:</strong>$folexpo<br>
											<strong>Paquete: </strong>$ndestino - $destino<br>
											<strong>Pax: </strong> $pasajeros<br>
											<br><br>
											<strong>Importe a Pagar en esta Operación:</strong> $".number_format($importeapag,2) ."<br>
										($letras)
											<br>
											<strong>Fecha de Salida del día:</strong> $fsalidaRec<br>
										</p>
										<hr>
										<h2 style='font-family:Helvetica Neue,Helvetica,Arial,sans-serif;font-size:20px; color: #009ee5'>Para pagar, de clic en el botón:</h2>
										<center>
											<a href='$referencia' style='background-color: #009ee5; border: none; color: white; padding: 15px 32px;text-align: center;text-decoration: none; margin: auto; display: inline-block; font-size: 16px;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;font-size:16px;'>REALIZAR PAGO EN LÍNEA</a>
										</center>
										<br style='clear: both;'>
										<hr>
										<p style='font-family:Helvetica Neue,Helvetica,Arial,sans-serif;font-size:16px;color:#222;line-height:150%'>			
											<span style='display: block; margin: auto; font-weight: bold; width: 90%; background:#EE090D; color: #FFF; line-height: 100%; padding: 10px; font-size: 14px;  text-align: center;'>
									En caso de rechazo o que no pueda completar la operación favor de verificar que toda la información requerida 
									haya sido ingresada correctamente y si persiste el rechazo comunicarse con el banco emisor de su tarjeta para 
									asegurarse que su tarjeta no tenga algún candado de seguridad por monto o por operación no frecuente y se
									pueda liberar el pago.
											</span>
										</p>
									</td>
								</tr>
								<tr>
									<td colspan='3' style='font-family:Helvetica Neue,Helvetica,Arial,sans-serif;font-size:14px;color:#555;line-height:150%'>&nbsp;</td>
								</tr>
							</tbody>
						</table>
					</td>
				</tr>
			</tbody>
		</table>
	</body>
</html>";
?>