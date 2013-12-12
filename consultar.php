<?php 
	$title = "Consultar - ";
	include 'header.php'; 
?>
	<header class="navbar navbar-inverse navbar-fixed-top dnavbar" role="banner">
		<div class="container">
			<nav class="collapse navbar-collapse dnavbar-collapse" role="navigation">
				<!-- Collect the nav links, forms, and other content for toggling -->
			    <ul class="nav navbar-nav">
			    	<li><a href="/promosmartphonecubot/">Inicio</a></li>
			    	<li><a href="especificaciones.php">Especificaciones Técnicas</a></li>
			      	<li><a href="reservar.php">Reservar</a></li>
			      	<li class="active"><a href="consultar.php">Consultar</a></li>
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
					echo '<div class="alert alert-dismissable alert-success">
              				<button type="button" class="close" data-dismiss="alert">×</button>
              				<strong>¡Maravilloso!</strong> Tu consulta ha sido realizada con éxito.
            		</div>';}
            	?>
				<p>Antes de hacer tu consulta puedes verificar en la sección de <a href="faqs.html">PREGUNTAS FRECUENTES</a>.</p>
				<form class="form-horizontal" role="form" action="consultarform.php" method="post">
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
				      				<input type="text" class="form-control validate[required,custom[number],maxSize[8],minSize[8]]" id="dni" name="dni" placeholder="DNI">
				      			</div>
				      			<label for="celular" class="col-sm-3 control-label">Celular</label>
				      			<div class="col-sm-3">
				      				<input type="text" class="form-control validate[required,custom[number],,maxSize[9],minSize[9]]" id="celular" name="celular" placeholder="999999999">
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
				    	<label for="selectConsulta" class="col-sm-3 control-label">Tipo de Consulta</label>
				    	<div class="col-sm-9">
				    		<select id="selectConsulta" name="selectConsulta" class="form-control">
				      			<option value="1">Sobre la mecánica de la Promoción</option>
				      			<option value="2">Sobre el Celular</option>
				      			<option value="3">Otros</option>
				      		</select>
				    	</div>
				  	</div>
				  	<div class="form-group">
				    	<label for="consulta" class="col-sm-3 control-label">Consulta</label>
				    	<div class="col-sm-9">
				    		<textarea id="consulta" name="consulta" class="form-control validate[required]"></textarea>
				    	</div>
				  	</div>
				  	<div class="form-group">
				    	<div class="col-sm-offset-3 col-sm-9">
				      		<button type="submit" class="btn btn-primary">Enviar</button>
				    	</div>
				  	</div>
				</form>
			</div>
		</div>
	</div>
<?php include 'footer.php'; ?>	