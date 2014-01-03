<?php
	require_once('recaptcha/recaptchalib.php');
	$band = false;

	$publickey = "6Lct8esSAAAAAF-dHVtfJ2mcq3jLbdNN_D0mHtEf";
	$privatekey = "6Lct8esSAAAAADh5eKdnTJ-5MD9sBO-oL3NX0-a5";
	$error = null;

	$nombres	=	$_POST['nombres']; 
	$apellidos	= 	$_POST['apellidos'];
	$dni		=	$_POST['dni'];
	$celular	=	$_POST['celular'];
	$mail 		=	$_POST['email'];
	$conf_email	=	$_POST['conf-email'];
	$tipo_consulta	=	'';
	$consulta	=	$_POST['consulta'];

	if ($_POST["recaptcha_response_field"]) {
        $resp = recaptcha_check_answer ($privatekey,
            $_SERVER["REMOTE_ADDR"],
            $_POST["recaptcha_challenge_field"],
            $_POST["recaptcha_response_field"]);

        if ($resp->is_valid) {
                $band = true;
        } else {
                $band = false;
        }
	}

	if ($band) {

		switch ($_POST['selectConsulta']) {
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
			header('Location: consultar.php?band='.$band); 
		}
	}
	else
		header('Location: consultar.php?band='.$band); 
?>