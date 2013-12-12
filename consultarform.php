<?php
	$nombres	=	$_POST['nombres']; 
	$apellidos	= 	$_POST['apellidos'];
	$dni		=	$_POST['dni'];
	$celular	=	$_POST['celular'];
	$mail 		=	$_POST['email'];
	$conf_email	=	$_POST['conf-email'];
	$tipo_consulta	=	'';
	$consulta	=	$_POST['consulta'];

	switch ($_POST['selectConsulta']) {
		case '1':
			$tipo_consulta = "Sobre la mecánica de la Promoción";
			break;
		case '2':
			$tipo_consulta = "Sobre el Celular";
			break;
		case '3':
			$tipo_consulta = "Otros";
			break;
	}

	$msg = "Nombre: ".$nombres." ".$apellidos."\n".
			"DNI: ".$dni."\n".
			"Celular: ".$celular."\n".
			"Correo: ".$mail."\n".
			"Consulta: ".$consulta."\n"; 
	$to = "clindy.26@gmail.com";
	$subject = "CONSULTA: ".$tipo_consulta;
	$mainheaders= "From: ".$mail;

	$resultado = mail ($to, $subject, $msg);

	if($resultado){
		header('Location: consultar.php?band=true'); 
	}
?>