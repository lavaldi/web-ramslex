<?php 
session_start();

if(!isset($_SESSION["user"]))
	header( 'Location:index.php' );

require_once("../db_conf.php");

$conexion = mysql_connect ($server, $user, $password) or die ("No se puede conectar con el servidor");
mysql_select_db ($dbname) or die ("No se puede seleccionar la base de datos");

$sql = "SELECT * FROM conf_pago cp inner join reservas r on cp.idreservas = r.idreservas";
$consulta = mysql_query ($sql, $conexion)
or die ("Fallo en la consulta");
mysql_close ($conexion);

$reservas = array();

while ($fila = mysql_fetch_array($consulta, MYSQL_ASSOC)) {
    $reservas[] = array(
        "idconf_pago" => $fila["idconf_pago"],
        "num_operacion" => $fila["num_operacion"],
        "fecha_conf" => $fila["fecha_conf"],
        "fecha_pago" => $fila["fecha_pago"],
        "fecha" => $fila["fecha"],
        "hora" => $fila["hora"],
        "monto" => $fila["monto"],
        "idreservas" => $fila["idreservas"],
        "fecha" => $fila["fecha"],
        "nombres" => $fila["nombres"],
        "apellidos" => $fila["apellidos"],
        "equipo" => $fila["equipo"],
        "dni" => $fila["dni"],
        "sexo" => $fila["sexo"],
        "telefono" => $fila["telefono"],
        "distrito" => $fila["distrito"],
        "correo" => $fila["correo"],
        "notificaciones" => $fila["notificaciones"],
        "kingston" => $fila["kingston"],
        "codigoreserva" => $fila["codigoreserva"],
        "estado" => $fila["estado"]
    );
}

echo json_encode(array("aaData" => $reservas));
?>