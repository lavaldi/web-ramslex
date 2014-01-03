<?php 
session_start();

if(!isset($_SESSION["user"]))
	header( 'Location:index.php' );

require_once("../db_conf.php");

$filename = "export_conf_pago_".date("d-m-Y");

$conexion = mysql_connect ($server, $user, $password) or die ("No se puede conectar con el servidor");
mysql_select_db ($dbname) or die ("No se puede seleccionar la base de datos");

$sql = "SELECT * FROM reservas";
$consulta = mysql_query ($sql, $conexion)
or die ("Fallo en la consulta");
mysql_close ($conexion);

$content = "";

while ($fila = mysql_fetch_array($consulta, MYSQL_ASSOC)) {
    $content .= "<tr><td>".$fila["fecha"]."</td>".
    			"<td>".$fila["nombres"]."</td>".
    			"<td>".$fila["apellidos"]."</td>".
    			"<td>".$fila["equipo"]."</td>".
    			"<td>".$fila["dni"]."</td>".
    			"<td>".$fila["sexo"]."</td>".
    			"<td>".$fila["telefono"]."</td>".
    			"<td>".$fila["distrito"]."</td>".
    			"<td>".$fila["correo"]."</td>".
    			"<td>".$fila["notificaciones"]."</td>".
    			"<td>".$fila["kingston"]."</td>".
    			"<td>".$fila["codigoreserva"]."</td></tr>";
}

$table = "	<table border='1'>
				<thead>
					<tr>
						<th>Fecha de Reserva</th>
						<th>Nombre</th>
						<th>Apellidos</th>
						<th>Correo</th>
						<th>Teléfono</th>
						<th>Equipo Selec.</th>
						<th>Monto</th>
						<th>DNI</th>
						<th>Sexo</th>
						<th>Distrito</th>
						<th>Notif.</th>
						<th>Kingston</th>
						<th>Codigo de Reserva</th>
					</tr>
				</thead>
				<tbody>".$content."</tbody></table>";

header("Content-type: application/x-msdownload; charset=utf-16");
header("Content-Disposition: attachment; filename=".$filename.".xls");
header("Pragma: no-cache");
header("Expires: 0");
echo $table;

?>