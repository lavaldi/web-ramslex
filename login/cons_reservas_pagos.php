<?php 
session_start();

if(!isset($_SESSION["user"]))
	header( 'Location:index.php' );
 ?>
<html>
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="CLM Developers">
	<title>Consultar Reservas y Confirmación de Pagos - Promoción Smartphone Cubot</title>

	<link rel="stylesheet" type="text/css" href="../css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="../css/dataTables.bootstrap.css">
	<link rel="stylesheet" type="text/css" href="../css/validationEngine.jquery.css">
	<link rel="stylesheet" type="text/css" href="../css/styles.css">
</head>
<body>
	<header class="navbar navbar-inverse navbar-fixed-top dnavbar" role="banner">
		<div class="container">
			<div class="navbar-header">
	    			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".dnavbar-collapse">
		      			<span class="sr-only">Toggle navigation</span>
		      			<span class="icon-bar"></span>
		      			<span class="icon-bar"></span>
		      			<span class="icon-bar"></span>
	    			</button>
    			<a class="navbar-brand" href="/promosmartphonecubot/"><img src="../img/logoramslex-min.png" alt="Ramslex Engineering Solutions"></a>
  			</div>
			<nav class="collapse navbar-collapse dnavbar-collapse" role="navigation">
				<!-- Collect the nav links, forms, and other content for toggling -->
			    <form id="udatepssform" class="navbar-form navbar-left" action="updatepass.php" method="post">
			    	<div class="form-group" style="margin-right:5px;">
						<input class="validate[required] form-control" type="password" id="newpass" name="newpass" placeholder="nuevo password">
					</div>
					<div class="form-group" style="margin-right:5px;">
						<input class="validate[required,equals[newpass]] form-control" type="password" id="repass" name="repass" placeholder="repetir password">
					</div>
					<input id="btn_update_pass" class="btn btn-primary" type="button" value="Cambiar Password">
				</form>
				<form action="logout.php" class="navbar-form navbar-right">
					<input type="submit" class="btn btn-primary" value="Cerrar Sesión">
				</form>
			</nav>
		</div>
	</header>
	<div class="first" style="padding: 25px;">
		<div class="row">
			<div class="col-lg-12">
				<div class="page-header">
					<h2>Consultas</h2>
				</div>
				<ul class="nav nav-tabs">
					<li class="active"><a href="#reservas" data-toggle="tab">Reservas</a></li>
					<li><a href="#pconf" data-toggle="tab">Pagos Confirmados</a></li>
				</ul>

				<!-- Tab panes -->
				<div class="tab-content">
				  	<div class="tab-pane active" id="reservas">
				  		<div class="panel panel-default" style="border-radius: 0; padding: 5px;">
				  			<br>
						  	<table id="tablereservas" cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered">
								<thead>
									<tr>
										<th>Fecha de Reserva</th>
										<th>Nombre</th>
										<th>Apellidos</th>
										<th>Equipo Selec.</th>
										<th>DNI</th>
										<th>Sexo</th>
										<th>Distrito</th>
										<th>Notif.</th>
										<th>Kingston</th>
										<th>Codigo de Reserva</th>
									</tr>
								</thead>
								<tbody></tbody>
							</table>
						</div>
				  	</div>
				  	<div class="tab-pane" id="pconf">
				  		<div class="panel panel-default" style="border-radius: 0; padding: 5px;">
				  			<br>
					  		<table id="tableconfirmaciones" cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered">
								<thead>
									<tr>
										<th>Fecha Pago</th>
										<th>Hora</th>
										<th>Numero Op.</th>
										<th>Monto</th>
										<th>Fecha Res.</th>
										<th>Nombre</th>
										<th>Apellidos</th>
										<th>Equipo</th>
										<th>DNI</th>
										<th>Codigo de Reserva</th>
									</tr>
								</thead>
								<tbody></tbody>
							</table>
						</div>
				  	</div>
				</div>
			</div>
		</div>
	</div>
</body>
<script type="text/javascript" language="javascript" src="http://code.jquery.com/jquery-1.10.2.min.js"></script>

<script type="text/javascript" language="javascript" src="http://datatables.net/release-datatables/media/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" language="javascript" src="../js/dataTables.bootstrap.js"></script>

<script type="text/javascript" src="../js/bootstrap.js"></script>

<script type="text/javascript" src="../js/jquery.validationEngine-es.js"></script>
<script type="text/javascript" src="../js/jquery.validationEngine.js"></script>

<script type="text/javascript">
	$(document).ready(function(){
		$("form").validationEngine({promptPosition:'bottomLeft'});

		$('#tablereservas').dataTable( {
        	"bProcessing": true, 
        	"oLanguage": {
                    "sUrl": "ES.txt"
            },
        	"sAjaxSource": 'tablareservas.php',
        	"aoColumns": 
        		[	{ "mDataProp": "fecha"},
                  	{ "mDataProp": "nombres"},
                  	{ "mDataProp": "apellidos"},
                  	{ "mDataProp": "equipo"},
                  	{ "mDataProp": "dni"},
                  	{ "mDataProp": "sexo"},
                  	{ "mDataProp": "distrito"},
                  	{ "mDataProp": "notificaciones"},
                  	{ "mDataProp": "kingston"},
                  	{ "mDataProp": "codigoreserva"}
                 ]
    	});

    	$('#tableconfirmaciones').dataTable( {
        	"bProcessing": true,
        	"oLanguage": {
                    "sUrl": "ES.txt"
            }, 
        	"sAjaxSource": 'tablaconfirmpago.php',
        	"aoColumns":
        		[	{ "mDataProp": "fecha_pago"},
                  	{ "mDataProp": "hora"},
        			{ "mDataProp": "num_operacion"},
                  	{ "mDataProp": "monto"},
                  	{ "mDataProp": "fecha"},
                  	{ "mDataProp": "nombres"},
                  	{ "mDataProp": "apellidos"},
                  	{ "mDataProp": "equipo"},
                  	{ "mDataProp": "dni"},
                  	{ "mDataProp": "codigoreserva"}
                 ]
    	});

    	$("#btn_update_pass").click(function(e){
    		e.preventDefault();
    		var updatepass = $.ajax({
			  type: "POST",
			  url: "updatepass.php",
			  async:false,
			  data: {"formulario":$("#udatepssform").serialize()}
			});

			updatepass.done(function(data){
				console.log(data);
				$("#repass").val("");
				$("#newpass").val("");
			});
    	});
	});
</script>
</html>