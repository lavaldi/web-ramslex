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
					<button id="actualizar" class="btn btn-default" type="button" style="margin-top: 6px;"><i class="glyphicon glyphicon-repeat"></i></button>
				</ul>

				<!-- Tab panes -->
				<div class="tab-content">
				  	<div class="tab-pane active" id="reservas">
				  		<div class="panel panel-default" style="border-radius: 0; padding: 5px;">
				  			<br>
				  			<form id="formtablereservas" action="exportxls.php" method="post" target="_blank">
				  				<a id="xlstablereservas" class="btn btn-default" href="exportxls_res.php"><i class="glyphicon glyphicon-file"></i> Exportar</a>
				  				<button id="eliminarreservas" class="btn btn-default"><i class="glyphicon glyphicon-file"></i> Eliminar</button><hr>
				  				<input type="hidden" id="tablexportreservas" name="inputxport">
				  				<input type="hidden" id="filereservas" name="inputfilename" value="export_reservas_">
						  	<table id="tablereservas" cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered">
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
								<tbody></tbody>
							</table>
							</form>
						</div>
				  	</div>
				  	<div class="tab-pane" id="pconf">
				  		<div class="panel panel-default" style="border-radius: 0; padding: 5px;">
				  			<br>
				  			<a id="xlstableconfirmaciones" class="btn btn-default" href="exportxls_conf.php"><i class="glyphicon glyphicon-file"></i> Exportar</a>
				  			<button id="aceptaraonfirmacion" class="btn btn-default"><i class="glyphicon glyphicon-file"></i> Confirmar</button>
				  			<button id="eliminarconfirmacion" class="btn btn-default"><i class="glyphicon glyphicon-file"></i> Eliminar</button><hr>
					  		<table id="tableconfirmaciones" cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered">
								<thead>
									<tr>
										<th>Fecha Conf.</th>
										<th>Numero Op.</th>
										<th>Fecha Pago</th>
										<th>Hora</th>
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
	<div class="modal fade" id="eliminarreservamodal">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	        <h4 class="modal-title">Eliminar Reserva</h4>
	      </div>
	      <div class="modal-body">
	        <p>La reserva y los datos relacionados a esta se eliminara de forma permanente. Esta deacuerdo?</p>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
	        <button type="button" class="btn btn-primary" id="confelimreserv">Aceptar</button>
	      </div>
	    </div><!-- /.modal-content -->
	  </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->

	<div class="modal fade" id="eliminarconfirmacionmodal">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	        <h4 class="modal-title">Eliminar Reserva</h4>
	      </div>
	      <div class="modal-body">
	        <p>La Confirmacion de pago y los datos relacionados a esta se eliminara de forma permanente. Esta deacuerdo?</p>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
	        <button type="button" class="btn btn-primary" id="confelimconf">Aceptar</button>
	      </div>
	    </div><!-- /.modal-content -->
	  </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->

	<div class="modal fade" id="aceptarconfirmacionmodal">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	        <h4 class="modal-title">Eliminar Reserva</h4>
	      </div>
	      <div class="modal-body">
	        <p>Esta deacuerdo con los datos de la confirmacion</p>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
	        <button type="button" class="btn btn-primary" id="aceptarconf">Aceptar</button>
	      </div>
	    </div><!-- /.modal-content -->
	  </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
</body>
<script type="text/javascript" language="javascript" src="http://code.jquery.com/jquery-1.10.2.min.js"></script>

<script type="text/javascript" language="javascript" src="http://datatables.net/release-datatables/media/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" language="javascript" src="../js/datatable_plugins.js"></script>
<script type="text/javascript" language="javascript" src="../js/dataTables.bootstrap.js"></script>

<script type="text/javascript" src="../js/bootstrap.js"></script>

<script type="text/javascript" src="../js/jquery.validationEngine-es.js"></script>
<script type="text/javascript" src="../js/jquery.validationEngine.js"></script>

