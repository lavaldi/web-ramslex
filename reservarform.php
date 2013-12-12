<?php
	$cod_equip		= 	$_POST['selectEquip']
	$nombres		=	$_POST['nombres']; 
	$apellidos		= 	$_POST['apellidos'];
	$dni			=	$_POST['dni'];
	$sexo			=	$_POST['sexo'];
	$telefono		=	$_POST['telefono'];
	$distrito		= 	$_POST['distrito'];
	$mail 			=	$_POST['email'];
	$conf_email		=	$_POST['conf-email'];
	$notificaciones	=	'';
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

	if (isset($_POST['notificaciones']){
		$notificaciones = 'si';
	}
	else{
		$notificaciones = 'no';
	}

	// servidor, usuario, contrasenia
	$conexion = mysql_connect ("localhost", "root", "") or die ("No se puede conectar con el servidor");
	mysql_select_db ("reservascubot") or die ("No se puede seleccionar la base de datos");

    $fecha = date ("Y-m-d"); // Fecha actual
    $instruccion = "insert into reservas (nombres, apellidos, equipo, dni, sexo, telefono, distrito, correo, notificaciones) values ('$titulo', '$texto', '$categoria', '$fecha', '$nombreFichero')";
    $consulta = mysql_query ($instruccion, $conexion)
         or die ("Fallo en la consulta");
    mysql_close ($conexion);

	if($consulta){
		$mensaje		=	"La reserva de ha sido realizada con éxito";
		$para			=	"$mail";
		$subject		= 	"Reserva de CUBOT realizada";
		$mainheaders	= 	"From: admin";

		mail ($para, $subject, $mensaje, $mainheaders);
	}
?>