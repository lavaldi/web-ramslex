<?php
	require_once("db_conf.php");
	require_once('recaptcha/recaptchalib.php');

	function getCode(){
        $code = '' ;
        $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ023456789"; 
        srand((double)microtime()*1000000); 
        for ($i=0;$i<6;$i++) { 
	        $num = rand()%20; 
	        $tmp = substr($chars, $num, 1); 
	        $code = $code.$tmp; 
        }
        $code = "TRUJ-RX-".$code;
    	return $code; 
    }
	
	$band 			= 	false;
	$success 		= 	true;
	$envio 			= 	array();

	$publickey 		= 	"6Lct8esSAAAAAF-dHVtfJ2mcq3jLbdNN_D0mHtEf";
	$privatekey 	= 	"6Lct8esSAAAAADh5eKdnTJ-5MD9sBO-oL3NX0-a5";
	$error 			= 	null;

	$formulario		= 	$_REQUEST['formulario'];
	$datos			= 	array();

	parse_str($formulario,$datos);

	$cod_equip		= 	$datos['selectEquip'];
	$nombres		=	$datos['nombres']; 
	$apellidos		= 	$datos['apellidos'];
	$dni			=	$datos['dni'];
	$sexo			=	$datos['sexo'];
	$telefono		=	$datos['telefono'];
	$distrito		= 	$datos['distrito'];
	$mail 			=	$datos['email'];
	$conf_email		=	$datos['conf-email'];
	$notificaciones	=	'';
	$kingston		=	'';
	$equipo 		= 	'';
	$monto			=	0;

	if ($datos["recaptcha_response_field"]) {
        $resp = recaptcha_check_answer ($privatekey,
            $_SERVER["REMOTE_ADDR"],
            $datos["recaptcha_challenge_field"],
            $datos["recaptcha_response_field"]);

        if ($resp->is_valid) {
                $band = true;
        } else {
                $band = false;
        }
	}

	if ($band) {
		
		switch ($cod_equip) {
			case '1':
				$equipo = 'Cubot GT90';
				$monto 	= 299; 
				break;
			case '2':
				$equipo = 'Cubot P9';
				$monto 	= 369; 
				break;
			case '3':
				$equipo = 'Cubot GT99';
				$monto 	= 569; 
				break;
			case '4':
				$equipo = 'Cubot One';
				$monto 	= 659; 
				break;
		}

		if (isset($datos['notificaciones'])){
			$notificaciones = 'si';
		}
		else{
			$notificaciones = 'no';
		}

		if (isset($datos['kingston'])){
			$kingston = 'si';
			$monto = $monto + 20;
		}
		else{
			$kingston = 'no';
		}

		// servidor, usuario, contrasenia
		$conexion = mysqli_connect ($server, $user, $password) or die ("No se puede conectar con el servidor"); 
		mysqli_select_db ($conexion,$dbname) or die ("No se puede seleccionar la base de datos"); 

		mysqli_autocommit($conexion,FALSE);

		do{
			$code = getCode();
			$instruccion3 = "SELECT codigoreserva FROM reservas WHERE codigoreserva='".$code."'";
			$consulta3 = mysqli_fetch_array(mysqli_query($conexion,$instruccion3),MYSQLI_ASSOC);
		} while($consulta3['codigoreserva'] != null);

	    $fecha = date ("Y-m-d"); // Fecha actual
	    $instruccion = "INSERT into reservas (fecha, nombres, apellidos, equipo, monto, dni, sexo, telefono, distrito, correo, notificaciones, kingston, codigoreserva) VALUES ('".$fecha."','".$nombres."', '".$apellidos."', '".$equipo."', '".$monto."', '".$dni."', '".$sexo."', '".$telefono."', '".$distrito."', '".$mail."', '".$notificaciones."','".$kingston."', '".$code."')";
	    $consulta = mysqli_query($conexion,$instruccion);

	    if(!$consulta){
	    	$success = false;
	    	$envio =  array('band'=>false,'cod'=>$code, 'msj'=>'Uno de los datos ingresados ya se encuentra registrado.');
	    }
   		else{

		    $envio =  array('band'=>$band,'cod'=>$code);
	    	$mensaje		=	'
	    	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
			<html xmlns="http://www.w3.org/1999/xhtml">
			    <head>
			    	<!-- NAME: 1 COLUMN -->
			        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
			        <meta name="viewport" content="width=device-width, initial-scale=1.0">
			        <title>*|MC:SUBJECT|*</title>
			        
			        <!--[if gte mso 6]>
			        <style>
			            table.mcnFollowContent {width:100% !important;}
			            table.mcnShareContent {width:100% !important;}
			        </style>
			        <![endif]-->
			    <style type="text/css">
					body,#bodyTable,#bodyCell{
						height:100% !important;
						margin:0;
						padding:0;
						width:100% !important;
					}
					table{
						border-collapse:collapse;
					}
					img,a img{
						border:0;
						outline:none;
						text-decoration:none;
					}
					h1,h2,h3,h4,h5,h6{
						margin:0;
						padding:0;
					}
					p{
						margin:1em 0;
						padding:0;
					}
					a{
						word-wrap:break-word;
					}
					.ReadMsgBody{
						width:100%;
					}
					.ExternalClass{
						width:100%;
					}
					.ExternalClass,.ExternalClass p,.ExternalClass span,.ExternalClass font,.ExternalClass td,.ExternalClass div{
						line-height:100%;
					}
					table,td{
						mso-table-lspace:0pt;
						mso-table-rspace:0pt;
					}
					#outlook a{
						padding:0;
					}
					img{
						-ms-interpolation-mode:bicubic;
					}
					body,table,td,p,a,li,blockquote{
						-ms-text-size-adjust:100%;
						-webkit-text-size-adjust:100%;
					}
					#bodyCell{
						padding:20px;
					}
					.mcnImage{
						vertical-align:bottom;
					}
					.mcnTextContent img{
						height:auto !important;
					}
					body,#bodyTable{
						background-color:#F2F2F2;
					}
					#bodyCell{
						border-top:0;
					}
					#templateContainer{
						border:0;
					}
					h1{
						color:#606060 !important;
						display:block;
						font-family:Helvetica;
						font-size:40px;
						font-style:normal;
						font-weight:bold;
						line-height:125%;
						letter-spacing:-1px;
						margin:0;
						text-align:left;
					}
					h2{
						color:#404040 !important;
						display:block;
						font-family:Helvetica;
						font-size:26px;
						font-style:normal;
						font-weight:bold;
						line-height:125%;
						letter-spacing:-.75px;
						margin:0;
						text-align:left;
					}
					h3{
						color:#606060 !important;
						display:block;
						font-family:Helvetica;
						font-size:18px;
						font-style:normal;
						font-weight:bold;
						line-height:125%;
						letter-spacing:-.5px;
						margin:0;
						text-align:left;
					}
					h4{
						color:#808080 !important;
						display:block;
						font-family:Helvetica;
						font-size:16px;
						font-style:normal;
						font-weight:bold;
						line-height:125%;
						letter-spacing:normal;
						margin:0;
						text-align:left;
					}
					#templatePreheader{
						background-color:#FFFFFF;
						border-top:0;
						border-bottom:0;
					}
					.preheaderContainer .mcnTextContent,.preheaderContainer .mcnTextContent p{
						color:#606060;
						font-family:Helvetica;
						font-size:11px;
						line-height:125%;
						text-align:left;
					}
					.preheaderContainer .mcnTextContent a{
						color:#606060;
						font-weight:normal;
						text-decoration:underline;
					}
					#templateHeader{
						background-color:#FFFFFF;
						border-top:0;
						border-bottom:0;
					}
					.headerContainer .mcnTextContent,.headerContainer .mcnTextContent p{
						color:#606060;
						font-family:Helvetica;
						font-size:15px;
						line-height:150%;
						text-align:left;
					}
					.headerContainer .mcnTextContent a{
						color:#6DC6DD;
						font-weight:normal;
						text-decoration:underline;
					}
					#templateBody{
						background-color:#FFFFFF;
						border-top:0;
						border-bottom:0;
					}
					.bodyContainer .mcnTextContent,.bodyContainer .mcnTextContent p{
						color:#606060;
						font-family:Helvetica;
						font-size:15px;
						line-height:150%;
						text-align:left;
					}
					.bodyContainer .mcnTextContent a{
						color:#6DC6DD;
						font-weight:normal;
						text-decoration:underline;
					}
					#templateFooter{
						background-color:#FFFFFF;
						border-top:0;
						border-bottom:0;
					}
					.footerContainer .mcnTextContent,.footerContainer .mcnTextContent p{
						color:#606060;
						font-family:Helvetica;
						font-size:11px;
						line-height:125%;
						text-align:left;
					}
					.footerContainer .mcnTextContent a{
						color:#606060;
						font-weight:normal;
						text-decoration:underline;
					}
				@media only screen and (max-width: 480px){
					body,table,td,p,a,li,blockquote{
						-webkit-text-size-adjust:none !important;
					}

			}	@media only screen and (max-width: 480px){
					body{
						width:100% !important;
						min-width:100% !important;
					}

			}	@media only screen and (max-width: 480px){
					td[id=bodyCell]{
						padding:10px !important;
					}

			}	@media only screen and (max-width: 480px){
					table[class=mcnTextContentContainer]{
						width:100% !important;
					}

			}	@media only screen and (max-width: 480px){
					table[class=mcnBoxedTextContentContainer]{
						width:100% !important;
					}

			}	@media only screen and (max-width: 480px){
					table[class=mcpreview-image-uploader]{
						width:100% !important;
						display:none !important;
					}

			}	@media only screen and (max-width: 480px){
					img[class=mcnImage]{
						width:100% !important;
					}

			}	@media only screen and (max-width: 480px){
					table[class=mcnImageGroupContentContainer]{
						width:100% !important;
					}

			}	@media only screen and (max-width: 480px){
					td[class=mcnImageGroupContent]{
						padding:9px !important;
					}

			}	@media only screen and (max-width: 480px){
					td[class=mcnImageGroupBlockInner]{
						padding-bottom:0 !important;
						padding-top:0 !important;
					}

			}	@media only screen and (max-width: 480px){
					tbody[class=mcnImageGroupBlockOuter]{
						padding-bottom:9px !important;
						padding-top:9px !important;
					}

			}	@media only screen and (max-width: 480px){
					table[class=mcnCaptionTopContent],table[class=mcnCaptionBottomContent]{
						width:100% !important;
					}

			}	@media only screen and (max-width: 480px){
					table[class=mcnCaptionLeftTextContentContainer],table[class=mcnCaptionRightTextContentContainer],table[class=mcnCaptionLeftImageContentContainer],table[class=mcnCaptionRightImageContentContainer],table[class=mcnImageCardLeftTextContentContainer],table[class=mcnImageCardRightTextContentContainer]{
						width:100% !important;
					}

			}	@media only screen and (max-width: 480px){
					td[class=mcnImageCardLeftImageContent],td[class=mcnImageCardRightImageContent]{
						padding-right:18px !important;
						padding-left:18px !important;
						padding-bottom:0 !important;
					}

			}	@media only screen and (max-width: 480px){
					td[class=mcnImageCardBottomImageContent]{
						padding-bottom:9px !important;
					}

			}	@media only screen and (max-width: 480px){
					td[class=mcnImageCardTopImageContent]{
						padding-top:18px !important;
					}

			}	@media only screen and (max-width: 480px){
					td[class=mcnImageCardLeftImageContent],td[class=mcnImageCardRightImageContent]{
						padding-right:18px !important;
						padding-left:18px !important;
						padding-bottom:0 !important;
					}

			}	@media only screen and (max-width: 480px){
					td[class=mcnImageCardBottomImageContent]{
						padding-bottom:9px !important;
					}

			}	@media only screen and (max-width: 480px){
					td[class=mcnImageCardTopImageContent]{
						padding-top:18px !important;
					}

			}	@media only screen and (max-width: 480px){
					table[class=mcnCaptionLeftContentOuter] td[class=mcnTextContent],table[class=mcnCaptionRightContentOuter] td[class=mcnTextContent]{
						padding-top:9px !important;
					}

			}	@media only screen and (max-width: 480px){
					td[class=mcnCaptionBlockInner] table[class=mcnCaptionTopContent]:last-child td[class=mcnTextContent]{
						padding-top:18px !important;
					}

			}	@media only screen and (max-width: 480px){
					td[class=mcnBoxedTextContentColumn]{
						padding-left:18px !important;
						padding-right:18px !important;
					}

			}	@media only screen and (max-width: 480px){
					td[class=mcnTextContent]{
						padding-right:18px !important;
						padding-left:18px !important;
					}

			}	@media only screen and (max-width: 480px){
					table[id=templateContainer],table[id=templatePreheader],table[id=templateHeader],table[id=templateBody],table[id=templateFooter]{
						max-width:600px !important;
						width:100% !important;
					}

			}	@media only screen and (max-width: 480px){
					h1{
						font-size:24px !important;
						line-height:125% !important;
					}

			}	@media only screen and (max-width: 480px){
					h2{
						font-size:20px !important;
						line-height:125% !important;
					}

			}	@media only screen and (max-width: 480px){
					h3{
						font-size:18px !important;
						line-height:125% !important;
					}

			}	@media only screen and (max-width: 480px){
					h4{
						font-size:16px !important;
						line-height:125% !important;
					}

			}	@media only screen and (max-width: 480px){
					table[class=mcnBoxedTextContentContainer] td[class=mcnTextContent],td[class=mcnBoxedTextContentContainer] td[class=mcnTextContent] p{
						font-size:18px !important;
						line-height:125% !important;
					}

			}	@media only screen and (max-width: 480px){
					table[id=templatePreheader]{
						display:block !important;
					}

			}	@media only screen and (max-width: 480px){
					td[class=preheaderContainer] td[class=mcnTextContent],td[class=preheaderContainer] td[class=mcnTextContent] p{
						font-size:14px !important;
						line-height:115% !important;
					}

			}	@media only screen and (max-width: 480px){
					td[class=headerContainer] td[class=mcnTextContent],td[class=headerContainer] td[class=mcnTextContent] p{
						font-size:18px !important;
						line-height:125% !important;
					}

			}	@media only screen and (max-width: 480px){
					td[class=bodyContainer] td[class=mcnTextContent],td[class=bodyContainer] td[class=mcnTextContent] p{
						font-size:18px !important;
						line-height:125% !important;
					}

			}	@media only screen and (max-width: 480px){
					td[class=footerContainer] td[class=mcnTextContent],td[class=footerContainer] td[class=mcnTextContent] p{
						font-size:14px !important;
						line-height:115% !important;
					}

			}	@media only screen and (max-width: 480px){
					td[class=footerContainer] a[class=utilityLink]{
						display:block !important;
					}

			}</style></head>
			    <body leftmargin="0" marginwidth="0" topmargin="0" marginheight="0" offset="0" style="margin: 0;padding: 0;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;background-color: #F2F2F2;height: 100% !important;width: 100% !important;">
			        <center>
			            <table align="center" border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" id="bodyTable" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;margin: 0;padding: 0;background-color: #F2F2F2;height: 100% !important;width: 100% !important;">
			                <tr>
			                    <td align="center" valign="top" id="bodyCell" style="mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;margin: 0;padding: 20px;border-top: 0;height: 100% !important;width: 100% !important;">
			                        <!-- BEGIN TEMPLATE // -->
			                        <table border="0" cellpadding="0" cellspacing="0" width="600" id="templateContainer" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;border: 0;">
			                            <tr>
			                                <td align="center" valign="top" style="mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
			                                    <!-- BEGIN PREHEADER // -->
			                                    <table border="0" cellpadding="0" cellspacing="0" width="600" id="templatePreheader" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;background-color: #FFFFFF;border-top: 0;border-bottom: 0;">
			                                        <tr>
			                                        	<td valign="top" class="preheaderContainer" style="padding-top: 9px;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;"><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnTextBlock" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
			    <tbody class="mcnTextBlockOuter">
			        <tr>
			            <td valign="top" class="mcnTextBlockInner" style="mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
			                
			                <table align="left" border="0" cellpadding="0" cellspacing="0" width="366" class="mcnTextContentContainer" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
			                    <tbody><tr>
			                        
			                        <td valign="top" class="mcnTextContent" style="padding-top: 9px;padding-left: 18px;padding-bottom: 9px;padding-right: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;color: #606060;font-family: Helvetica;font-size: 11px;line-height: 125%;text-align: left;">
			                        
			                            Mensaje de Reserva - Promoción Cubot
			                        </td>
			                    </tr>
			                </tbody></table>
			                
			                <table align="right" border="0" cellpadding="0" cellspacing="0" width="197" class="mcnTextContentContainer" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
			                    <tbody><tr>
			                        
			                        <td valign="top" class="mcnTextContent" style="padding-top: 9px;padding-right: 18px;padding-bottom: 9px;padding-left: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;color: #606060;font-family: Helvetica;font-size: 11px;line-height: 125%;text-align: left;">
			                        </td>
			                    </tr>
			                </tbody></table>
			                
			            </td>
			        </tr>
			    </tbody>
			</table></td>
			                                        </tr>
			                                    </table>
			                                    <!-- // END PREHEADER -->
			                                </td>
			                            </tr>
			                            <tr>
			                                <td align="center" valign="top" style="mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
			                                    <!-- BEGIN HEADER // -->
			                                    <table border="0" cellpadding="0" cellspacing="0" width="600" id="templateHeader" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;background-color: #FFFFFF;border-top: 0;border-bottom: 0;">
			                                        <tr>
			                                            <td valign="top" class="headerContainer" style="mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;"><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnImageBlock" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
			    <tbody class="mcnImageBlockOuter">
			            <tr>
			                <td valign="top" style="padding: 9px;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" class="mcnImageBlockInner">
			                    <table align="left" width="100%" border="0" cellpadding="0" cellspacing="0" class="mcnImageContentContainer" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
			                        <tbody><tr>
			                            <td class="mcnImageContent" valign="top" style="padding-right: 9px;padding-left: 9px;padding-top: 0;padding-bottom: 0;text-align: center;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
			                                
			                                    
			                                        <img align="center" alt="" src="https://gallery.mailchimp.com/a8a9d65aaa25fda05571239e7/images/logoramslex.1.png" width="319" style="max-width: 319px;padding-bottom: 0;display: inline !important;vertical-align: bottom;border: 0;outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;" class="mcnImage">
			                                    
			                                
			                            </td>
			                        </tr>
			                    </tbody></table>
			                </td>
			            </tr>
			    </tbody>
			</table><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnDividerBlock" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
			    <tbody class="mcnDividerBlockOuter">
			        <tr>
			            <td class="mcnDividerBlockInner" style="padding: 0px 18px;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
			                <table class="mcnDividerContent" border="0" cellpadding="0" cellspacing="0" width="100%" style="border-top-width: 5px;border-top-style: solid;border-top-color: #004A90;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
			                    <tbody><tr>
			                        <td style="mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
			                            <span></span>
			                        </td>
			                    </tr>
			                </tbody></table>
			            </td>
			        </tr>
			    </tbody>
			</table></td>
			                                        </tr>
			                                    </table>
			                                    <!-- // END HEADER -->
			                                </td>
			                            </tr>
			                            <tr>
			                                <td align="center" valign="top" style="mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
			                                    <!-- BEGIN BODY // -->
			                                    <table border="0" cellpadding="0" cellspacing="0" width="600" id="templateBody" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;background-color: #FFFFFF;border-top: 0;border-bottom: 0;">
			                                        <tr>
			                                            <td valign="top" class="bodyContainer" style="mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;"><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnTextBlock" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
			    <tbody class="mcnTextBlockOuter">
			        <tr>
			            <td valign="top" class="mcnTextBlockInner" style="mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
			                
			                <table align="left" border="0" cellpadding="0" cellspacing="0" width="600" class="mcnTextContentContainer" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
			                    <tbody><tr>
			                        
			                        <td valign="top" class="mcnTextContent" style="padding-top: 9px;padding-right: 18px;padding-bottom: 9px;padding-left: 18px;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;color: #606060;font-family: Helvetica;font-size: 15px;line-height: 150%;text-align: left;">
			                        
			                            <h1 style="margin: 0;padding: 0;display: block;font-family: Helvetica;font-size: 40px;font-style: normal;font-weight: bold;line-height: 125%;letter-spacing: -1px;text-align: left;color: #606060 !important;"><span style="font-size: 13px; line-height: 1.6em;">Hola '.$nombres.', tu reserva se ha realizado con éxito!</span></h1>

			<p style="margin: 1em 0;padding: 0;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;color: #606060;font-family: Helvetica;font-size: 15px;line-height: 150%;text-align: left;">
			Tus Datos son:<br>
			<strong>Equipo reservado: </strong> '.$equipo.'<br>
			<strong>Memoria MicroSD 16GB Kingston: </strong> '.$kingston.'<br>
			<strong>Total a PAGAR (S/.): </strong> '.$monto.'<br>
			<strong>Nombre: </strong> '.$nombres.' '.$apellidos.'<br>
			<strong>DNI: </strong> '.$dni.'<br>
			<strong>Sexo: </strong> '.$sexo.'<br>
			<strong>N° de Teléfono o Celular: </strong> '.$telefono.'<br>
			<strong>Correo: </strong> '.$mail.'</p>
			                        </td>
			                    </tr>
			                </tbody></table>
			                
			            </td>
			        </tr>
			    </tbody>
			</table><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnButtonBlock" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
			    <tbody class="mcnButtonBlockOuter">
			        <tr>
			            <td style="padding-top: 0;padding-right: 18px;padding-bottom: 18px;padding-left: 18px;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" valign="top" align="center" class="mcnButtonBlockInner">
			                <table border="0" cellpadding="0" cellspacing="0" class="mcnButtonContentContainer" style="border-top-left-radius: 5px;border-top-right-radius: 5px;border-bottom-right-radius: 5px;border-bottom-left-radius: 5px;background-color: #D0BF91;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
			                    <tbody>
			                        <tr>
			                            <td align="center" valign="middle" class="mcnButtonContent" style="font-family: Arial;font-size: 16px;padding: 15px;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
			                                <a class="mcnButton " title="Código de Reserva: TRUJ-RX-GRFDTG" href="http://" target="_self" style="font-weight: bold;letter-spacing: -0.5px;line-height: 100%;text-align: center;text-decoration: none;color: #FFFFFF;word-wrap: break-word;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">Código de Reserva: '.$code.'</a>
			                            </td>
			                        </tr>
			                    </tbody>
			                </table>
			            </td>
			        </tr>
			    </tbody>
			</table><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnDividerBlock" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
			    <tbody class="mcnDividerBlockOuter">
			        <tr>
			            <td class="mcnDividerBlockInner" style="padding: 0px 18px;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
			                <table class="mcnDividerContent" border="0" cellpadding="0" cellspacing="0" width="100%" style="border-top-width: 5px;border-top-style: solid;border-top-color: #004A90;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
			                    <tbody><tr>
			                        <td style="mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
			                            <span></span>
			                        </td>
			                    </tr>
			                </tbody></table>
			            </td>
			        </tr>
			    </tbody>
			</table></td>
			                                        </tr>
			                                    </table>
			                                    <!-- // END BODY -->
			                                </td>
			                            </tr>
			                            <tr>
			                                <td align="center" valign="top" style="mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
			                                    <!-- BEGIN FOOTER // -->
			                                    <table border="0" cellpadding="0" cellspacing="0" width="600" id="templateFooter" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;background-color: #FFFFFF;border-top: 0;border-bottom: 0;">
			                                        <tr>
			                                            <td valign="top" class="footerContainer" style="padding-bottom: 9px;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;"><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnTextBlock" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
			    <tbody class="mcnTextBlockOuter">
			        <tr>
			            <td valign="top" class="mcnTextBlockInner" style="mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
			                
			                <table align="left" border="0" cellpadding="0" cellspacing="0" width="600" class="mcnTextContentContainer" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
			                    <tbody><tr>
			                        
			                        <td valign="top" class="mcnTextContent" style="padding: 9px 18px;text-align: center;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;color: #606060;font-family: Helvetica;font-size: 11px;line-height: 125%;">
			                        	<strong>NO RESPONDER ESTE MENSAJE</strong><br>
			                            <em>Copyright © RAMSLEX ENGINEERING SOLUTIONS, All rights reserved.</em><br>
			<br>
			<strong>Nuestra Dirección es:</strong><br>
			Calle Francisco Lazo # 180 – Urbanización Santo Dominguito<br>
			Trujillo - Perú<br>
			                        </td>
			                    </tr>
			                </tbody></table>
			                
			            </td>
			        </tr>
			    </tbody>
			</table></td>
			                                        </tr>
			                                    </table>
			                                    <!-- // END FOOTER -->
			                                </td>
			                            </tr>
			                        </table>
			                        <!-- // END TEMPLATE -->
			                    </td>
			                </tr>
			            </table>
			        </center>
			    </body>
			</html>';
			$para		=	$mail;
			$subject	= 	"Reserva de CUBOT realizada";
			$mainheaders	=	"Content-type: text/html; charset=utf-8\r\n";
			$mainheaders	.= 	"From: RAMSLEX ENGINEERING TECHNOLOGIES";

			$envio =  array('band'=>$band,'cod'=>$code, 'msj'=>':)');

			$resultado = mail ($para, $subject, $mensaje, $mainheaders);

			$para1		=	"reserva.cubot@ramslex.com";
			$subject1	= 	"Reserva de CUBOT";
			$mainheaders1	=	"Content-type: text/html; charset=utf-8\r\n";
			$mainheaders1	.= 	"From: ".$mail;
			$resultado1 = mail ($para1, $subject1, $mensaje, $mainheaders1);

			if(!$resultado){
				$success = false;
				$envio   = array('band'=>false,'cod'=>$code, 'msj'=>'Algo salió mal, intente nuevamente');
			}
		}
		if(!$success) {
			mysqli_rollback($conexion);
		} else {
			mysqli_commit($conexion);
		}
		mysqli_close($conexion);
	}
	else{
		$envio =  array('band'=>$band,'cod'=>null,'msj'=>'Captcha incorrecto');
	}
	echo json_encode($envio);
?>