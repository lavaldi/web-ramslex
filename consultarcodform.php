<?php
	require_once("db_conf.php");
	require_once('recaptcha/recaptchalib.php');
	$band = false;

	$publickey = "6Lct8esSAAAAAF-dHVtfJ2mcq3jLbdNN_D0mHtEf";
	$privatekey = "6Lct8esSAAAAADh5eKdnTJ-5MD9sBO-oL3NX0-a5";
	$error = null;

	$dni		=	$_POST['dni'];
	$celular	=	$_POST['celular'];
	$mail 		=	$_POST['email'];

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

		$conexion = mysql_connect ($server, $user, $password) or die ("No se puede conectar con el servidor"); 
		mysql_select_db ($dbname) or die ("No se puede seleccionar la base de datos"); 

	    $instruccion = "SELECT * FROM reservas WHERE dni='".$dni."' AND telefono='".$celular."' AND correo='".$mail."'";
	    $consulta = mysql_query ($instruccion, $conexion)
	         or die ("Fallo en la consulta");
	    $consulta = mysql_fetch_array($consulta,MYSQLI_ASSOC);
	    mysql_close ($conexion);

		$msg = 	"Hola ".$consulta['nombres']."\n".
				"Tu código de reserva es: ".$consulta['codigoreserva']."\n"; 
		$para			=	$mail;
		$subject		= 	"Código de Reserva Cubot";
		$mainheaders	= 	"From: RAMSLEX ENGINEERING TECHNOLOGIES";

		$resultado = mail ($para, $subject, $msg, $mainheaders);

		$cadena = array($band,$consulta['codigoreserva'],$consulta['nombres']);
		$cadserial = serialize($cadena);

		if($resultado){
			header('Location: consultarcod.php?cadserial='.$cadserial); 
		}
	}
	else
		header('Location: consultarcod.php?band='.$band); 
?>