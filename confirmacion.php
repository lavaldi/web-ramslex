<?php 
	$title = "Confirmación de Pago - ";
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
				<p>Ingresa los datos de la transacción bancaria que a continuación solicitamos:</p>
				<form class="form-horizontal" role="form" action="confirmacionform.php" method="post">
				  	<div class="form-group">
				    	<label for="cod" class="col-sm-3 control-label">Código de Reserva</label>
				    	<div class="col-sm-9">
				    		<div class="row">
				    			<div class="col-sm-3">
				      				<input type="text" class="form-control validate[required,maxSize[15],minSize[9]]" id="cod" name="cod">
				      			</div>
				      			<label for="ope" class="col-sm-3 control-label">N° de Operación</label>
				      			<div class="col-sm-3">
				      				<input type="text" class="form-control validate[required,custom[onlyNumberSp]]" id="ope" name="ope">
				      			</div>
				      		</div>
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
				    	<div class="col-sm-offset-3 col-sm-9">
				      		<button type="submit" class="btn btn-primary">Enviar</button>
				    	</div>
				  	</div>
				</form>
			</div>
		</div>
	</div>
<?php include 'footer.php'; ?>