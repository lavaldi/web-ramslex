<?php
	require_once("db_conf.php");
	require_once('recaptcha/recaptchalib.php');
	$band 			= 	false;
	$success 		= 	true;
	$envio 			= 	array();

	$publickey 		= 	"6Lct8esSAAAAAF-dHVtfJ2mcq3jLbdNN_D0mHtEf";
	$privatekey 	= 	"6Lct8esSAAAAADh5eKdnTJ-5MD9sBO-oL3NX0-a5";
	$error 			= 	null;

	$formulario		= 	$_REQUEST['formulario'];
	$datos			= 	array();

	parse_str($formulario,$datos);

	$codigoreserva	=	$datos['codigoreserva']; 
	$numope			= 	$datos['ope'];
	$fecha			=	$datos['fecha'];
	$hora			=	$datos['hora'];
	$pago 			= 	$datos['pagoSelect'];

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

		$conexion = mysqli_connect ($server, $user, $password) or die ("No se puede conectar con el servidor"); 
		mysqli_select_db ($conexion,$dbname) or die ("No se puede seleccionar la base de datos"); 
		
		mysqli_autocommit($conexion,FALSE);

		$instruccion = "SELECT * FROM reservas WHERE codigoreserva='".$codigoreserva."'";
		$consulta = mysqli_query($conexion,$instruccion);

		if (!$consulta) {
			$success = false;
	    	$envio =  array('band'=>false,'cod'=>$codigoreserva, 'msj'=>'El código ingresado no es correcto, vuelva a intentar con un código válido.');
		}
		else{
			$consulta = mysqli_fetch_array($consulta);
			$fecha1 = date_create_from_format('d-m-Y',$fecha);
			$fecha2 = $fecha1 -> format('Y-m-d');
			$instruccion1 = "INSERT into conf_pago (num_operacion, fecha_pago, hora, monto, idreservas) VALUES ('".$numope."','".$fecha2."', '".$hora."', '".$pago."', ".$consulta['idreservas'].")";
		    $consulta1 = mysqli_query($conexion,$instruccion1);

		    if(!$consulta1){
		    	$success = false;
		    	$envio =  array('band'=>false,'cod'=>$codigoreserva, 'msj'=>'Algo salió mal, intente nuevamente 1');
		    }
	   		else{
				$msg = 	"Estimad@ ".$consulta['nombres']."\n".
						"Sus datos han sido validados correctamente y son los siguientes: \n".
						"Código de Reserva: ".$codigoreserva."\n".
						"Número de Operación: ".$numope."\n".
						"Fecha: ".$fecha."\n".
						"Hora: ".$hora."\n".
						"------------------------------------------------------------------------ \n".
						"Equipo a separar".$consulta['equipo']."\n".
						"Memoria kingston: ".$consulta['kingston']."\n".
						"Total a PAGAR: ".$pago."\n".
						"Nombre completo: ".$consulta['nombres']." ".$consulta['apellidos']."\n".
						"DNI: ".$consulta['dni']."\n".
						"Sexo: ".$consulta['sexo']."\n".
						"N° de Teléfono o Celular: ".$consulta['telefono']."\n".
						"Correo: ".$consulta['correo']."\n"; 
				$to = $consulta['correo'];
				$subject = "Confimación de Pago CUBOT";
				$mainheaders= "From: RAMSLEX ENGINEERING TECHNOLOGIES";

				$resultado = mail ($to, $subject, $msg);

				$msg1 = "Datos validados del cliente ".$consulta['nombres'].": \n".
						"========================================================== \n".
						"Código de Reserva: ".$codigoreserva."\n".
						"Número de Operación: ".$numope."\n".
						"Fecha: ".$fecha."\n".
						"Hora: ".$hora."\n".
						"------------------------------------------------------------------------ \n".
						"Equipo a separar".$consulta['equipo']."\n".
						"Memoria kingston: ".$consulta['kingston']."\n".
						"Total a PAGAR: ".$pago."\n".
						"Nombre completo: ".$consulta['nombres']." ".$consulta['apellidos']."\n".
						"DNI: ".$consulta['dni']."\n".
						"Sexo: ".$consulta['sexo']."\n".
						"N° de Teléfono o Celular: ".$consulta['telefono']."\n".
						"Correo: ".$consulta['correo']."\n"; 
				$to1 = "clindy.26@gmail.com";
				$subject1 = "Confimación de Pago: ".$codigoreserva;
				$mainheaders1 = "From: ".$consulta['correo'];

				$resultado1 = mail ($to1, $subject1, $msg1);

				$msg3 = 	"Estimad@ ".$consulta['nombres']."<br>".
						"Sus datos han sido validados correctamente y son los siguientes: <br>".
						"Código de Reserva: ".$codigoreserva."<br>".
						"Número de Operación: ".$numope."<br>".
						"Fecha: ".$fecha."<br>".
						"Hora: ".$hora."<br><br>".
						"Equipo a separar".$consulta['equipo']."<br>".
						"Memoria kingston: ".$consulta['kingston']."<br>".
						"Total a PAGAR: ".$pago."<br>".
						"Nombre completo: ".$consulta['nombres']." ".$consulta['apellidos']."<br>".
						"DNI: ".$consulta['dni']."<br>".
						"Sexo: ".$consulta['sexo']."<br>".
						"N° de Teléfono o Celular: ".$consulta['telefono']."<br>".
						"Correo: ".$consulta['correo']."<br>"; 

				$envio =  array('band'=>$band,'cod'=>$codigoreserva, 'msj'=>$msg3);

				if(!$resultado){
					$success = false;
					$envio =  array('band'=>false,'cod'=>$codigoreserva, 'msj'=>'Algo salió mal, intente nuevamente 2');
				}
			}
		}
		if(!$success) {
			mysqli_rollback($conexion);
		} else {
			mysqli_commit($conexion);
		}
		mysqli_close($conexion);
	}
	else{
		$envio =  array('band'=>$band,'cod'=>null,'msj'=>'Captcha incorrecto');
	}
	echo json_encode($envio);
?>