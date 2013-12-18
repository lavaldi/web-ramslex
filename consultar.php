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
					<h2>Consultar</h2>
				</div>
				<?php if(isset($_GET['band'])){
					if ($_GET['band'] == true) {
						echo '<div class="alert alert-dismissable alert-success">
	              				<button type="button" class="close" data-dismiss="alert">×</button>
	              				<strong>¡Maravilloso!</strong> Tu consulta ha sido realizada con éxito.
	            		</div>';
	            	}
	            }?>
				<p>Antes de hacer tu consulta puedes verificar en la sección de <a href="faqs.php">PREGUNTAS FRECUENTES</a>.</p>
				<form class="form-horizontal" role="form" action="consultarform.php" method="post">
					<div class="col-sm-6">
					  	<div class="form-group">
					    	<label for="nombres" class="col-sm-4 control-label">Nombres</label>
					    	<div class="col-sm-8">
				      			<input type="text" class="form-control validate[required,custom[onlyLetterSp]]" id="nombres" name="nombres" placeholder="Nombres">
					    	</div>
					  	</div>
					  	<div class="form-group">
					  		<label for="apellidos" class="col-sm-4 control-label">Apellidos</label>
			      			<div class="col-sm-8">
			      				<input type="text" class="form-control validate[required,custom[onlyLetterSp]]" id="apellidos" name="apellidos" placeholder="Apellidos">
			      			</div>
			      		</div>
					  	<div class="form-group">
					    	<label for="dni" class="col-sm-4 control-label">DNI</label>
					    	<div class="col-sm-8">
					      		<input type="text" class="form-control validate[required,custom[onlyNumberSp],maxSize[8],minSize[8]]" id="dni" name="dni" placeholder="DNI">
					      	</div>
					  	</div>
					  	<div class="form-group">
					  		<label for="celular" class="col-sm-4 control-label">Celular</label>
			      			<div class="col-sm-8">
			      				<input type="text" class="form-control validate[required,custom[onlyNumberSp],maxSize[9],minSize[9]]" id="celular" name="celular" placeholder="999999999">
			      			</div>
					  	</div>
					  	<div class="form-group">
					    	<label for="email" class="col-sm-4 control-label">Email</label>
					    	<div class="col-sm-8">
					      		<input type="text" class="form-control validate[required,custom[email]]" id="email" name="email" placeholder="tu@email.com">
					    	</div>
					  	</div>
					  	<div class="form-group">
					  		<label for="conf-email" class="col-sm-4 control-label">Confirmar Email</label>
			      			<div class="col-sm-8">
			      				<input type="text" class="form-control validate[required,equals[email]]" id="conf-email" name="conf-email">
			      			</div>
					  	</div>
					  	<div class="form-group">
					    	<label for="selectConsulta" class="col-sm-4 control-label">Tipo de Consulta</label>
					    	<div class="col-sm-8">
					    		<select id="selectConsulta" name="selectConsulta" class="form-control validate[required]">
					      			<option value="1">Sobre la mecánica de la Promoción</option>
					      			<option value="2">Sobre el Celular</option>
					      			<option value="3">Sobre envíos a provincia</option>
					      			<option value="4">Otros</option>
					      		</select>
					    	</div>
					  	</div>
					  	<div class="form-group">
					    	<label for="consulta" class="col-sm-4 control-label">Consulta</label>
					    	<div class="col-sm-8">
					    		<textarea id="consulta" name="consulta" class="form-control validate[required]" rows="6"></textarea>
					    	</div>
					  	</div>
					  	<div class="form-group">
					    	<div class="col-sm-offset-4 col-sm-8">
					    		<?php if(isset($_GET['band'])){
									if ($_GET['band'] == false) {
										echo "<span id='error_captcha' class='help-block'>Captcha Incorrecto :(</span>";
				            		}	
								}?>
				        		<label>
				          			<?php 
				          				echo recaptcha_get_html($publickey, $error); 
				          			?>
				        		</label>
					    	</div>
					  	</div>
					  	<div class="form-group">
					    	<div class="col-sm-offset-4 col-sm-8">
					      		<button type="submit" class="btn btn-primary">Consultar</button>
					    	</div>
					  	</div>
					</div>
					<div class="col-sm-5 col-sm-offset-1">
			    		<figure>
						  	<a href="consultarcod.php"><img src="img/consulta.png" alt="Promoción Cubot"></a>
						</figure>
			    	</div>
				</form>
			</div>
		</div>
	</div>
<?php include 'footer.php'; ?>	