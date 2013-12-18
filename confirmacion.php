<?php 
	$title = "Confirmación de Pago - ";

	require_once('recaptcha/recaptchalib.php');
	$publickey = "6Lct8esSAAAAAF-dHVtfJ2mcq3jLbdNN_D0mHtEf";
	$privatekey = "6Lct8esSAAAAADh5eKdnTJ-5MD9sBO-oL3NX0-a5";
	$error = null;

	include 'header.php'; 
?>
	<header class="navbar navbar-inverse navbar-fixed-top dnavbar" role="banner">
		<div class="container">
			<div class="navbar-header">
	    			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".dnavbar-collapse">
		      			<span class="sr-only">Toggle navigation</span>
		      			<span class="icon-bar"></span>
		      			<span class="icon-bar"></span>
		      			<span class="icon-bar"></span>
	    			</button>
    			<a class="navbar-brand" href="/promosmartphonecubot/"><img src="img/logoramslex-min.png" alt="Ramslex Engineering Solutions"></a>
  			</div>
			<nav class="collapse navbar-collapse dnavbar-collapse" role="navigation">
				<!-- Collect the nav links, forms, and other content for toggling -->
			    <ul class="nav navbar-nav">
			    	<li><a href="/promosmartphonecubot/">Inicio</a></li>
			    	<li><a href="especificaciones.php">Especificaciones Técnicas</a></li>
			      	<li id="reservar"><a href="reservar.php">Reservar</a></li>
			      	<li><a href="consultar.php">Consultar</a></li>
			      	<li class="active"><a href="confirmacion.php">Confirmación de Pago</a></li>
			      	<li><a href="cpago.php">Centros de Pago y Atención</a></li>
			      	<li><a href="garantia.php">Garantía</a></li>
			      	<li><a href="faqs.php">Preguntas Frecuentes</a></li>
			    </ul>
			</nav>
		</div>
	</header>
	<div id="conf-body" class="container first">
		<div id="banner" class="row">
			<div class="col-lg-12">
				<figure>
				  	<img src="img/banner-moviles.png" alt="Promoción Cubot">
				</figure>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="page-header">
					<h2>Confirmar Pago</h2>
				</div>
				<?php if(isset($_GET['band'])){
					echo '<div class="alert alert-dismissable alert-success">
              				<button type="button" class="close" data-dismiss="alert">×</button>
              				<strong>¡Genial!</strong> Hemos recibido tu confirmación de pago.</div>';}
            	?>
				<div id="rootwizard-1">
					<div class="navbar">
					  	<div class="navbar-inner">
						    <div class="container">
								<ul>
								  	<li><a href="#tab1" data-toggle="tab">Paso 1</a></li>
									<li><a href="#tab2" data-toggle="tab">Paso 2</a></li>
									<li><a href="#tab3" data-toggle="tab">Paso 3</a></li>
								</ul>
						 	</div>
						</div>
					</div>
					<div id="bar" class="progress progress-striped active">
					  	<div class="progress-bar" role="progressbar"></div>
					</div>
					<div class="tab-content">
					    <div class="tab-pane" id="tab1">
					    	<p>Ingresa código de reserva:</p>
					    	<div class="form-horizontal">
						      	<div class="form-group">
						      		<span id="sincodigo" class="help-block"></span>
							      	<label for="codigo" class="col-sm-3 col-sm-offset-2 control-label">Código de Reserva</label>
					      			<div class="col-sm-3">
					      				<div class="input-group">
										  	<span class="input-group-addon">TRUJ-RX-</span>
										  	<input id="codigo" name="codigo" class="form-control validate[required,maxSize[6],minSize[6]]">
										</div>
					      			</div>
					      		</div>
				      		</div>
					    </div>
					    <div class="tab-pane" id="tab2">
					    	<p>Ingresa los datos solicitados indicados en voucher de pago:</p>
							<form id="confirmacionform" class="form-horizontal" role="form" method="post">
								<input type="hidden" id="codigoreserva" name="codigoreserva">
							  	<div class="form-group">
							    	<label for="ope" class="col-sm-3 control-label">N° de Operación</label>
							    	<div class="col-sm-3">
							    		<input type="text" class="form-control validate[required,custom[onlyNumberSp]]" id="ope" name="ope">
							    	</div>
							  	</div>
							  	<div class="form-group">
							    	<label for="fecha" class="col-sm-3 control-label">Fecha</label>
							    	<div class="col-sm-9">
							    		<div class="row">
							    			<div class="col-sm-3">
							      				<input type="text" class="form-control validate[required] datepicker" id="fecha" name="fecha">
							      			</div>
							      			<label for="hora" class="col-sm-3 control-label">Hora</label>
							      			<div class="col-sm-3">
							      				<div class="bootstrap-timepicker input-append">
										            <input type="text" class="form-control validate[required] timepicker" id="hora" name="hora">
										        </div>
							      			</div>
							      		</div>
							    	</div>
							  	</div>
							  	<div class="form-group">
							    	<label for="pagoSelect" class="col-sm-3 control-label">Monto Total de Pago</label>
							    	<div class="col-sm-3">
							    		<select id="pagoSelect" name="pagoSelect" class="form-control validate[required]">
					      					<option value="299">Cubot GT90 -> S/.299.00</option>
											<option value="319">Cubot GT90 + MicroSD Kinngston 16 GB-> S/.319.00</option>
											<option value="369">Cubot P9 -> S/.369.00</option>
											<option value="389">Cubot P9 + MicroSD Kinngston 16 GB-> S/.389.00</option>
											<option value="569">Cubot GT99 -> S/.569.00</option>
											<option value="589">Cubot GT99 + MicroSD Kinngston 16 GB-> S/.589.00</option>
											<option value="659">Cubot ONE -> S/.659.00</option>
											<option value="679">Cubot ONE + MicroSD Kinngston 16 GB-> S/.679.00</option>
					      				</select>
							    	</div>
							  	</div>
							  	<div class="form-group">
							    	<div class="col-sm-offset-3 col-sm-9">
							    		<span id="error_captcha" class="help-block"></span>
						        		<label>
						          			<?php 
						          				echo recaptcha_get_html($publickey, $error); 
						          			?>
						        		</label>
							    	</div>
							  	</div>
							</form>
						</div>
						<div class="tab-pane" id="tab3">
							<div class="alert alert-dismissable alert-success">
								<p id="datos">
								</p>
							</div>
					    </div>
						<ul class="pager wizard">
							<li class="previous first" style="display:none;"><a href="#">Primer</a></li>
							<li class="previous"><a href="javascript:;">Anterior</a></li>
							<li class="next last" style="display:none;"><a href="#">Último</a></li>
						  	<li class="next"><a href="javascript:;">Siguiente</a></li>
						</ul>
					</div>	
				</div>
			</div>
		</div>
	</div>
<?php include 'footer.php'; ?>