<?php
/*
	CREATE  TABLE `reservas` (
	`idreservas` INT NOT NULL AUTO_INCREMENT ,
	`fecha` DATE NOT NULL ,
	`nombres` VARCHAR(45) NOT NULL ,
	`apellidos` VARCHAR(45) NOT NULL ,
	`equipo` VARCHAR(15) NOT NULL ,
	`dni` VARCHAR(8) NOT NULL ,
	`sexo` VARCHAR(1) NOT NULL ,
	`telefono` VARCHAR(10) NOT NULL ,
	`distrito` VARCHAR(25) NOT NULL ,
	`correo` VARCHAR(50) NOT NULL ,
	`notificaciones` VARCHAR(2) NOT NULL ,
	`kingston` VARCHAR(2) NOT NULL ,
	PRIMARY KEY (`idreservas`) );




	ALTER TABLE `reservascubot`.`reservas` ADD COLUMN `codigoreserva` VARCHAR(15) NULL  AFTER `kingston` 
, ADD UNIQUE INDEX `codigoreserva_UNIQUE` (`codigoreserva` ASC) ;
	*/
	function getCode(){
        $code = '' ;
        $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ023456789"; 
        srand((double)microtime()*1000000); 
        for ($i=0;$i<6;$i++) { 
	        $num = rand()%20; 
	        $tmp = substr($chars, $num, 1); 
	        $code = $code.$tmp; 
        }
        $code = "TRUJ-RX-".$code;
    	return $code; 
    }
	
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

	$cod_equip		= 	$datos['selectEquip'];
	$nombres		=	$datos['nombres']; 
	$apellidos		= 	$datos['apellidos'];
	$dni			=	$datos['dni'];
	$sexo			=	$datos['sexo'];
	$telefono		=	$datos['telefono'];
	$distrito		= 	$datos['distrito'];
	$mail 			=	$datos['email'];
	$conf_email		=	$datos['conf-email'];
	$notificaciones	=	'';
	$kingston		=	'';
	$equipo 		= 	'';
	$monto			=	0;

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
		
		switch ($cod_equip) {
			case '1':
				$equipo = 'Cubot GT90';
				$monto 	= 299; 
				break;
			case '2':
				$equipo = 'Cubot P9';
				$monto 	= 369; 
				break;
			case '3':
				$equipo = 'Cubot GT99';
				$monto 	= 569; 
				break;
			case '4':
				$equipo = 'Cubot One';
				$monto 	= 659; 
				break;
		}

		if (isset($datos['notificaciones'])){
			$notificaciones = 'si';
		}
		else{
			$notificaciones = 'no';
		}

		if (isset($datos['kingston'])){
			$kingston = 'si';
			$monto = $monto + 20;
		}
		else{
			$kingston = 'no';
		}

		// servidor, usuario, contrasenia
		$conexion = mysqli_connect ("localhost", "root", "") or die ("No se puede conectar con el servidor"); /*usuario= cmclmcom_webmast ---- contrasenia=CLMwebmaster123*/
		mysqli_select_db ($conexion,"reservascubot") or die ("No se puede seleccionar la base de datos"); /*BD = cmclmcom_testedu*/

		mysqli_autocommit($conexion,FALSE);

		do{
			$code = getCode();
			$instruccion3 = "SELECT codigoreserva FROM reservas WHERE codigoreserva='".$code."'";
			$consulta3 = mysqli_fetch_array(mysqli_query($conexion,$instruccion3),MYSQLI_ASSOC);
		} while($consulta3['codigoreserva'] != null);

	    $fecha = date ("Y-m-d"); // Fecha actual
	    $instruccion = "INSERT into reservas (fecha, nombres, apellidos, equipo, dni, sexo, telefono, distrito, correo, notificaciones, kingston, codigoreserva) VALUES ('".$fecha."','".$nombres."', '".$apellidos."', '".$equipo."', '".$dni."', '".$sexo."', '".$telefono."', '".$distrito."', '".$mail."', '".$notificaciones."','".$kingston."', '".$code."')";
	    $consulta = mysqli_query($conexion,$instruccion);

	    if(!$consulta){
	    	$success = false;
	    	$envio =  array('band'=>false,'cod'=>$cod, 'msj'=>'Algo salió mal, intente nuevamente');
	    }
   		else{

		    $envio =  array('band'=>$band,'cod'=>$cod);
	    	$mensaje		=	"La reserva de ha sido realizada con éxito! \n".
								"Tu código de reserva es ".$cod."\n".
								"Tus Datos son: \n".
								"Equipo a separar".$equipo."\n".
								"Memoria kingston: ".$kingston."\n".
								"Total a PAGAR: ".$monto."\n".
								"Nombre: ".$nombres." ".$apellidos."\n".
								"DNI: ".$dni."\n".
								"Sexo: ".$sexo."\n".
								"N° de Teléfono o Celular: ".$telefono."\n".
								"Correo: ".$mail."\n";
			$para			=	$mail;
			$subject		= 	"Reserva de CUBOT realizada";
			$mainheaders	= 	"From: RAMSLEX ENGINEERING TECHNOLOGIES";

			$envio =  array('band'=>$band,'cod'=>$cod, 'msj'=>':)');

			$resultado = mail ($para, $subject, $mensaje, $mainheaders);

			if(!$resultado){
				$success = false;
				$envio =  array('band'=>false,'cod'=>$cod, 'msj'=>'Algo salió mal, intente nuevamente');
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