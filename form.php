<?php


				error_reporting(E_ERROR | E_WARNING | E_PARSE);
			


					$nombre = $_POST['nombre'];
					$apellido = $_POST['apellido'];
					$correo = $_POST['correo'];
					$telefono = $_POST['telefono'];


					require_once('fpdf/fpdf.php');

					$pdf = new FPDF();
					$pdf -> AddPage();
					$pdf -> SetFont('Arial','',11);
					// $pdf ->Image('logo1.png',0,0,500);
					$pdf -> Cell(190,12,'Formulario generado en PDF',1,2,'C',0);
					$pdf -> Ln();
					$pdf -> Cell(50,9,'Nombre: '.$_POST['nombre'],0,2,'L');
					$pdf -> Ln();
					$pdf -> Cell(50,9,'Apellidos: '.$_POST['apellido'],0,2,'L');
					$pdf -> Ln();
					$pdf -> Cell(50,9,'Correo: '.$_POST['correo'],0,2,'L');
					$pdf -> Ln();
					$pdf -> Cell(50,9,'Telefono: '.$_POST['telefono'],0,2,'L');
					$pdf -> Ln();
					$pdf -> Cell(50,9,'Fecha: '.date('d/m/Y' , time()),0,2,'L');
					// $pdf -> Output();

					
					$to = "working.gpf@gmail.com"; 
					$from = "Formulario@contacto.com"; 
					$subject = "Formulario PDF"; 
					$message = '
								<!DOCTYPE html5>
								<html>
								<head>
								   <title>Datos de contacto</title>
								</head>
								<body>

								<h3 style="color:#738ba0;">Datos de contacto</h3>
								
								<p><b style="color:#738ba0;">Nombre: </b> '.$nombre.'</p>

								<p><b style="color:#738ba0;">Email: </b> '.$apellido.'</p>
							
								<p><b style="color:#738ba0;">Asunto: </b> '.$correo.'</p>

								<p><b style="color:#738ba0;">Mensaje: </b> '.$telefono.'</p>

								<p><b style="color:#738ba0;">Fecha: </b> '.date('d/m/Y' , time()).'</p>

								</body>
								</html>';

					// a random hash will be necessary to send mixed content
					$separator = md5(time());

					// carriage return type (we use a PHP end of line constant)
					$eol = PHP_EOL;

					// attachment name
					$filename = "formulario.pdf";

					// encode data (puts attachment in proper format)
					$pdfdoc = $pdf->Output("", "S");
					$attachment = chunk_split(base64_encode($pdfdoc));

					// main header
					$headers  = "From: ".$from.$eol;
					$headers .= "MIME-Version: 1.0".$eol; 
					$headers .= "Content-Type: multipart/mixed; boundary=\"".$separator."\"";

					// no more headers after this, we start the body! //

					$body = "--".$separator.$eol;
					$body .= "Content-Transfer-Encoding: 7bit".$eol.$eol;
					$body .= "Formulario PDF".$eol;

					// message
					$body .= "--".$separator.$eol;
					$body .= "Content-Type: text/html; charset=\"iso-8859-1\"".$eol;
					$body .= "Content-Transfer-Encoding: 8bit".$eol.$eol;
					$body .= $message.$eol;

					// attachment
					$body .= "--".$separator.$eol;
					$body .= "Content-Type: application/octet-stream; name=\"".$filename."\"".$eol; 
					$body .= "Content-Transfer-Encoding: base64".$eol;
					$body .= "Content-Disposition: attachment".$eol.$eol;
					$body .= $attachment.$eol;
					$body .= "--".$separator."--";

					// send message
					$mail = mail($to, $subject, $body, $headers);


					if($mail) {
					 echo '<script type="text/javascript">
							alert("Su mensaje ha sido enviado con éxito");
							window.location.href="index.html";</script>';
					} 
					else{
					 echo '<script type="text/javascript">
							alert("Ha ocurrido un error al intentar enviar su petición");
							window.location.href="index.html";</script>';
					}

					
?>
