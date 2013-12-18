<?php 
	$title = "Reservar - ";

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
			      	<li id="reservar" class="active"><a href="reservar.php">Reservar</a></li>
			      	<li><a href="consultar.php">Consultar</a></li>
			      	<li><a href="confirmacion.php">Confirmación de Pago</a></li>
			      	<li><a href="cpago.php">Centros de Pago y Atención</a></li>
			      	<li><a href="garantia.php">Garantía</a></li>
			      	<li><a href="faqs.php">Preguntas Frecuentes</a></li>
			    </ul>
			</nav>
		</div>
	</header>
	<div id="reservar-body" class="container first">
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
					<h2>Reserva tu Equipo</h2>
				</div>
				<?php if(isset($_GET['band'])){
					echo '<div class="alert alert-dismissable alert-success">
              				<button type="button" class="close" data-dismiss="alert">×</button>
              				<strong>¡Maravilloso!</strong> Tu reserva ha sido realizada con éxito. Te hemos mandado un mensaje a tu correo con el código de reserva. Revisa también en Spam o Correos no deseados!
            		</div>';}
            	?>
				<p>Ingresa tus datos para reservar tu equipo:</p>
				<div id="rootwizard">
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
					    	<div class="form-horizontal">
						      	<div class="form-group">
							      	<label for="distritoSelect" class="col-sm-3 col-sm-offset-2 control-label">Distrito</label>
					      			<div class="col-sm-3">
					      				<select id="distritoSelect" name="distritoSelect" class="form-control validate[required]">
					      					<option value="Trujillo">Trujillo</option>
											<option value="El Porvenir">El Porvenir</option>
											<option value="Florencia de Mora">Florencia de Mora</option>
											<option value="Huanchaco">Huanchaco</option>
											<option value="La Esperanza">La Esperanza</option>
											<option value="Laredo">Laredo</option>
											<option value="Moche">Moche</option>
											<option value="Poroto">Poroto</option>
											<option value="Salaverry">Salaverry</option>
											<option value="Simbal">Simbal</option>
											<option value="Victor Larco Herrera">Víctor Larco Herrera</option>
					      				</select>
					      			</div>
					      		</div>
				      		</div>
					    </div>
					    <div class="tab-pane" id="tab2">
					    	<form id="reservarform" class="form-horizontal" role="form">
					    		<input type="hidden" id="distrito" name="distrito">
						      	<div class="form-group">
							    	<label for="selectEquip" class="col-sm-3 control-label">Selecciona tu equipo</label>
							    	<div class="col-sm-2">
							      		<select id="selectEquip" name="selectEquip" class="form-control validate[required]">
							      			<option value="1">Cubot GT90</option>
							      			<option value="2">Cubot P9</option>
							      			<option value="3">Cubot GT99</option>
							      			<option value="4">Cubot One</option>
							      		</select>
							    	</div>
							  	</div>
							  	<div class="form-group">
							    	<label for="nombres" class="col-sm-3 control-label">Nombres</label>
							    	<div class="col-sm-9">
							    		<div class="row">
							    			<div class="col-sm-3">
							      				<input type="text" class="form-control validate[required,custom[onlyLetterSp]]" id="nombres" name="nombres" placeholder="Nombres">
							      			</div>
							      			<label for="apellidos" class="col-sm-3 control-label">Apellidos</label>
							      			<div class="col-sm-3">
							      				<input type="text" class="form-control validate[required,custom[onlyLetterSp]]" id="apellidos" name="apellidos" placeholder="Apellidos">
							      			</div>
							      		</div>
							    	</div>
							  	</div>
							  	<div class="form-group">
							    	<label for="dni" class="col-sm-3 control-label">DNI</label>
							    	<div class="col-sm-9">
							    		<div class="row">
							    			<div class="col-sm-3">
							      				<input type="text" class="form-control validate[required,custom[onlyNumberSp],maxSize[8],minSize[8]]" id="dni" name="dni" placeholder="DNI">
							      			</div>
							      			<label for="sexo" class="col-sm-3 control-label">Sexo</label>
							      			<div class="col-sm-3">
							      				<select id="sexo" name="sexo" class="form-control validate[required]">
							      					<option value="M">Masculino</option>
							      					<option value="F">Femenino</option>
							      				</select>
							      			</div>
							      		</div>
							    	</div>
							  	</div>
							  	<div class="form-group">
							    	<label for="telefono" class="col-sm-3 control-label">N° de Teléfono o Móvil</label>
							    	<div class="col-sm-9">
							    		<div class="row">
							    			<div class="col-sm-3">
							      				<input type="text" class="form-control validate[required,custom[onlyNumberSp],maxSize[9],minSize[9]]" id="telefono" name="telefono" placeholder="999999999">
							      			</div>
							      		</div>
							    	</div>
							  	</div>
							  	<div class="form-group">
							    	<label for="email" class="col-sm-3 control-label">Email</label>
							    	<div class="col-sm-9">
							    		<div class="row">
							    			<div class="col-sm-3">
							      				<input type="text" class="form-control validate[required,custom[email]]" id="email" name="email" placeholder="tu@email.com">
							      			</div>
							      			<label for="conf-email" class="col-sm-3 control-label">Confirmar Email</label>
							      			<div class="col-sm-3">
							      				<input type="text" class="form-control validate[required,equals[email]]" id="conf-email" name="conf-email">
							      			</div>
							      		</div>
							    	</div>
							  	</div>
							  	<div class="form-group">
							    	<div class="col-sm-offset-3 col-sm-9">
							      		<div class="checkbox">
							        		<label>
							          			<input id="notificaciones" name="notificaciones" type="checkbox"> Me interesa recibir promociones y descuentos del grupo RAMSLEX TECHNOLOGIES.
							        		</label>
							      		</div>
							    	</div>
							  	</div>
							  	<div class="form-group">
							    	<div class="col-sm-offset-3 col-sm-9">
							      		<div class="checkbox">
							        		<label>
							          			<input id="kingston" name="kingston" type="checkbox"> + S/. 20 una memoria Kingston de 16GB .
							        		</label>
							      		</div>
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
								<p>
									Estimad@ <span id="tagnombre"></span>, <br> 
									Sus datos han sido validados correctamente, su CÓDIGO DE RESERVA es: <strong><span id="tagcodigo"></span></strong>. Sus datos de validación de reserva han sido enviados al correo <span id="tagcorreo"></span>. <br> 
									Verifica también en la carpeta Spam o Correo no deseado.
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