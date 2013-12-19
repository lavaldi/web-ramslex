<?php 
	session_start();
	require_once("../db_conf.php");
	$formulario = $_REQUEST['formulario'];
    $datos = array();
    parse_str($formulario,$datos);

    $conexion = mysql_connect ($server, $user, $password) or die ("No se puede conectar con el servidor");
	mysql_select_db ($dbname) or die ("No se puede seleccionar la base de datos");

	$sql = "UPDATE usuario SET password =".$datos["newpass"]." WHERE email = '".$_SESSION["user"]."'";
	$consulta = mysql_query ($sql, $conexion)
	or die ("Fallo en la consulta");
	mysql_close ($conexion);
	echo "ok";
?>