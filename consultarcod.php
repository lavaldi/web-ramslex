<?php 
	$title = "Consultar - ";

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
			      	<li class="active"><a href="consultar.php">Consultar</a></li>
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
					<h2>Consultar Código de Reserva</h2>
				</div>
				<div id="datosmal" class="alert alert-dismissable alert-danger" style="display:none;">
      				<p>Estimado USUARIO uno de los datos ingresados (DNI ó CELULAR ó EMAIL) no es correcto, le recomendamos ingresar correctamente los 3 datos y volver a intentar.<br>
      				Si es usuario nuevo, le recomendamos reservar su Smartphone CUBOT para obtener un código de reserva. Haga click <a href="reservar.php">AQUÍ</a> para reservar.</p>
    			</div>
            	<div id="todook" class="alert alert-dismissable alert-success" style="display:none;">
      				<p>Estimad@ <strong id="nombrecli"></strong>, <br>
      				Tu CODIGO DE RESERVA es <strong id="codcli"></strong>. También hemos enviado el código de reserva a tu correo.</p>
    			</div>
				<form id="consultarcodform" class="form-horizontal" role="form" action="consultarcodform.php" method="post">
				  	<div class="form-group">
				    	<label for="dni" class="col-sm-3 control-label">DNI</label>
				    	<div class="col-sm-9">
				    		<div class="row">
				    			<div class="col-sm-3">
				      				<input type="text" class="form-control validate[required,custom[onlyNumberSp],maxSize[8],minSize[8]]" id="dni" name="dni" placeholder="DNI">
				      			</div>
				      			<label for="celular" class="col-sm-3 control-label">Celular</label>
				      			<div class="col-sm-3">
				      				<input type="text" class="form-control validate[required,custom[onlyNumberSp],maxSize[9],minSize[9]]" id="celular" name="celular" placeholder="999999999">
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
				      		</div>
				    	</div>
				  	</div>
				  	<div class="form-group">
				    	<div class="col-sm-offset-3 col-sm-9">
				    		<span id='error_captcha' class='help-block' style="display:none;">Captcha Incorrecto :(</span>			            	
			        		<label>
			          			<?php 
			          				echo recaptcha_get_html($publickey, $error); 
			          			?>
			        		</label>
				    	</div>
				  	</div>
				  	<div class="form-group">
				    	<div class="col-sm-offset-3 col-sm-9">
				      		<button id="btn-consultarcod" type="button" class="btn btn-primary">Consultar</button>
				    	</div>
				  	</div>
				</form>
			</div>
		</div>
	</div>
<?php include 'footer.php'; ?>	