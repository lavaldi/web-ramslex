<footer>
		<div class="container">
			<p>
				Promoción del GRUPO RAMSLEX TECHNOLOGIES, válida en Trujillo para canje de los Smartphone Marca CUBOT, modelos GT90, P9 y GT99. Promoción válida únicamente para mayores de edad. Para realizar el canje, previamente se debe realizar la reserva del equipo ingresando a la sección de <a href="reservar.php">RESERVAS</a> desde el jueves 12 al martes 17 de diciembre del 2013, completando el formulario con los datos requeridos, de esta manera automáticamente obtendrá su código de reserva, el cual deberá imprimirlo. Puede completar el formulario de reserva desde el jueves 12 al martes 17 de diciembre del 2013 o hasta agotar stock de 1,000 reservas por modelo de Smartphone CUBOT y recibirá un código de reserva al correo de su referencia, el cual deberá imprimir, y ser presentado junto con su voucher de pago para el canje desde el lunes 23 al martes 31 de diciembre del 2013, en los centros de canje indicados, una vez haya recibido un correo electrónico, el cual será enviado desde el 18 de diciembre del 2013, confirmando la fecha y el centro de canje. Stock limitado de productos: 1,000 unidades por modelo. Stock limitado de reservas: 1,000 unidades por modelo. El GRUPO RAMSLEX TECHNOLOGIES, se reserva el derecho de cancelar parcial o totalmente LA PROMOCIÓN si por causas de fuerza mayor, o cualesquiera otras ajenas a su voluntad, fuera necesario. Una vez comprado el producto no hay lugar a devolución del dinero. La participación en esta promoción supone la aceptación por parte del participante de la totalidad de los términos y condiciones de LA PROMOCIÓN.
			</p>
			<p>
				Todos los derechos reservados © 2013 <a href="/promosmartphonecubot/">www.ramslex.com</a>.
				<span style="float:right;"><a href="bases_legales.pdf">Bases legales de la promoción</a></span>
			</p>
		</div>
	</footer>
	<script type="text/javascript" src="js/jquery-1.10.2.js"></script>
	<script type="text/javascript" src="js/bootstrap.js"></script>
	<script type="text/javascript" src="js/jquery.bootstrap.wizard.js"></script>
	<script type="text/javascript" src="js/bootstrap-datepicker.js"></script>
	<script type="text/javascript" src="js/bootstrap-timepicker.js"></script>
	<script type="text/javascript" src="js/jquery.validationEngine-es.js"></script>
	<script type="text/javascript" src="js/jquery.validationEngine.js"></script>
	<script>
		$(document).ready(function(){
			$('.carousel').carousel({
				interval: false
			});
			$("form").validationEngine();

			$(".timepicker").timepicker({
               	minuteStep: 1,
               	secondStep: 1,
               	showSeconds: true,
                showMeridian: false,
                showInputs: false,
                disableFocus: true
            });

			var nowTemp = new Date();
			var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);
			$(".datepicker").datepicker({
				format: "dd-mm-yyyy",
				onRender: function(date) {
		            return date.valueOf() > now.valueOf() ? "disabled" : "";
		        }
			});
			$("#rootwizard").bootstrapWizard({
				onNext: function(tab, navigation, index) {
					if(index==1) {
						$("#distrito").val($("#distritoSelect").val());
					}
				
					if (index==2) {
						var bande = false;
						if($("#reservarform").validationEngine('validate')){
							//console.log($("#reservarform").serialize());
							var enviarreserva = $.ajax({
								type: "post",
								async: false,
								url: "reservarform.php",
								data: {'formulario':$("#reservarform").serialize()}
							});
							enviarreserva.done(function(data){
								data = $.parseJSON(data);
								if (data.band==true) {
									$("#tagnombre").text($("#nombres").val());
									$("#tagcodigo").text(data.cod);
									$("#tagcorreo").text($("#email").val());
									$(".previous").css("display","none");
								}
								else{
									bande = true;
									$("#error_captcha").text(data.msj);
								}
							});
							enviarreserva.error(function(){
								bande = true;
							});
						}
						else{
							bande = true;
						}
						if (bande) return false;
					}
				
				}, 
				onTabShow: function(tab, navigation, index) {
					var $total = navigation.find("li").length;
					var $current = index+1;
					var $percent = ($current/$total) * 100;
					$("#rootwizard").find(".progress-bar").css({width:$percent+"%"});
				},
				onTabClick: function(tab, navigation, index) {
					return false;
				}
			});
			$("#rootwizard-1").bootstrapWizard({
				onNext: function(tab, navigation, index) {
					if(index==1) {
						//$("#codigo").validationEngine();
						if(!$('#codigo').val()) {
							$("#sincodigo").text("¡Tienes que poner el código!");
							$('#codigo').focus();
							return false;
						}
						else
							$("#codigoreserva").val("TRUJ-RX-"+$("#codigo").val());
					}
				
					if (index==2) {
						var bande = false;
						if($("#confirmacionform").validationEngine('validate')){
							//console.log($("#reservarform").serialize());
							var enviarconfirmacion = $.ajax({
								type: "post",
								async: false,
								url: "confirmacionform.php",
								data: {'formulario':$("#confirmacionform").serialize()}
							});
							enviarconfirmacion.done(function(data){
								console.log(data);
								data = $.parseJSON(data);
								if (data.band==true) {
									$("#datos").text(data.msj);
								}
								else{
									bande = true;
									$("#error_captcha").text(data.msj);
								}
							});
							enviarconfirmacion.error(function(){
								bande = true;
							});
						}
						else{
							bande = true;
						}
						if (bande) return false;
					}
				
				}, 
				onTabShow: function(tab, navigation, index) {
					var $total = navigation.find("li").length;
					var $current = index+1;
					var $percent = ($current/$total) * 100;
					$("#rootwizard").find(".progress-bar").css({width:$percent+"%"});
				},
				onTabClick: function(tab, navigation, index) {
					return false;
				}
			});
		});
	</script>
</body>
</html>