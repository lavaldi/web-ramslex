<?php 
	session_start();

	if(!isset($_SESSION["user"]))
		header( 'Location:index.php' );

	require_once("../db_conf.php");
	$formulario = $_REQUEST['formulario'];
    $datos = array();
    parse_str($formulario,$datos);

    $conexion = mysql_connect ($server, $user, $password) or die ("No se puede conectar con el servidor");
	mysql_select_db ($dbname) or die ("No se puede seleccionar la base de datos");

	$sql = "UPDATE conf_pago SET `estado` = '1' WHERE idconf_pago =";
	$consulta = mysql_query ($sql, $conexion)
	or die ("Fallo en la consulta");
	mysql_close ($conexion);
	echo "ok";
?>