<script type="text/javascript">
	var IdReservaSelected = null;
	var IdConfirmacionSelected = null;

	$(document).ready(function(){
		$("form").validationEngine({promptPosition:'bottomLeft'});

		var tablereservas =  $('#tablereservas').dataTable( {
	    	"bProcessing": true, 
	    	"oLanguage": {"sUrl": "ES.txt"},
	    	"sAjaxSource": 'tablareservas.php',
	        "aoColumns":
	        	[{ "mDataProp": "fecha"},
	          	{ "mDataProp": "nombres"},
	          	{ "mDataProp": "apellidos"},
	          	{ "mDataProp": "correo"},
				{ "mDataProp": "telefono"},
	          	{ "mDataProp": "equipo"},
				{ "mDataProp": "monto"},
	          	{ "mDataProp": "dni"},
	          	{ "mDataProp": "sexo"},
	          	{ "mDataProp": "distrito"},
	          	{ "mDataProp": "notificaciones"},
	          	{ "mDataProp": "kingston"},
	            { "mDataProp": "codigoreserva"}],
	        "fnCreatedRow": function( nRow, aData, iDisplayIndex ) {
	        	$(nRow).click( function() {
					if ( $(this).hasClass('row_selected') ) {
			            $(this).removeClass('row_selected');		            
			            IdReservaSelected = null;
			        }
					else {
						$('#tablereservas tr.row_selected').removeClass('row_selected');
			            $(this).addClass('row_selected');
			            IdReservaSelected = aData.idreservas;
		        	}
				});
	        }
		});

    	var tableconfirmaciones=  $('#tableconfirmaciones').dataTable( {
	    	"bProcessing": true,
	    	"oLanguage": {"sUrl": "ES.txt"}, 
	    	"sAjaxSource": 'tablaconfirmpago.php',
	    	"aoColumns":
				[{ "mDataProp": "fecha_conf"},
				{ "mDataProp": "num_operacion"},
				{ "mDataProp": "fecha_pago"},
	          	{ "mDataProp": "hora"},
	          	{ "mDataProp": "monto"},
	          	{ "mDataProp": "fecha"},
	          	{ "mDataProp": "nombres"},
	          	{ "mDataProp": "apellidos"},
	          	{ "mDataProp": "equipo"},
	          	{ "mDataProp": "dni"},
	          	{ "mDataProp": "codigoreserva"}],
	        "fnCreatedRow": function( nRow, aData, iDisplayIndex ) {
	        	if(aData.estado == '0'){
	        		$(nRow).click( function() {
						if ( $(this).hasClass('row_selected') ) {
				            $(this).removeClass('row_selected');
				            IdConfirmacionSelected = null;
				        }
						else {
							$('#tableconfirmaciones tr.row_selected').removeClass('row_selected');
				            $(this).addClass('row_selected');
				            IdConfirmacionSelected = aData.idconf_pago;
			        	}
					});
	        	}
	        	else{	        	
	        		$(nRow).addClass('row_confirm');
	        	}
	        }
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
    	$("#actualizar").click(function(e){
    		e.preventDefault();
    		tablereservas.fnReloadAjax("tablareservas.php");
    		tableconfirmaciones.fnReloadAjax("tablaconfirmpago.php");
    	});
    	$("#eliminarreservas").click(function(e){
			e.preventDefault();
			if(IdReservaSelected !=null)
				$("#eliminarreservamodal").modal('show');
		});

		$("#confelimreserv").click(function(e){
			e.preventDefault();
			var enviareliminar = $.ajax({
				type: "post",
				async: false,
				url: "eliminar_reserva.php",
				data: {'idreserva':IdReservaSelected}			
			});

			enviareliminar.done(function(data){
				$("#eliminarreservamodal").modal('hide');
				tablereservas.fnReloadAjax("tablareservas.php");
				tableconfirmaciones.fnReloadAjax("tablaconfirmpago.php");
			})
		});

		$("#eliminarconfirmacion").click(function(e){
			e.preventDefault();
			if(IdConfirmacionSelected !=null)
				$("#eliminarconfirmacionmodal").modal('show');
		});

		$("#confelimconf").click(function(e){
			e.preventDefault();
			var enviareliminar = $.ajax({
				type: "post",
				async: false,
				url: "eliminar_confirmacion.php",
				data: {'idconfirmacion':IdConfirmacionSelected}			
			});

			enviareliminar.done(function(data){
				$("#eliminarconfirmacionmodal").modal('hide');
				tablereservas.fnReloadAjax("tablareservas.php");
				tableconfirmaciones.fnReloadAjax("tablaconfirmpago.php");
			})
		});

		$("#aceptaraonfirmacion").click(function(e){
			e.preventDefault();
			if(IdConfirmacionSelected !=null)
				$("#aceptarconfirmacionmodal").modal('show');
		});

		$("#aceptarconf").click(function(e){
			e.preventDefault();
			var enviaraceptar = $.ajax({
				type: "post",
				async: false,
				url: "aceptar_confirmacion.php",
				data: {'idconfirmacion':IdConfirmacionSelected}			
			});

			enviaraceptar.done(function(data){
				$("#aceptarconfirmacionmodal").modal('hide');
				tablereservas.fnReloadAjax("tablareservas.php");
				tableconfirmaciones.fnReloadAjax("tablaconfirmpago.php");
			})
		});
	});
</script>
</html>