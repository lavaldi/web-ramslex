<?php
	$codigoreserva	=	$_POST['cod']; 
	$numope			= 	$_POST['ope'];
	$fecha			=	$_POST['fecha'];
	$hora			=	$_POST['hora'];

	$msg = "Código de Reserva: ".$codigoreserva."\n".
			"Número de Operación: ".$numope."\n".
			"Fecha: ".$fecha."\n".
			"Hora: ".$hora."\n"; 
	$to = "clindy.26@gmail.com";
	$subject = "Confimación de Pago: ".$codigoreserva;
	$mainheaders= "From: ".$mail;

	$resultado = mail ($to, $subject, $msg);

	if($resultado){
		header('Location: confirmacion.php?band=true'); 
	}
?>