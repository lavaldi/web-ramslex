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
	*/
	$cod_equip		= 	$_POST['selectEquip'];
	$nombres		=	$_POST['nombres']; 
	$apellidos		= 	$_POST['apellidos'];
	$dni			=	$_POST['dni'];
	$sexo			=	$_POST['sexo'];
	$telefono		=	$_POST['telefono'];
	$distrito		= 	$_POST['distrito'];
	$mail 			=	$_POST['email'];
	$conf_email		=	$_POST['conf-email'];
	$notificaciones	=	'';
	$kingston		=	'';
	$equipo 		= 	'';

	switch ($cod_equip) {
		case '1':
			$equipo = 'Cubot GT90';
			break;
		case '2':
			$equipo = 'Cubot P9';
			break;
		case '3':
			$equipo = 'Cubot GT99';
			break;
		case '4':
			$equipo = 'Cubot One';
			break;
	}

	if (isset($_POST['notificaciones'])){
		$notificaciones = 'si';
	}
	else{
		$notificaciones = 'no';
	}

	if (isset($_POST['kingston'])){
		$kingston = 'si';
	}
	else{
		$kingston = 'no';
	}

	// servidor, usuario, contrasenia
	$conexion = mysql_connect ("localhost", "cmclmcom_webmast", "CLMwebmaster123") or die ("No se puede conectar con el servidor");
	mysql_select_db ("cmclmcom_testedu") or die ("No se puede seleccionar la base de datos");

    $fecha = date ("Y-m-d"); // Fecha actual
    $instruccion = "insert into reservas (fecha, nombres, apellidos, equipo, dni, sexo, telefono, distrito, correo, notificaciones, kingston) values ('".$fecha."','".$nombres."', '".$apellidos."', '".$equipo."', '".$dni."', '".$sexo."', '".$telefono."', '".$distrito."', '".$mail."', '".$notificaciones."','".$kingston."')";
    $consulta = mysql_query ($instruccion, $conexion)
         or die ("Fallo en la consulta");
    mysql_close ($conexion);

	if($consulta){
		$mensaje		=	"La reserva de ha sido realizada con éxito";
		$para			=	$mail;
		$subject		= 	"Reserva de CUBOT realizada";
		$mainheaders	= 	"From: RAMSLEX TECHNOLOGIES";

		$resultado = mail ($para, $subject, $mensaje, $mainheaders);
		if($resultado){
			header('Location: reservar.php?band=true'); 
		}
	}
?>