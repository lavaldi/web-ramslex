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

	$msg = "Nombre: $nombres $apellidos \n
			DNI: $dni \n
			Celular: $celular \n
			Correo: $mail \n
			Consulta: $consulta \n"; 
	$to = "clindy.26@gmail.com";
	$subject = "CONSULTA: $tipo_consulta";
	$mainheaders= "From: $mail";

	$resultado = mail ($to, $subject, $msg);

	/*if($resultado){
		//El correo de respuesta al que te ha mandado el formulario:
		//variables
		$mensaje= "Gracias $nombre, por comunicarse con el Webmaster de recibirá una pronta respuesta";
		$para="$mail";
		$subject= "Gracias $nombre por enviarnos el formulario";
		$mainheaders= "From: admin";

		mail ($para, $subject, $mensaje, $mainheaders);
	}*/


	// servidor, usuario, contrasenia
	
?>