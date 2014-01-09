<?php
	require_once('recaptcha/recaptchalib.php');
	$band = false;

	$publickey = "6Lct8esSAAAAAF-dHVtfJ2mcq3jLbdNN_D0mHtEf";
	$privatekey = "6Lct8esSAAAAADh5eKdnTJ-5MD9sBO-oL3NX0-a5";
	$error = null;

	$formulario		= 	$_REQUEST['formulario'];
	$datos			= 	array();
	parse_str($formulario,$datos);

	$nombres	=	$datos['nombres']; 
	$apellidos	= 	$datos['apellidos'];
	$dni		=	$datos['dni'];
	$celular	=	$datos['celular'];
	$mail 		=	$datos['email'];
	$conf_email	=	$datos['conf-email'];
	$tipo_consulta	=	'';
	$consulta	=	$datos['consulta'];

	if ($datos["recaptcha_response_field"]) {
        $resp = recaptcha_check_answer ($privatekey,
            $_SERVER["REMOTE_ADDR"],
            $datos["recaptcha_challenge_field"],
            $datos["recaptcha_response_field"]);

        if ($resp->is_valid) {
                $band = true;
        } else {
                $band = false;
        }
	}

	if ($band) {

		switch ($datos['selectConsulta']) {
			case '1':
				$tipo_consulta = "Sobre la mecánica de la Promoción";
				break;
			case '2':
				$tipo_consulta = "Sobre el Celular";
				break;
			case '3':
				$tipo_consulta = "Sobre envíos a provincia";
				break;
			case '4':
				$tipo_consulta = "Otros";
				break;
		}

		$msg = "Nombre: ".$nombres." ".$apellidos."\n".
				"DNI: ".$dni."\n".
				"Celular: ".$celular."\n".
				"Correo: ".$mail."\n".
				"Consulta: ".$consulta."\n"; 
		$to = "consultacliente.cubot@ramslex.com";
		$subject = "CONSULTA: ".$tipo_consulta;
		$mainheaders= "From: ".$mail;

		$resultado = mail ($to, $subject, $msg);

		if($resultado){
			$band = true;
		}
	}
	else
		$band = false;

	echo json_encode($band); 
?>