<?php
session_start();
require_once("../db_conf.php");

$conexion = mysql_connect ($server, $user, $password) or die ("No se puede conectar con el servidor");
mysql_select_db ($dbname) or die ("No se puede seleccionar la base de datos");


$id = $_POST["id"];
$password = $_POST["password"];

$sql = "SELECT * FROM usuario where email= '".$id."' and password ='".$password."'";
$consulta = mysql_query ($sql, $conexion)
or die ("Fallo en la consulta");
mysql_close ($conexion);
$resultado = mysql_fetch_array($consulta, MYSQL_ASSOC);
if($resultado["email"]==null)
	header( 'Location:index.php' );
else{
	header( 'Location:cons_reservas_pagos.php' );
	$_SESSION["user"] = $resultado["email"];
}

 ?>