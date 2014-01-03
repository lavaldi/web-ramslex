<?php 
	session_start();

	if(!isset($_SESSION["user"]))
		header( 'Location:index.php' );

	require_once("../db_conf.php");

	$idconfirmacion = $_REQUEST['idconfirmacion'];

    $conexion = mysql_connect ($server, $user, $password) or die ("No se puede conectar con el servidor");
	mysql_select_db ($dbname) or die ("No se puede seleccionar la base de datos");

	$sql = "DELETE FROM conf_pago WHERE idconf_pago =".$idconfirmacion;
	$consulta = mysql_query ($sql, $conexion)
	or die ("Fallo en la consulta");
	mysql_close ($conexion);
	echo "ok";

 ?>